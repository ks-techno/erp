<?php

namespace App\Http\Controllers;


use App\Models\ChartOfAccount;

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
}
