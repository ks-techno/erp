<?php

namespace App\Http\Controllers\Sale;

use App\Library\Utilities;
use App\Models\BookingFileStatus;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Department;
use App\Models\Project;
use App\Models\PropertyPaymentMode;
use App\Models\Sale;
use App\Models\SaleSeller;
use App\Models\Staff;
use App\Models\ChallanForm;
use App\Models\Particulars;
use App\Models\ChallanParticular;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\Rule;
use Validator;

class ChallanFormController extends Controller
{
    private static function Constants()
    {
        $name = 'challan-form';
        return [
            'title' => 'Challan Form',
            'list_url' => route('sale.challan-form.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
            'view' => "$name-view",
            'print' => "$name-print",
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

            $dataSql = ChallanForm::with('customer','project','product','file_status','buyable_type')->orderby('created_at','desc');
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
            $print_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['print'])){
                $print_per = true;
            }

            $entries = [];
            foreach ($allData as $row) {
                $posted = $this->getPostedTitle()[$row->status];
                $urlEdit = route('sale.challan-form.edit',$row->uuid);
                $urlDel = route('sale.challan-form.destroy',$row->uuid);
                $urlPrint = route('sale.challan-form.print',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per || $print_per) {
                    $actions .= '<div class="d-inline-flex" style="margin-left:-15px;">';
                    $actions .= '<a class="p-25 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    if($print_per) {
                        $actions .= '<a href="' . $urlPrint . '" target="_blank" class="dropdown-item"><i data-feather="printer" class="me-50"></i>Print</a>';
                    }
                    if($delete_per) {
                        $actions .= '<a href="javascript:;" data-url="'.$urlDel.'" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    }
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per){
                    $actions .= '<a href="'.$urlEdit.'" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->challan_no,
                    $row->product->name,
                    $row->product->buyable_type->name,
                    $row->property_payment_mode->name,
                    $row->customer->name,
                    '<div class="text-center"><span class="badge rounded-pill ' . $posted['class'] . '">' . $posted['title'] . '</span></div>',
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

        return view('sale.challan_form.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $doc_data = [
            'model'             => 'ChallanForm',
            'code_field'        => 'challan_no',
            'code_prefix'       => strtoupper('ch'),
        ];
        $data['code'] = Utilities::challanCode($doc_data);
        $data['customer'] = Customer::get();
        $data['file_status'] = BookingFileStatus::where('status',1)->get();
        $data['property'] = Product::ProductProperty()->get();
        $data['particulars'] = Particulars::where('is_Active',1)->get();
        return view('sale.challan_form.create', compact('data'));
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
           // 'project_id' => ['required',Rule::notIn([0,'0'])],
           // 'product_id' => ['required',Rule::notIn([0,'0'])],
           // 'customer_id' => ['required',Rule::notIn([0,'0'])],
            //'seller_type' => ['required',Rule::in(['dealer','staff'])],
            //'seller_id' => ['required',Rule::notIn([0,'0'])],
        ],[
//            'project_id.required' => 'Project is required',
//            'project_id.not_in' => 'Project is required',
            //'product_id.required' => 'Product is required',
           // 'product_id.not_in' => 'Product is required',
            // 'customer_id.required' => 'Customer is required',
            // 'customer_id.not_in' => 'Customer is required',
           
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
        try{
            $doc_data = [
                'model'             => 'ChallanForm',
                'code_field'        => 'challan_no',
                'code_prefix'       => strtoupper('ch'),
            ];
            $data['code'] = Utilities::challanCode($doc_data);
            if($request->seller_type == 'staff'){
                $modal = Staff::where('id',$request->seller_id)->first();
            }
            if($request->seller_type == 'dealer'){
                $modal = Dealer::where('id',$request->seller_id)->first();
            }
            $total_amount = 0;
            foreach ($request->pd as $pd) {
                $total_amount += str_replace(',', '',($pd['ch_chart_amount']));
            }
            
            $posted = $request->current_action_id == 'post'?1:0;
            $requestdata = 
                [
                    'uuid' => self::uuid(),
                    'challan_no' => $data['code'],
                    'customer_id' => $request->om_customer_id,
                    'project_id' => auth()->user()->project_id,
                    'product_id' => $request->product_id,
                    'property_payment_mode_id' => $request->property_payment_mode_id,
                    'cheque_no' => $request->cheque_no,
                    'cheque_date' => $request->cheque_date,
                    'user_id' => auth()->user()->id,
                    'status' => $posted,
                    'is_active' => 1,
                    'total_amount' => $total_amount,
                ];
            $sale = ChallanForm::create($requestdata);
            $form_id = $sale->id;
            $sr = 1;
            foreach ($request->pd as $pd){
                ChallanParticular::create([
                        'challan_id' => $form_id,
                        'particular_id' => $pd['chart_id1'],
                        'amount' => $pd['ch_chart_amount'],
                    ]);
                    $sr = $sr + 1;
            }
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('sale.challan-form.index');
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
    //    $data['project'] = Project::get();
        $data['property_payment_mode'] = PropertyPaymentMode::where('status',1)->get();
        $data['file_status'] = BookingFileStatus::where('status',1)->get();
        
        if(ChallanForm::where('uuid',$id)->exists()){
            $data['current'] = ChallanForm::with('challan_particluar','customer','project','product','file_status')->where('uuid',$id)->first();
          
            $data['particulars'] = ChallanParticular::with('particular')->where('challan_id',$data['current']->id)->get();
            $data['particular'] = Particulars::where('is_Active',1)->get();
           
        }else{
            abort('404');
        }
        $data['view'] = false;
        $data['posted'] = false;
        if($data['current']->posted == 1){
            $data['posted'] = true;
        }
        if(isset($request->view) || $data['current']->posted == 1){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }
        return view('sale.challan_form.edit', compact('data'));
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
            //'project_id' => ['required',Rule::notIn([0,'0'])],
            // 'product_id' => ['required',Rule::notIn([0,'0'])],
            // 'customer_id' => ['required',Rule::notIn([0,'0'])],
            // 'seller_type' => ['required',Rule::in(['dealer','staff'])],
            // 'seller_id' => ['required',Rule::notIn([0,'0'])],
            // 'currency_note_no'=>'required'
        ],[
            //'project_id.required' => 'Project is required',
            //'project_id.not_in' => 'Project is required',
            // 'product_id.required' => 'Product is required',
            // 'product_id.not_in' => 'Product is required',
            // 'customer_id.required' => 'Customer is required',
            // 'customer_id.not_in' => 'Customer is required',
            // 'seller_type.required' => 'Seller type is required',
            // 'seller_type.in' => 'Seller type is required',
            // 'seller_id.required' => 'Seller is required',
            // 'seller_id.not_in' => 'Seller is required',
            // 'currency_note_no.required'=>'currency is required'
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
            return $this->redirect()->route('sale.challan-form.index');
        }

        DB::beginTransaction();
        try{
            $total_amount = 0;
            foreach ($request->pd as $pd) {
                $total_amount += str_replace(',', '',($pd['ch_chart_amount']));
            }
            
            $posted = $request->current_action_id == 'post'?1:0;
            $requestdata = 
                [
                    'uuid' => $id,
                    'customer_id' => $request->om_customer_id,
                    'project_id' => auth()->user()->project_id,
                    'product_id' => $request->product_id,
                    'property_payment_mode_id' => $request->property_payment_mode_id,
                    'cheque_no' => $request->cheque_no,
                    'cheque_date' => $request->cheque_date,
                    'user_id' => auth()->user()->id,
                    'status' => $posted,
                    'is_active' => 1,
                    'total_amount' => $total_amount,
                ];
            $sale = ChallanForm::where('uuid',$id)
            ->update($requestdata);
           $chalan_id = $request->form_id;
            DB::select("delete FROM `challan_particular` where challan_id = '$chalan_id'");
            $sr = 1;
            foreach ($request->pd as $pd){
                ChallanParticular::create([
                        'challan_id' => $chalan_id,
                        'particular_id' => $pd['chart_id1'],
                        'amount' => $pd['ch_chart_amount'],
                    ]);
                    $sr = $sr + 1;
            }
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
         return $this->jsonSuccessResponse($data, 'Successfully updated');
         return $this->redirect()->route('sale.sale-invoice.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['permission'] = self::Constants()['print'];

        if(ChallanForm::where('uuid',$id)->exists()){
            $data['current'] = ChallanForm::with('challan_particluar','customer','project','product')->where('uuid',$id)->first();
          
            $data['particulars'] = ChallanParticular::with('particular')->where('challan_id',$data['current']->id)->get();
           
        }else{
            abort('404');
        }
 //       dd($data['current']->product->toArray());
        return view('sale.challan_form.print', compact('data'));
    }

    public function getSellerList(Request $request)
    {

        $data = [];

        $seller_type = isset($request->seller_type)?$request->seller_type:"";
        $sellerList = ['dealer','staff'];
        if(!in_array($seller_type ,$sellerList)){
            return $this->jsonErrorResponse($data, "Seller type not correct", 200);
        }
        
        DB::beginTransaction();
        try{
            if($seller_type == 'dealer'){
                $data['seller'] = Dealer::OrderByName()->where('status', 1)->get();
            }

            if($seller_type == 'staff'){
                $data['seller'] = Staff::OrderByName()->get();
                $data['departments'] = Department::OrderByName()->get();
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get seller', 200);
    }
    public function getProductDetail(Request $request)
    {

        $data = [];

        $product_id = isset($request->product_id)?$request->product_id:"";

        DB::beginTransaction();
        try{
            $data['product'] = Product::where('id',$product_id)->first();

            if(empty($data['product'])){
                return $this->jsonErrorResponse($data, "Product not found", 200);
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get product detail', 200);
    }
}
