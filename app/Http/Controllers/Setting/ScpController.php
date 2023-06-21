<?php

namespace App\Http\Controllers\Setting;

use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Department;
use App\Models\BuyableType;
use App\Models\ProductVariationDtl;
use App\Models\Project;
use App\Models\PropertyVariation;
use App\Models\PropertyPaymentMode;
use App\Models\Scp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;

class ScpController extends Controller
{

    private static function Constants()
    {
        $name = 'scp';
        return [
            'title' => 'Staff Comission Policy',
            'list_url' => route('setting.scp.index'),
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
       
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Scp::with('buyable_type','department')->orderby('created_at','desc');

            $allData = $dataSql->get();
            
            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);
            $delete_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['delete'])){
                $delete_per = true;
            }
            $edit_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['edit'])){
                $edit_per = true;
            }

            $entries = [];
            foreach ($allData as $row) {
                $urlEdit = route('setting.scp.edit',$row->uuid);
                $urlDel = route('setting.scp.destroy',$row->uuid);
                
                $actions = '<div class="text-end">';
                if($delete_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div
               
               
                $entries[] = [
                    $row->buyable_type->name,
                    $row->department->name,
                    $row->percentage,
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

        return view('setting.scp.list', compact('data'));
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
        $data['permission_create'] = self::Constants()['create'];
        $data['buyable'] = BuyableType::OrderByName()->where('status', 1)->get();
        $data['department'] = Department::OrderByName()->get();
        return view('setting.scp.create', compact('data'));
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
           
            'property_typeID' => 'required',
            'department_id' => 'required',
            'percentage' => 'required',
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
            return $this->redirect()->route('setting.scp.index');
        }

        DB::beginTransaction();
        try {
            $scp = Scp::create([
                'uuid' => self::uuid(),
                'property_typeID' => $request->property_typeID,
                'department_id' => $request->department_id,
                'percentage' => $request->percentage,
            ]);
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong');
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('setting.scp.index');
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
    {;
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data[''] = self::Constants()['edit'];
        

        if(Scp::where('uuid',$id)->exists()){

            $data['current'] = Scp::where('uuid',$id)->first();
            $data['buyable'] = BuyableType::OrderByName()->where('status', 1)->get();
            $data['department'] = Department::OrderByName()->get();
           
        }else{
            abort('404');
        }
        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }
        
        return view('setting.scp.edit', compact('data'));
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
                ]);
            $company = Company::where('uuid',$id)->first();
            $r = self::insertAddress($request,$company);

            if(isset($r['status']) && $r['status'] == 'error'){
                return $this->jsonErrorResponse($data, $r['message']);
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong');
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
        return $this->redirect()->route('company.index');
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
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

}
