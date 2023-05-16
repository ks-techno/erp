<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\ChartOfAccount;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class JournalController extends Controller
{
    private static function Constants()
    {
        $name = 'journal';
        return [
            'type' => "JV",
            'title' => 'Journal',
            'list_url' => route('accounts.journal.index'),
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

            $dataSql = Voucher::where('type',self::Constants()['type'])->distinct()->orderby('date','desc');

            $allData = $dataSql->get(['voucher_id','voucher_no','date','posted','debit','credit']);

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
                $posted = $this->getPostedTitle()[$row->posted];
                $urlEdit = route('accounts.journal.edit',$row->voucher_id);
                $urlDel = route('accounts.journal.destroy',$row->voucher_id);
                $urlPrint = route('accounts.journal.print',$row->voucher_id);

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
                $totalamount = 0;
                $totalamount += $row->debit;
                if($totalamount==0){
                    $totalamount += $row->credit;
                }
                
                $entries[] = [
                    $row->date,
                    $row->voucher_no,
                    '<div class="text-center"><span class="badge rounded-pill ' . $posted['class'] . '">' . $posted['title'] . '</span></div>',
                   $totalamount,
                    $row->prepared_by,
                //    '<div class="signature-field"></div>',
                    $row->approved_by,
                //    '<div class="signature-field"></div>',
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

        return view('accounts.journal.list', compact('data'));
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
        // Add the name of the person who prepared the voucher
        $data['prepared_by'] = auth()->user()->name;

        // Add a space for the signature of the approver
        $data['approver_signature'] = '';

    // Add two rows to the grid by default
    $data['pd'] = [
        [
            'chart_id' => '',
            'egt_debit' => '',
            'egt_credit' => '',
            'egt_description' => '',
        ],
        [
            'chart_id' => '',
            'egt_debit' => '',
            'egt_credit' => '',
            'egt_description' => '',
        ]
    ];


        return view('accounts.journal.create', compact('data'));
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
            $max = Voucher::withTrashed()->where('type',self::Constants()['type'])->max('voucher_no');
            $voucher_no = self::documentCode(self::Constants()['type'],$max);
            $voucher_id = self::uuid();

            $posted = $request->current_action_id == 'post'?1:0;
            $sr = 1;
            foreach ($request->pd as $pd){
                $account = ChartOfAccount::where('id',$pd['chart_id'])->first();
                if(!empty($account)){
                    Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $account->id,
                        'chart_account_name' => $account->name,
                        'chart_account_code' => $account->code,
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
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong');
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('accounts.journal.index');
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

        return view('accounts.journal.edit', compact('data'));
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
                    Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $account->id,
                        'chart_account_name' => $account->name,
                        'chart_account_code' => $account->code,
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
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, 'Something went wrong');
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
        return $this->redirect()->route('accounts.journal.index');
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

        return view('accounts.journal.print', compact('data'));
    }

       public function revertList(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];

        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Voucher::where('type',self::Constants()['type'])->onlyTrashed()->distinct()->orderby('date','desc');

            $allData = $dataSql->get(['voucher_id','voucher_no','date','posted','total_debit']);

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $entries = [];
            foreach ($allData as $row) {
                $posted = $this->getPostedTitle()[$row->posted];
                $urlRevert = route('accounts.journal.revert',$row->voucher_id);

                $actions = '<div class="text-end">';
                $actions .= '<a href="javascript:;" data-url="' . $urlRevert . '" class="revert-record">Revert</a>';
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->date,
                    $row->voucher_no,
                    '<div class="text-center"><span class="badge rounded-pill ' . $posted['class'] . '">' . $posted['title'] . '</span></div>',
                    $row->total_debit,
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

        return view('accounts.journal.revert_list', compact('data'));
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