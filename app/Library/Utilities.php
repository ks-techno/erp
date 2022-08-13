<?php
namespace App\Library;

class Utilities
{
    public static function documentCode($doc_data){
        $model = $doc_data['model'];
        $code_field = $doc_data['code_field'];
        $code_prefix = $doc_data['code_prefix'];

        $modelN = 'App\Models\\'.$model;
        $max = $modelN::max($code_field);
        // max = "SP-0000000", type = "SP"
        if(!empty($max)){
            $max = explode('-',$max);
            $max = end($max);
            $max = $max+1;
        }else{
            $max = 1;
        }
        $new_code =  sprintf("%'05d", $max); // return 12 to 0000012
        $code = strtoupper($code_prefix)."-".$new_code; // return "SP-0000012"
        return $code; // return "SP-0000012"
    }
}
