<?php

namespace App\Http\Controllers;

use App\Library\Utilities;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['permission'] = 'home-view';
        $date = Carbon::now()->subDays(7);

        $data['today_sale'] = Sale::where('created_at', '>=', Carbon::today())->where(Utilities::CompanyId())->sum('sale_price');
        $data['today_sale'] = $data['today_sale']/1000;

        $data['last_week_sale'] = Sale::where('created_at', '>=', $date)->where(Utilities::CompanyId())->sum('sale_price');
        $data['last_week_sale'] = $data['last_week_sale']/1000;

        $data['current_week_sale'] = Sale::where(Utilities::CompanyId())->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('sale_price');
        $data['current_week_sale'] = $data['current_week_sale']/1000;

        $data['last_month_sale'] = Sale::where(Utilities::CompanyId())->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('sale_price');
        $data['last_month_sale'] = $data['last_month_sale']/1000;

         /*$data['items'] = Sale::select(
             DB::raw("(COUNT(*)) as count"),
             DB::raw("(sum(sale_price)) as price"),
             DB::raw("MONTHNAME(created_at) as month_name"),
         )
         ->whereYear('created_at', date('Y'))
         ->orderBy('created_at','ASC')
         ->groupBy('month_name')
         ->get()
         ->toArray();
         $data['expense'] = [-200000, -400000];


        $data['buyable_types'] = BuyableType::where(Utilities::CompanyId())->get();*/
        $data['buyable_types'] = [
            'Commercial Plots',
            'Plots',
            'House',
            'Apartments'
        ];
        $data['buyable_types'] = [
            ['name'=>'Commercial Plots','image'=>'/assets/images/misc/grid_row_01.png','sold'=>7,'remain'=>1,'receivables'=>'1200K'],
            ['name'=>'Plots','image'=>'/assets/images/misc/grid_row_02.png','sold'=>2,'remain'=>1,'receivables'=>'800K'],
            ['name'=>'House','image'=>'/assets/images/misc/grid_row_03.png','sold'=>3,'remain'=>0,'receivables'=>'100K'],
            ['name'=>'Apartments','image'=>'/assets/images/misc/grid_row_04.png','sold'=>12,'remain'=>6,'receivables'=>'600K'],
        ];

        $data['categories'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'];
        $data['earnings'] = [95, 177, 284, 256, 105, 63, 168, 218, 72, 166,133,122];
        $data['expense'] = [-145, -80, -60, -180, -100, -60, -85, -75, -100,-10,-20,-30];
        return view('home',compact('data'));
    }

    public function projectList(Request $request)
    {
        $data = User::with('projects')->where('id',auth()->user()->id)->first();

        if(!session()->has('user_project')){
            return view('auth.project_list',compact('data'));
        }else{
            return redirect()->route('home');
        }

    }
    public function defaultProjectStore(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'project_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'project_id.required' => 'Project is required',
            'project_id.not_in' => 'Project is required',
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
        }

        DB::beginTransaction();
        try {

            $user = User::with('projects')->where('id',auth()->user()->id)->first();
            $checkExistsProject = false;
            if(!empty($user->projects)){
                foreach ($user->projects as $project){
                    if($project->id == $request->project_id){
                        $checkExistsProject = true;
                    }
                }
            }
            if($checkExistsProject){
                $user->project_id = $request->project_id;
                $user->save();

                session(['user_project' => $request->project_id]);

            }else{
                return $this->jsonErrorResponse($data, "Project not assign to this user");
            }

        }catch (\Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['url'] = route('home');
        return $this->jsonSuccessResponse($data, 'Set Default Project');
    }
}
