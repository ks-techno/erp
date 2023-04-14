<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Staff;
use App\Models\PurchaseDemand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class PurchaseDemandController extends Controller
{
    private static function Constants()
    {
        $name = 'purchase-demand';
        return [
            'type' => "PD",
            'title' => 'Purchase Demand',
            'list_url' => route('purchase.purchase-demand.index'),
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
            
            $dataSql = PurchaseDemand::with('satff')->Orderby('date','desc');
            
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
                $urlEdit = route('purchase.purchase-demand.edit',$row->purchaseDemand_id);
                $urlDel = route('purchase.purchase-demand.destroy',$row->purchaseDemand_id);
                $urlPrint = route('purchase.purchase-demand.edit',$row->purchaseDemand_id);

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
                $entries[] = [
                    $row->date,
                    $row->purchaseDemand_id,
                    Str::limit($row->notes, 20, '....'),
                    $row->purchaseDemand_id,
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
        return view('purchase.purchase_demand.list');
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
        $data['staff'] = Staff::OrderByName()->get();
        $doc_data = [
            'model'             => 'PurchaseDemand',
            'code_field'        => 'purchaseDemand_id',
            'code_prefix'       => strtoupper('pd'),
        ];
        $data['code'] = Utilities::demandCode($doc_data);
        return view('purchase.purchase_demand.create', compact('data'));
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
            'demandBy_id' => 'required',
        ],
        [
            'demandBy_id.required' => 'Demand by is required',
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
            $doc_data = [
                'model'             => 'PurchaseDemand',
                'code_field'        => 'purchaseDemand_id',
                'code_prefix'       => strtoupper('pd'),
            ];
            $data['code'] = Utilities::demandCode($doc_data);
            $sr = 1;
            foreach ($request->pd as $pd){
                PurchaseDemand::create([
                        'purchaseDemand_id' => $data['code'],
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'sr_no' => $sr,
                        'uom' => $pd['uom'],
                        'packing' => $pd['packing'],
                        'supplier_id' => $request->supplier_id,
                        'demandBy_id' => $request->demandBy_id,
                        'product_id' => $request->product_id,
                        'physical_stock' => $pd['physical_stock'],
                        'store_stock' => $pd['store_stock'],
                        'reorder' => $pd['reorder'],
                        'consumption' => $pd['consumption'],
                        'quantity' => $pd['quantity'],
                        'lpo_stock' => $pd['lpo_stock'],
                        'notes' => $request->notes,
                    ]);
                    $sr = $sr + 1;
               
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('purchase.purchase_demand.index');
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

        return view('purchase.purchase_demand.edit', compact('data'));
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
        return $this->redirect()->route('purchase.purchase_demand.index');
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

        return view('purchase.purchase_demand.print', compact('data'));
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
                $urlRevert = route('accounts.journal.revert',$row->voucher_id);

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

        return view('purchase.purchase_demand.revert_list', compact('data'));
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