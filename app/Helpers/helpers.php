<?php

use App\Models\ChartOfAccount;
use App\Models\SaleHistory;

if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        $words = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return 'minus ' . numberToWords(abs($number));
        }

        $string = '';

        if ($number < 21) {
            $string = $words[$number];
        } elseif ($number < 100) {
            $tens = (int)($number / 10) * 10;
            $units = $number % 10;
            $string = $words[$tens];
            if ($units) {
                $string .= ' ' . $words[$units];
            }
        } elseif ($number < 1000) {
            $hundreds = (int)($number / 100);
            $remainder = $number % 100;
            $string = $words[$hundreds] . ' hundred';
            if ($remainder) {
                $string .= ' and ' . numberToWords($remainder);
            }
        } elseif ($number < 1000000) {
            $thousands = (int)($number / 1000);
            $remainder = $number % 1000;
            $string = numberToWords($thousands) . ' thousand';
            if ($remainder) {
                $string .= ' ';
                if ($remainder < 100) {
                    $string .= 'and ';
                }
                $string .= numberToWords($remainder);
            }
        } else {
            $millions = (int)($number / 1000000);
            $remainder = $number % 1000000;
            $string = numberToWords($millions) . ' million';
            if ($remainder) {
                $string .= ' ';
                if ($remainder < 100) {
                    $string .= 'and ';
                }
                $string .= numberToWords($remainder);
            }
        }

        return $string;
    }
}
if (!function_exists('format_number')) {
    function format_number($number) {
        if (floor($number) == $number) {
            return number_format($number,0,'.',',');
        } else {
            return number_format($number,2,'.',',');
        }
    }
    
}
function coaDisplayMaxCode($radioValue,$parent_account_code)
    {
        $parent_account_code = empty($parent_account_code)?NULL:$parent_account_code;

        $code = ChartOfAccount::where('parent_account_code','=',$parent_account_code)->max('code');

        if(empty($code)){
            $code = empty($parent_account_code)?NULL:$parent_account_code;
        }

        $max_code = getMaxChartCode($radioValue,$code);

        return $max_code;

    }
    function getMaxChartCode($radioValue,$chart_code){
        if($radioValue == 1){
            if(empty($chart_code)){
                $max_code = '01-00-0000-0000';
            }else{
                $code = substr($chart_code,0,2);
                $max =  sprintf("%'02d", $code+1);
                $max_code = substr_replace($chart_code,$max,0,2);
                $max_code = $max.'-00-0000-0000';
            }
        }
        if($radioValue == 2){
            $code = substr($chart_code,3,2);
            $max =  sprintf("%'02d", (int)$code+1);
            $max_code = substr_replace($chart_code,$max,3,2);
        }
        if($radioValue == 3){
            $code = substr($chart_code,6,4);
            $max =  sprintf("%'04d", (int)$code+1);
            $max_code = substr_replace($chart_code,$max,6,4);
        }
        if($radioValue == 4){
            $code = substr($chart_code,11,4);
            $max =  sprintf("%'04d", (int)$code+1);
            $max_code = substr_replace($chart_code,$max,11,4);
        }
        return $max_code;
    }
function getDealerTypes() {
    return [
        'main' => 'Main Dealer',
        'sub' => 'Sub Dealer',
    ];
}
function getpaymentModes() {
    return [
        '1' => 'Cash',
        '2' => 'Bank',
    ];
}
function createSaleHistory(array $requestdata)
    {
        return SaleHistory::create($requestdata);
    }
    function updateSaleHistory(array $requestdata, $id)
    {
        return SaleHistory::where('uuid',$id)
                            ->update($requestdata);
    }
    function getParticulars() {
        return [
            '1' => 'Down Payment',
            '2' => 'Instalments',
            '3' => 'Instalment on Balloting',
            '4' => 'Instalment on Possession',
            '5' => 'Location Charges',
            '6' => 'Extra Covered Area',
            '7' => 'Cost Esclation',
            '8' => 'Sub-Division Fee',
            '9' => 'Possession Fee',
            '10' => 'Map Approval',
            '11' => 'Lesco Charges',
            '12' => 'Security & Maintenance',
            '13' => 'Restoration Charges',
            '14' => 'Merging Fee',
            '15' => 'Transfer Fee',
            '16' => 'Other Charges',
        ];
    }