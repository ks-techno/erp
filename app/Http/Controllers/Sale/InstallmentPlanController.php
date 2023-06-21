<?php

namespace App\Http\Controllers\Sale;

use App\Library\Utilities;
use App\Models\BookingFileStatus;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Department;
use App\Models\BuyableType;
use App\Models\ProductVariationDtl;
use App\Models\Project;
use App\Models\PropertyVariation;
use App\Models\PropertyPaymentMode;
use App\Models\InstallmentPlan;
use App\Models\SaleSeller;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\Rule;
use Validator;

class InstallmentPlanController extends Controller
{
    private static function Constants()
    {
        $name = 'installment-plan';
        return [
            'title' => 'Installment Plan',
            'list_url' => route('sale.installment-plan.index'),
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

            $dataSql = InstallmentPlan::with('buyable_type','product_variation')->orderby('created_at','desc');
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
                $urlEdit = route('sale.installment-plan.edit',$row->uuid);
                $urlDel = route('sale.installment-plan.destroy',$row->uuid);
                $urlPrint = route('sale.installment-plan.print',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per || $print_per) {
                    $actions .= '<div class="d-inline-flex" style="margin-left:-15px;">';
                    $actions .= '<a class="p-25 ml-x dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
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
                $get_fileType = $row->file_type;
                if($row->file_type == null){
                    $get_fileType = 'Booked';
                }
                $entries[] = [
                    $row->installemnt_plan_name,
                    $row->buyable_type->name,
                    $row->product_variation->display_title,
                   $row->installment_bi_annual,
                   $row->installment_monthly,
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

        return view('sale.installment_plan.list', compact('data'));
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
        $data['buyable'] = BuyableType::OrderByName()->where('status', 1)->get();
        return view('sale.installment_plan.create', compact('data'));
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
            'installemnt_plan_name' => 'required',
            'down_payment'=>'required',
            'on_possession'=>'required',
        ],[
//            'project_id.required' => 'Project is required',
//            'project_id.not_in' => 'Project is required',
            'installemnt_plan_name.required' => 'Plan Name is required',
            
            'down_payment.required' => 'Down Payment is required',
            'on_possession.required' => 'On Possession is required',
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
            if(isset($request->pv) && !empty($request->pv)){
                foreach ($request->pv as $pvId=>$pvVal){
                     $keyValue = $pvVal[0];;
            $requestdata = 
                [
                    'uuid' => self::uuid(),
                    'installemnt_plan_name' => $request->installemnt_plan_name,
                    'product_variation_id' => $pvId,
                    'product_variation_value' => $keyValue,
                    'property_typeID' => $request->buyable_type_id,
                    'total_payment' => $request->total_payment,
                    'down_payment' => $request->down_payment,
                    'on_balloting' => $request->on_balloting,
                    'allocation_amount' => $request->allocation_amount,
                    'installment_bi_annual' => $request->installment_bi_annual,
                    'installment_monthly' => $request->installment_monthly,
                    'on_possession' => $request->on_possession,
                ];
              
                $sale = InstallmentPlan::create($requestdata);
            }
        }
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('sale.installment-plan.index');
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
    public function planDetails(Request $request){
        $data = [];
        $sale_id = isset($request->sale_id)?$request->sale_id:"";
        DB::beginTransaction();
        try{
            
            $data['plans'] = InstallmentPlan::with('buyable_type','product_variation')->where('id',$sale_id)->first();
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get Customer', 200);
        return $this->redirect()->route('sale.installment-plan.index');
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
        $data['buyable'] = BuyableType::OrderByName()->where('status', 1)->get();
        if(InstallmentPlan::where('uuid',$id)->exists()){
            $data['current'] = InstallmentPlan::with('buyable_type','product_variation')->where('uuid',$id)->first();
            $data['property_values'] = [];
            if(!empty($data['current']->product_variation)){
               
                foreach ($data['current']->product_variation as $property_variation){
                   
                    $data['property_values'][$property_variation->id] = $property_variation->key_name;
                }
                $pvdtls = ProductVariationDtl::with('product_variation')->where('buyable_type_id',$data['current']->buyable_type_id)->get()->toArray();
                $data['prod_var'] = [];
                foreach ($pvdtls as $pvdtl ){
                    $data['prod_var'][$pvdtl['value_type']][$pvdtl['product_variation_id']][] = $pvdtl;
                }
            }
        }else{
            abort('404');
        }
        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        return view('sale.installment_plan.edit', compact('data'));
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
            return $this->redirect()->route('sale.installment-plan.index');
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
                'file_status_id' => $request->file_status_id ? $request->file_status_id :1,
                'sale_discount' => str_replace(',', '',($request->sale_discount)),
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id,
                'installment_start_time' => $request->installment_start_time,
                'installment_end_time' => $request->installment_end_time,
                'installment_type' => $request->installment_type,
            ];
            Sale::where('uuid',$id)
                ->update($requestdata);
           
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
            $modelarray = [
                'sale_sellerable_id' => $request->seller_id,
                'sale_sellerable_type' => $saleSeller->sale_sellerable_type
            ];
            $mergarray = array_merge($requestdata,$modelarray);
            updateSaleHistory($mergarray,$id);



        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
         return $this->jsonSuccessResponse($data, 'Successfully updated');
         return $this->redirect()->route('sale.installment-plan.index');
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

        if(Sale::where('uuid',$id)->exists()){

            $data['current'] = Sale::with('product','customer','dealer','staff','property_payment_mode','file_status')->where('uuid',$id)->first();

        }else{
            abort('404');
        }
 //       dd($data['current']->product->toArray());
        return view('sale.installment_plan.print', compact('data'));
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
