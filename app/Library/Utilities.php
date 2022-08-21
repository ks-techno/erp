<?php
namespace App\Library;

class Utilities
{
    public static function documentCode($doc_data){
        $model = $doc_data['model'];
        $code_field = $doc_data['code_field'];
        $code_prefix = $doc_data['code_prefix'];
        $form_type_field = isset($doc_data['form_type_field'])?$doc_data['form_type_field']:"";
        $form_type_value = isset($doc_data['form_type_value'])?$doc_data['form_type_value']:"";

        $modelN = 'App\Models\\'.$model;
        if(!empty($form_type_field) && !empty($form_type_value)){
            $max = $modelN::where($form_type_field,$form_type_value)->max($code_field);
        }else{
            $max = $modelN::max($code_field);
        }

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
