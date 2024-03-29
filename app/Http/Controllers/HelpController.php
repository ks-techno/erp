<?php

namespace App\Http\Controllers;


use App\Models\ChartOfAccount;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationDtl;
use App\Models\PropertyVariation;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelpController extends Controller
{
    public function chart($val = null)
    {
        $data = [];
        $chart = ChartOfAccount::Wherein('level', [3,4]);
        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
        $data['chart'] =  $chart;

        return view('helps.chart_help',compact('data'));
    }

    public function customer($val = null)
    {
        $data = [];
        $customer = Customer::where('id', '<>', 0)->where('status', 1);
        if (!empty($val)) {
            $val = (string)$val;
            $customer = $customer->where('cnic_no', 'like', "%$val%");
            $customer = $customer->orWhere('name', 'like', "%$val%");
        }

        $customer = $customer->select('id', 'cnic_no', 'name')->get();
        $data['customer'] =  $customer;

        return view('helps.customer_help', compact('data'));
    }
    public function supplier($val = null)
    {
        $data = [];
        $supplier = Supplier::where('id', '<>', 0)->where('status', 1);
        if (!empty($val)) {
            $val = (string)$val;
            $supplier = $supplier->where('contact_no', 'like', "%$val%");
            $supplier = $supplier->orWhere('name', 'like', "%$val%");
        }

        $supplier = $supplier->select('id', 'contact_no', 'name')->get();
        $data['supplier'] =  $supplier;

        return view('helps.supplier_help', compact('data'));
    }

    public function oldCustomerHelp($val = null)
{
    $data = [];
    $customer = Customer::where('id', '<>', 0)
                ->where('status', 1)
                ->has('availableSales');
    if(!empty($val)){
        $val = (string)$val;
        $customer = $customer->where(function ($query) use ($val) {
            $query->where('cnic_no','like',"%$val%")
                ->orWhere('name','like',"%$val%");
        });
    }

    $customer = $customer->select('id', 'cnic_no', 'name')->get();
    $data['old_customer'] = $customer;

    return view('helps.old_customer_help', compact('data'));
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
                $data['seller'] = Dealer::where('status', 1)->OrderByName()->get();
            }

            if($seller_type == 'staff'){
                $data['seller'] = Staff::OrderByName()->get();
            }

        }catch (Exception $e) {
            DB::rollback();
            return view('helps.dealer_help',compact('data'));        }
        DB::commit();
        return view('helps.dealer_help',compact('data'));    }
   
    public function propertyProduct(Request $request)
    {

        
        $sale = Sale::where('project_id',$request->project_id)->whereNull('file_type')->pluck('product_id')->unique()->toArray();
        
        $data = [];
        $product = Product::with('supplier','buyable_type')->whereNotIn('id',$sale)->where('product_form_type', $request->product_form_type)->where('status', 1);
        if(!empty($val)){
            $val = (string)$val;
            $product = $product->where('code','like',"%$val%");
            $product = $product->orWhere('name','like',"%$val%");
        }
        
        $product = $product->get();
        $data['property'] =  $product;
        return view('helps.product_help',compact('data'));
    }
    


}
