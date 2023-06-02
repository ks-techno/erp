<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('home',compact('data'));
    }
    public function logintest()
    {
        
        return view('auth.logintest');
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
            return $this->jsonErrorResponse($data, 'Something went wrong');
        }
        DB::commit();
        $data['url'] = route('home');
        return $this->jsonSuccessResponse($data, 'Set Default Project');
    }
}
