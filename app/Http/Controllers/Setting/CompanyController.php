<?php

namespace App\Http\Controllers\Setting;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;

class CompanyController extends Controller
{

    private static function Constants()
    {
        return [
            'title' => 'Company',
            'list_url' => route('setting.company.index'),
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
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Company::with('country')->where('id','<>',0)->orderByName();

            $allData = $dataSql->get();

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $entries = [];
            foreach ($allData as $row) {
                $urlEdit = route('setting.company.edit',$row->uuid);
                $urlDel = route('setting.company.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                $actions .= '<div class="d-inline-flex">';
                $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                $actions .= '<a href="javascript:;" data-url="'.$urlDel.'" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                $actions .= '</div>'; // end dropdown-menu
                $actions .= '</div>'; // end d-inline-flex
                $actions .= '<a href="'.$urlEdit.'" class="item-edit"><i data-feather="edit"></i></a>';
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->name,
                    $row->contact_no,
                    $row->country->name,
                    $row->address,
                    $actions,
                ];
            }
            $result = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
            ];
            return response()->json($result);
        }

        return view('setting.company.list', compact('data'));
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
        $data['countries'] = Country::OrderByName()->get();
        return view('setting.company.create', compact('data'));
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
            'name' => 'required',
            'country_id' => ['required',Rule::notIn([0,'0'])]
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

            Company::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'country_id' => $request->country_id,
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        return $this->jsonSuccessResponse($data, 'Successfully created');
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
    public function edit($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['countries'] = Country::OrderByName()->get();
        if(Company::where('uuid',$id)->exists()){

            $data['current'] = Company::where('uuid',$id)->first();

        }else{
            abort('404');
        }

        return view('setting.company.edit', compact('data'));
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
            'country_id' => 'required'
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

            Company::where('uuid',$id)
                ->update([
                    'name' => self::strUCWord($request->name),
                    'contact_no' => $request->contact_no,
                    'address' => $request->address,
                    'country_id' => $request->country_id,
                ]);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
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

            Company::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

}