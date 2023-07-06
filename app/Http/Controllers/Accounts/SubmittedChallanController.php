<?php

namespace App\Http\Controllers\Accounts;

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
use App\Models\ChartOfAccount;
use App\Models\Voucher;

class SubmittedChallanController extends Controller
{
    private static function Constants()
    {
        $name = 'submitted-challan';
        return [
            'title' => 'Submitted Challan',
            'list_url' => route('accounts.submitted-challan.index'),
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

            $dataSql = ChallanForm::with('vouchers','customer','project','product','file_status','buyable_type')->where('status', 1)->orderby('created_at','desc');
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
                $link = $row->vouchers->voucher_id ?? $row->uuid;
                $posted = $this->getPostedTitle()[$row->status];
                $urlAdd = route('accounts.submitted-challan.voucherCreate',$row->uuid);
                $urlEdit = route('accounts.submitted-challan.edit',$row->uuid);
                $urlDel = route('accounts.submitted-challan.destroy',$row->uuid);
                $urlPrint = route('accounts.submitted-challan.print',$row->uuid);
                $urlBRV = route('accounts.bank-receive.print',$link);
                $urlCRV = route('accounts.cash-receive.print',$link);
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
                    $actions .= '</div>'; 
                    $actions .= '</div>';
                }
                if($edit_per){
                    if($row->vouchers != null){
                        if($row->vouchers->type == "BRV"){
                        $actions .= '<a href="' . $urlBRV . '" target="_blank" class="item-edit"><i data-feather="eye" class="me-50"></i></a>';
                        }
                        else{
                            $actions .= '<a href="' . $urlCRV . '" target="_blank" class="item-edit"><i data-feather="eye" class="me-50"></i></a>';
                        }
                        $actions .= '<a href="' . $urlEdit . '" target="_blank" class="item-view"></a>';
                    }
                    else{
                    $actions .= '<a href="'.$urlAdd.'" class="item-edit"><i data-feather="plus" class="me-50"></i></a>';
                    $actions .= '<a href="' . $urlEdit . '" target="_blank" class="item-view"></a>';

                    }
                }
                $actions .= '</div>';

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

        return view('accounts.submitted_challan.list', compact('data'));
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
        return $this->redirect()->route('accounts.submitted-challan.index');
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
            $data['current'] = ChallanForm::with('vouchers','challan_particluar','customer','project','product','file_status')->where('uuid',$id)->first();
          
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

        return view('accounts.submitted_challan.edit', compact('data'));
    }


