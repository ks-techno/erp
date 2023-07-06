<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Particulars;
use App\Models\Miscellaneouscharges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class MiscellaneouschargesController extends Controller
{

    private static function Constants()
    {
        $name = 'Miscellaneous Charges';
        return [
            'title' => 'Miscellaneous Charges',
            'list_url' => route('setting.miscellaneous-charges.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
            'view' => "$name-view",
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['projects'] = Project::OrderByName()->get();
        $data['charges'] = Miscellaneouscharges::with('project')->first();
        return view('setting.miscellaneous_charges.create', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $data['projects'] = Project::OrderByName()->get();

        return view('setting.miscellaneous_charges.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'project_id' => ['required',Rule::notIn([0,'0'])],
            'surcharge' => 'required',
            'monthly_maintainance_fee' => 'required',
            'utility_charges' => 'required',
            'other_charges' => 'required',
        ],[
            'project_id.required' => 'Project is required',
            'surcharge.required' => 'Surcharge is required',
            'monthly_maintainance_fee.required' => 'Monthly Maintainance Fee is required',
            'utility_charges.required' => 'Utility Charges Fee is required',
            'other_charges.required' => 'Other Charges Fee is required',
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
        $charges = Miscellaneouscharges::with('project')->first();
        DB::beginTransaction();
        try {
            if($charges){
                $user= [
                    'uuid' => self::uuid(),
                    'surcharge' => $request->surcharge,
                    'monthly_maintainance_fee' => $request->monthly_maintainance_fee,
                    'other_charges' => $request->other_charges,
                    'utility_charges' => $request->utility_charges,
                    'project_id' => $request->project_id,
                ];
                $charge = Miscellaneouscharges::where('uuid',$charges->uuid)
            ->update($user);
            }
            else{
                $user = Miscellaneouscharges::create([
                    'uuid' => self::uuid(),
                    'surcharge' => $request->surcharge,
                    'monthly_maintainance_fee' => $request->monthly_maintainance_fee,
                    'other_charges' => $request->other_charges,
                    'utility_charges' => $request->utility_charges,
                    'project_id' => $request->project_id,
                ]);
            }
           
            $data = [
                ['id' => 16, 'amount' => $request->other_charges],
                ['id' => 17, 'amount' => $request->surcharge],
                ['id' => 18, 'amount' => $request->monthly_maintainance_fee],
                ['id' => 19, 'amount' => $request->utility_charges],
            ];
            foreach ($data as $row) {
                $model = Particulars::find($row['id']);
                $model->amount = $row['amount'];
                $model->save();
            }
          

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('setting.miscellaneous_charges.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        $data['projects'] = Project::OrderByName()->get();

        if(User::where('uuid',$id)->exists()){

            $data['current'] = User::with('projects')->where('uuid',$id)->first();
//dd($data['current']->toArray());
        }else{
            abort('404');
        }
        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        return view('setting.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
           // 'email' => 'required|email|unique:users',
            'project_id' => ['required',Rule::notIn([0,'0'])],
//            'password' => ['required'],
//            'confirm_password' => 'required|same:password'
        ],[
            'name.required' => 'Name is required',
//            'email.required' => 'Email is required',
//            'email.email' => 'Email is required',
//            'email.unique' => 'Email already used',
            'project_id.required' => 'Project is required',
            'project_id.not_in' => 'Project is required',
//            'password.required' => 'Password is required',
//            'confirm_password.required' => 'Confirm Password is required',
//            'confirm_password.same' => 'Confirm Password must be same as password',
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
            $user = User::where('uuid',$id)->first();
            $user->name = self::strUCWord($request->name);
            $user->user_status = isset($request->status)?1:0;
            $user->project_id = $request->project_id;
            $user->company_id = auth()->user()->company_id;
            $user->save();

            if(isset($request->projects)){
                $projects = $request->projects;
            }else{
                $projects = [];
            }

            if(!in_array($request->project_id,$projects)){
                array_push($projects,$request->project_id);
            }

            $userProject = User::find($user->id);
            $userProject->projects()->sync($projects);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong');
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
        return $this->redirect()->route('setting.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [];
        DB::beginTransaction();
        try{

            // User::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

}
