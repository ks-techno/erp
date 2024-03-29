<?php
namespace App\Library;

use App\Http\Controllers\Accounts\ChartOfAccountController;
use App\Models\ChartOfAccount;
use Illuminate\Support\Carbon;
use App\Models\PurchaseDemand;
use App\Models\ChallanForm;
use App\Models\Ledgers;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class Utilities
{
    public static function CompanyId(){
        return ['company_id'=>auth()->user()->company_id];
    }

    public static function CompanyProjectId(){
        return [
            'company_id'=>auth()->user()->company_id,
            'project_id'=>auth()->user()->project_id,
        ];
    }
    public static function challanCode($doc_data){
        $model = $doc_data['model'];
        $code_field = $doc_data['code_field'];
        $code_prefix = $doc_data['code_prefix'];
        $form_type_field = isset($doc_data['form_type_field'])?$doc_data['form_type_field']:"";
        $form_type_value = isset($doc_data['form_type_value'])?$doc_data['form_type_value']:"";

        $modelN = 'App\Models\\'.$model;
        if (!empty($form_type_field) && !empty($form_type_value)){
            $max = $modelN::where($form_type_field,$form_type_value)->max($code_field);
        }else {
            $max = $modelN::max($code_field);
        }
        if (!empty($max)){
            $max = explode('-',$max);
            $max = end($max);
            $max = $max+1;
        }else {
            $max = 1;
        }
        $currentDate = Carbon::now()->format('Ymd');
        $new_code= sprintf("%'05d", $max);
        $code = strtoupper($code_prefix)."-".$currentDate."-".$new_code;
        return $code;
    }
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
    public static function demandCode($doc_data){
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

    public static function createCOA($req){

        $parent_account = $req['parent_account'];
        $level = $req['level'];
        $name = $req['name'];

        $parent_account_dtl = ChartOfAccount::where('code',$parent_account)->first();

        if(!empty($parent_account_dtl)){
            $code = ChartOfAccountController::coaDisplayMaxCode($level,$parent_account);
            try{
               $COA_form = ChartOfAccount::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => ucwords(strtolower(strtoupper(trim($name)))),
                    'code' => $code,
                    'level' => $level,
                    'group' => ($level < 4)?'G':'D',
                    'parent_account_id' => $parent_account_dtl->id,
                    'parent_account_code' => $parent_account,
                    'status' => 1,
                    'company_id' => auth()->user()->company_id,
                    'project_id' => auth()->user()->project_id,
                    'user_id' => auth()->user()->id,
                ]);
                $account_id = $COA_form->id;
                return $account_id;
            }catch (\Exception $e){
                return ['status'=>'error', 'message'=>'Chart of Account not created.'];
            }
        }else{
           
            return ['status'=>'error', 'message'=>'Parent Code not Found.'];
        }

    }

    public static function createLedger($reqArray)
    {
        foreach ($reqArray as $req) {
           
            $payment_id = $req['payment_id'];
            $voucher_id = $req['voucher_id'];
            $COAID = $req['COAID'];
           
            if (!empty($req)) {
                try {
                    Ledgers::create([
                        'payment_id' => $payment_id,
                        'COAID' => $COAID,
                        'voucher_id' => $voucher_id,
                        'company_id' => auth()->user()->company_id,
                        'user_id' => auth()->user()->id,
                    ]);
                } catch (Exception $e) {
                    return $this->jsonErrorResponse($data, $e->getMessage());
                }
            } else {
                return ['status' => 'success', 'message' => 'Ledger Created'];
            }
        }
    }
    public static function updateLedger($reqArray)
    {
        foreach ($reqArray as $req) {
        $voucher_id = $req['voucher_id'];
        DB::select("delete FROM `ledgers` where voucher_id = '$voucher_id'");
        }
            self::createLedger($reqArray);
        
    }     

    public static function NumFormat($num){
        return number_format($num,3,'.','');
    }
}