    public function voucherCreate(Request $request, $id){
        $data['permission_list'] = self::Constants()['list'];
        $data['title'] = self::Constants()['title'];
        $data['id'] = $id;
        $data['permission'] = self::Constants()['edit'];
        $data['list_url'] = self::Constants()['list_url'];
        if(ChallanForm::where('uuid',$id)->exists()){
            $challandata = ChallanForm::with('customer')->where('uuid',$id)->first();
            $account = ChartOfAccount::where('id',$challandata->customer->COAID)->first();
            if($challandata->dr_coaid){
               
            }
        }else{
            abort('404');
        }
        if($challandata->dr_coaid)
        {
            $accountDr = ChartOfAccount::where('id',$challandata->dr_coaid)->first();
        }
        elseif($challandata->property_payment_mode_id== 1)
        {
            $accountDr = ChartOfAccount::where('id','46')->first();
        }
        else{
            $accountDr = ChartOfAccount::where('id','47')->first();
        }
        if($challandata->property_payment_mode_id== 1){
            $type = 'CRV';
        }
        else{
            $type = 'BRV';
            
        }
        $max = Voucher::withTrashed()->where('type',$type)->max('voucher_no');
        $voucher_no = self::documentCode($type,$max);
       
        $voucher_id = self::uuid();
        try{
            $form_create =  Voucher::create([
                'voucher_id' => $voucher_id,
                'uuid' => self::uuid(),
                'date' => date('Y-m-d'),
                'type' => $type,
                'voucher_no' => $voucher_no,
                'sr_no' => '1',
                'chart_account_id' => $account->id,
                'chart_account_name' => $account->name,
                'chart_account_code' => $account->code,
                'credit' =>str_replace(',', '',($challandata->total_amount)),
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
                'posted' => '1',
                'total_credit' => $challandata->total_amount,
                'cheque_no' => $challandata->cheque_no,
                'cheque_date' => $challandata->cheque_date,
                'challan_id' => $challandata->id,
            ]);
            $form_create1 =  Voucher::create([
                'voucher_id' => $voucher_id,
                'uuid' => self::uuid(),
                'date' => date('Y-m-d'),
                'type' => $type,
                'voucher_no' => $voucher_no,
                'sr_no' => '1',
                'chart_account_id' => $accountDr->id,
                'chart_account_name' => $accountDr->name,
                'chart_account_code' => $accountDr->code,
                'debit' =>str_replace(',', '',($challandata->total_amount)),
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
                'posted' => '1',
                'total_debit' => $challandata->total_amount,
                'cheque_no' => $challandata->cheque_no,
                'cheque_date' => $challandata->cheque_date,
                'challan_id' => $challandata->id,
            ]);
             $req = [ 
                    'payment_id' => $form_create->id,
                    'COAID' => $account->id,
                    'voucher_id' => $voucher_id,
                ];
                $req1 = [ 
                    'payment_id' => $form_create1->id,
                    'COAID' => $accountDr->id,
                    'voucher_id' => $voucher_id,
                ];
                $reqArray[] = $req;
                $reqArray1[] = $req1;
            Utilities::createLedger($reqArray);
            Utilities::createLedger($reqArray1);
        }
        catch (Exception $e) {
            DB::rollback();
            return view('accounts.submitted_challan.list', compact('data'));
        }
        return view('accounts.submitted_challan.list', compact('data'));
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
            'product_id' => ['required',Rule::notIn([0,'0'])],
            'customer_id' => ['required',Rule::notIn([0,'0'])],
            'seller_type' => ['required',Rule::in(['dealer','staff'])],
            'seller_id' => ['required',Rule::notIn([0,'0'])],
            'currency_note_no'=>'required'
        ],[
            //'project_id.required' => 'Project is required',
            //'project_id.not_in' => 'Project is required',
            'product_id.required' => 'Product is required',
            'product_id.not_in' => 'Product is required',
            'customer_id.required' => 'Customer is required',
            'customer_id.not_in' => 'Customer is required',
            'seller_type.required' => 'Seller type is required',
            'seller_type.in' => 'Seller type is required',
            'seller_id.required' => 'Seller is required',
            'seller_id.not_in' => 'Seller is required',
            'currency_note_no.required'=>'currency is required'
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
            return $this->redirect()->route('sale.sale-invoice.index');
        }

        DB::beginTransaction();
        try{
            $requestdata = [
                'customer_id' => $request->customer_id,
                'sale_by_staff' => ($request->seller_type == 'staff')?1:0,
                'project_id' => auth()->user()->project_id,
                'product_id' => $request->product_id,
                'property_payment_mode_id' => $request->property_payment_mode_id,
                'is_installment' => isset($request->is_installment)?1:0,
                'is_booked' => isset($request->is_booked)?1:0,
                'is_purchased' => isset($request->is_purchased)?1:0,
                'sale_price' => str_replace(',', '',($request->sale_price)),
                'currency_note_no' => empty($request->currency_note_no)?0:$request->currency_note_no,
                'booked_price' => str_replace(',', '',($request->booked_price)),
                'down_payment' => str_replace(',', '',($request->down_payment)),
                'on_balloting' => $request->on_balloting,
                'no_of_bi_annual' => $request->no_of_bi_annual,
                'installment_bi_annual' => $request->installment_bi_annual,
                'no_of_month' => $request->no_of_month,
                'installment_amount_monthly' => $request->installment_amount_monthly,
                'on_possession' => str_replace(',', '',($request->on_possession)),
                'file_status_id' => $request->file_status_id,
                'sale_discount' => str_replace(',', '',($request->sale_discount)),
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id,
                'installment_start_time' => $request->installment_start_time,
                'installment_end_time' => $request->installment_end_time,
                'installment_type' => $request->installment_type,
            ];
            Sale::where('uuid',$id)
                ->update($requestdata);
            updateSaleHistory($requestdata,$id);
            $sale = Sale::where('uuid',$id)->first();

            $saleSeller = new SaleSeller();
            $saleSeller->sale_sellerable_id = $request->seller_id;


            if($request->seller_type == 'staff'){
                $saleSeller->sale_sellerable_type = 'App\Models\Staff';
               // dd($saleSeller->toArray());
                $sale->dealer()->update($saleSeller->toArray());
            }
            if($request->seller_type == 'dealer'){
                $saleSeller->sale_sellerable_type = 'App\Models\Dealer';
                $sale->dealer()->update($saleSeller->toArray());
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
