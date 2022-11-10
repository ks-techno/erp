<?php

namespace App\Http\Controllers;


use App\Models\ChartOfAccount;
use App\Models\Customer;

class HelpController extends Controller
{
    public function chart($val = null)
    {
        $data = [];
        $chart = ChartOfAccount::where('level',4);
        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
//dd($chart);
        $data['chart'] =  $chart;

        return view('helps.chart_help',compact('data'));
    }

    public function customer($val = null)
    {
        $data = [];
        $customer = Customer::where('id','<>',0);
        if(!empty($val)){
            $val = (string)$val;
            $customer = $customer->where('contact_no','like',"%$val%");
            $customer = $customer->orWhere('name','like',"%$val%");
        }

        $customer = $customer->select('id','contact_no','name')->get();
//dd($chart);
        $data['customer'] =  $customer;

        return view('helps.customer_help',compact('data'));
    }
}
