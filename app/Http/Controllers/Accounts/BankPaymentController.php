<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\PaymentMode;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class BankPaymentController extends Controller
{
    private static function Constants()
    {
        $name = 'bank-payment';
        return [
            'type' => "BPV",
            'title' => 'Bank Payment',
            'list_url' => route('accounts.bank-payment.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
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

            $allData = $dataSql->get(['voucher_id','voucher_no','date','remarks']);

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
            $entries = [];
            foreach ($allData as $row) {
                $urlEdit = route('accounts.bank-payment.edit',$row->voucher_id);
                $urlDel = route('accounts.bank-payment.destroy',$row->voucher_id);

                $actions = '<div class="text-end">';
                if($delete_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->date,
                    $row->voucher_no,
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

        return view('accounts.bank_payment.list', compact('data'));
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
        $max = Voucher::where('type',self::Constants()['type'])->max('voucher_no');
        $data['voucher_no'] = self::documentCode(self::Constants()['type'],$max);
        $data['payment_mode'] = PaymentMode::where('status',1)->get();
        return view('accounts.bank_payment.create', compact('data'));
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
            'payment_mode' => ['required',Rule::notIn([0,'0'])],
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
        DB::beginTransaction();
        try {

            $max = Voucher::where('type',self::Constants()['type'])->max('voucher_no');
            $voucher_no = self::documentCode(self::Constants()['type'],$max);
            $voucher_id = self::uuid();
            $creditAccount = ChartOfAccount::where('code','01-01-01-0001')->first();

            Voucher::create([
                'voucher_id' => $voucher_id,
                'uuid' => self::uuid(),
                'date' => date('Y-m-d', strtotime($request->date)),
                'type' => self::Constants()['type'],
                'voucher_no' => $voucher_no,
                'sr_no' => 1,
                'chart_account_id' => $creditAccount->id,
                'chart_account_name' => $creditAccount->name,
                'chart_account_code' => $creditAccount->code,
                'payment_mode_id' => $request->payment_mode,
                'debit' => 0,
                'credit' => isset($request->tot_voucher_amount)?$request->tot_voucher_amount:0,
                'description' => '',
                'remarks' => $request->remarks,
            ]);
            $sr = 2;
            $total_amount = 0;
            foreach ($request->pd as $pd){
                $debitAccount = ChartOfAccount::where('id',$pd['chart_id'])->first();
                if(!empty($debitAccount)){
                    Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $debitAccount->id,
                        'chart_account_name' => $debitAccount->name,
                        'chart_account_code' => $debitAccount->code,
                        'payment_mode_id' => $request->payment_mode,
                        'debit' => $pd['egt_amount'],
                        'credit' => 0,
                        'description' => $pd['egt_description'],
                        'remarks' => $request->remarks,
                    ]);
                    $sr = $sr + 1;
                    $total_amount += $pd['egt_amount'];
                }
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        return $this->jsonSuccessResponse($data, 'Successfully created');
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
    public function edit($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        $data['payment_mode'] = PaymentMode::where('status',1)->get();
        if(Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->exists()){

            $data['current'] = Voucher::where('type',self::Constants()['type'])->where(['voucher_id'=>$id,'sr_no'=>1])->first();
            $data['dtl'] = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->where('sr_no','<>',1)->get();

        }else{
            abort('404');
        }

        return view('accounts.bank_payment.edit', compact('data'));
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
            'payment_mode' => ['required',Rule::notIn([0,'0'])],
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
        DB::beginTransaction();
        try {

            $firstVoucher = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->first();
            $voucher_no = $firstVoucher->voucher_no;
            $voucher_id = $id;
            DB::select("delete FROM `vouchers` where voucher_id = '$voucher_id'");
            $creditAccount = ChartOfAccount::where('code','01-01-01-0001')->first();
            Voucher::create([
                'voucher_id' => $voucher_id,
                'uuid' => self::uuid(),
                'date' => date('Y-m-d', strtotime($request->date)),
                'type' => self::Constants()['type'],
                'voucher_no' => $voucher_no,
                'sr_no' => 1,
                'chart_account_id' => $creditAccount->id,
                'chart_account_name' => $creditAccount->name,
                'chart_account_code' => $creditAccount->code,
                'payment_mode_id' => $request->payment_mode,
                'debit' => 0,
                'credit' => isset($request->tot_voucher_amount)?$request->tot_voucher_amount:0,
                'description' => '',
                'remarks' => $request->remarks,
            ]);
            $sr = 2;
            $total_amount = 0;
            foreach ($request->pd as $pd){
                $debitAccount = ChartOfAccount::where('id',$pd['chart_id'])->first();
                if(!empty($debitAccount)){
                    Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $debitAccount->id,
                        'chart_account_name' => $debitAccount->name,
                        'chart_account_code' => $debitAccount->code,
                        'payment_mode_id' => $request->payment_mode,
                        'debit' => $pd['egt_amount'],
                        'credit' => 0,
                        'description' => $pd['egt_description'],
                        'remarks' => $request->remarks,
                    ]);
                    $sr = $sr + 1;
                    $total_amount += $pd['egt_amount'];
                }
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
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
}
