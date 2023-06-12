<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\ChartOfAccount;
use App\Models\PaymentMode;
use App\Models\Voucher;
use App\Models\Ledgers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;
use PDF;
use App\Exports\LedgerDataExport;
use Maatwebsite\Excel\Facades\Excel;
class LedgerController extends Controller
{
    private static function Constants()
    {
        $name = 'ledgers';
        return [
            'type' => "BPV",
            'title' => 'Ledgers',
            'list_url' => route('accounts.ledgers.index'),
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
        $chart = ChartOfAccount::Wherein('level', [3,4]);
        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }
        
        $chart = $chart->select('id','code','name')->get();
        $data['chart'] =  $chart;
        $total_debit = 0;
        $total_credit = 0;
        $balance = 0;
        if ($request->ajax()) {
            $draw = 'all'; 
            $chartCode = $request->input('chart_code');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $dataSql = Ledgers::with('voucher')->orderBy('created_at', 'desc');
            if ($chartCode && $startDate && $endDate) {
                $dataSql = $dataSql->where('COAID', $chartCode)
                    ->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($chartCode) {
                $dataSql = $dataSql->where('COAID', $chartCode);
            } elseif ($startDate && $endDate) {
                $dataSql = $dataSql->whereBetween('created_at', [$startDate, $endDate]);
            }
            else{
                $dataSql = Ledgers::with('voucher')
                ->where('created_at', '>=', now()->subDays(15))
                ->orderBy('created_at', 'desc');
            }
           
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
                $posted = $this->getPostedTitle()[$row->voucher->posted];
                $urlEdit = route('accounts.ledgers.edit',$row->voucher->voucher_id);
                $urlDel = route('accounts.ledgers.destroy',$row->voucher->voucher_id);
                $urlPrint = route('accounts.ledgers.print',$row->voucher->voucher_id);


                $actions = '<div class="text-end">';
                if($delete_per || $print_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    if($print_per) {
                        $actions .= '<a href="' . $urlPrint . '" target="_blank" class="dropdown-item"><i data-feather="printer" class="me-50"></i>Print</a>';
                    }
                    if($delete_per) {
                        $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    }
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div
                $total_credit += $row->voucher->credit;
                $total_debit += $row->voucher->debit;
                $balance = $total_credit - $total_debit;
                $entries[] = [
                    $row->voucher->chart_account_name,
                    $row->voucher->chart_account_code,
                    $row->voucher->date,
                    format_number($row->voucher->debit),
                    format_number($row->voucher->credit),
                    format_number($balance),
                    numberToWords($balance).' rupees only',
                   
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

        return view('accounts.ledgers.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function exportPDF(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $chartCode = $request->input('chart_code');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dataSql = Ledgers::with('voucher')->orderBy('created_at', 'desc');
        if ($chartCode && $startDate && $endDate) {
            $dataSql = $dataSql->where('COAID', $chartCode)
                ->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($chartCode) {
            $dataSql = $dataSql->where('COAID', $chartCode);
        } elseif ($startDate && $endDate) {
            $dataSql = $dataSql->whereBetween('created_at', [$startDate, $endDate]);
        }
        else{
            $dataSql = Ledgers::with('voucher')
            ->where('created_at', '>=', now()->subDays(15))
            ->orderBy('created_at', 'desc');
        }
       
        $allData = $dataSql->get();
       
         $data['results'] = $allData;
         
         $pdf = PDF::loadView('accounts.ledgers.pdf', compact('data'));
         return $pdf->download('pdf_file.pdf');
    }

    public function create()
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $max = Voucher::withTrashed()->where('type',self::Constants()['type'])->max('voucher_no');
        $data['voucher_no'] = self::documentCode(self::Constants()['type'],$max);
        $chart = ChartOfAccount::Wherein('level', [3,4]);
        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
        $data['chart'] =  $chart;
      //  $data['payment_mode'] = PaymentMode::where('status',1)->get();
        return view('accounts.ledgers.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    

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
        $data['payment_mode'] = PaymentMode::where('status',1)->get();
        $chart = ChartOfAccount::Wherein('level', [3,4]);
        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
        $data['chart'] =  $chart;
        if(Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->exists()){

            $data['current'] = Voucher::where('type',self::Constants()['type'])->where(['voucher_id'=>$id,'sr_no'=>1])->first();
            $data['dtl'] = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->get();

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

        return view('accounts.ledgers.edit', compact('data'));
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
           // 'payment_mode' => ['required',Rule::notIn([0,'0'])],
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
        if(!isset($request->pd) || empty($request->pd)){
            return $this->jsonErrorResponse($data, 'Grid must be include one row');
        }


        $total_debit = 0;
        $total_credit = 0;
        foreach ($request->pd as $pd) {
            $total_debit += str_replace(',', '',($pd['egt_debit']));
            $total_credit += str_replace(',', '',($pd['egt_credit']));
        }
        if(($total_debit != $total_credit) || (empty($total_debit) && empty($total_credit)) ){
            return $this->jsonErrorResponse($data, 'debit credit must be equal');
        }

        DB::beginTransaction();
        try {

            $firstVoucher = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->first();
            if($firstVoucher->posted == 1){
                return $this->jsonErrorResponse($data, 'This voucher have been already posted');
            }

            $voucher_no = $firstVoucher->voucher_no;
            $voucher_id = $id;
            DB::select("delete FROM `vouchers` where voucher_id = '$voucher_id'");

            $posted = $request->current_action_id == 'post'?1:0;
            $sr = 1;
            foreach ($request->pd as $pd){
                
                $account = ChartOfAccount::where('id',$pd['chart_id'])->first();
                if(!empty($account)){
                $form_create = Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $account->id,
                        'chart_account_name' => $account->name,
                        'chart_account_code' => $account->code,
                        'cheque_no' => $pd['egt_cheque_no'],
                        'cheque_date' => $pd['egt_cheque_date'],
                        'debit' =>str_replace(',', '',($pd['egt_debit'])),
                        'credit' =>str_replace(',', '',($pd['egt_credit'])),
                        'description' => $pd['egt_description'],
                        'remarks' => $request->remarks,
                        'company_id' => auth()->user()->company_id,
                        'project_id' => auth()->user()->project_id,
                        'user_id' => auth()->user()->id,
                        'posted' => $posted,
                        'total_debit' => $total_debit,
                        'total_credit' => $total_credit,
                    ]);
                    $sr = $sr + 1;
                }
                $req = [
                    'payment_id' => $form_create->id,
                    'COAID' => $account->id,
                    'voucher_id' => $voucher_id,
                ];
            
                $reqArray[] = $req;
            }
            Utilities::UpdateLedger($reqArray);
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
        return $this->redirect()->route('accounts.ledgers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [];
        DB::beginTransaction();
        try{

            Voucher::where('voucher_id',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

    public function printView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['permission'] = self::Constants()['print'];

        if(Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->exists()){

            $data['current'] = Voucher::where('type',self::Constants()['type'])->where(['voucher_id'=>$id,'sr_no'=>1])->first();
            $data['dtl'] = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->get();

        }else{

            abort('404');
        }

        return view('accounts.ledgers.print', compact('data'));
    }

    public function revertList(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];

        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Voucher::where('type',self::Constants()['type'])->onlyTrashed()->distinct()->orderby('date','desc');

            $allData = $dataSql->get(['voucher_id','voucher_no','date','posted','remarks']);

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $entries = [];
            foreach ($allData as $row) {
                $posted = $this->getPostedTitle()[$row->posted];
                $urlRevert = route('accounts.ledgers.revert',$row->voucher_id);

                $actions = '<div class="text-end">';
                $actions .= '<a href="javascript:;" data-url="' . $urlRevert . '" class="revert-record">Revert</a>';
                $actions .= '</div>'; //end main div
                $entries[] = [
                    $row->date,
                    $row->voucher_no,
                    '<div class="text-center"><span class="badge rounded-pill ' . $posted['class'] . '">' . $posted['title'] . '</span></div>',
                    $row->remarks,
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

        return view('accounts.ledgers.revert_list', compact('data'));
    }

    public function revert($id){
        $data = [];
        DB::beginTransaction();
        try{

            Voucher::where('voucher_id',$id)->onlyTrashed()->restore();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong', 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully revert', 200);
    }

}
