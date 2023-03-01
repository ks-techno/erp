<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\BuyableType;
use App\Models\ProductVariation;
use App\Models\ProductVariationDtl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class ProductVariationController extends Controller{

    private static function Constants()
    {
        $name = 'product-variation';
        return [
            'title' => 'Product Variation',
            'list_url' => route('purchase.product-variation.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
            'view' => "$name-view",
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

            $dataSql = DB::select("
            SELECT
                pv.uuid,
                pv.display_title,
                GROUP_CONCAT(bt.name SEPARATOR ', ') AS buyable_type_name,
                pv.value_type,
                pv.description
            FROM
                product_variations pv
                JOIN product_variation_dtl pvd ON pv.id = pvd.product_variation_id
                JOIN buyable_types bt ON bt.id = pvd.buyable_type_id
            GROUP BY
                pv.uuid,
                pv.display_title,
                pv.value_type,
                pv.description
            ORDER BY
                pv.display_title
        ");
            $allData = $dataSql;      
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
                $urlEdit = route('purchase.product-variation.edit',$row->uuid);
                $urlDel = route('purchase.product-variation.destroy',$row->uuid);

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
                    $row->display_title,
                    $row->buyable_type_name,
                    $row->value_type,
                    $row->description,
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

        return view('purchase.product_variation.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $data['buyable_type'] = BuyableType::Status()->get();

        return view('purchase.product_variation.create', compact('data'));
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
            'buyable_type_id' => 'required|array',
            'display_title' => 'required',
            'value_type' => ['required',Rule::in(['input','select','checkbox','radio','yes_no'])],
        ],[
            'buyable_type_id.required' => 'Product type is required',
            'buyable_type_id.array' => 'Product type is required',
            'display_title.required' => 'Title is required',
            'value_type.required' => 'Value type is required',
            'value_type.in' => 'Value type is required',
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

       // dd($request->toArray());
        DB::beginTransaction();
        try {
            $key_name = trim(strtolower(strtoupper($request->display_title)));
            $key_name = str_replace(' ','_',$key_name);
            $existsKey = ProductVariation::where('key_name',$key_name)->exists();
            if($existsKey){
                $key_name = $key_name."_".time();
            }
            $pv = ProductVariation::create([
                'uuid' => self::uuid(),
                'display_title' => self::strUCWord($request->display_title),
                'key_name' => $key_name,
                'description' => $request->description,
                'value_type' => $request->value_type,
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

            if(count($request->buyable_type_id) != 0){
                foreach ($request->buyable_type_id as $k=>$buyable_type_id){
                    if($request->value_type == 'input'){
                        ProductVariationDtl::create([
                            'uuid' => self::uuid(),
                            'value_type' => $request->value_type,
                            'product_variation_id' => $pv->id,
                            'buyable_type_id' => $buyable_type_id,
                            'sr_no' => 1,
                            'value' => "input",
                            'company_id' => auth()->user()->company_id,
                            'project_id' => auth()->user()->project_id,
                            'user_id' => auth()->user()->id,
                        ]);
                    }else{
                        foreach ($request->options_list as $k=>$options_list){
                            if(empty($options_list['option'])){
                                return $this->jsonErrorResponse($data, 'Option value must be filled');
                            }
                            if(!empty($options_list)){
                                ProductVariationDtl::create([
                                    'uuid' => self::uuid(),
                                    'value_type' => $request->value_type,
                                    'product_variation_id' => $pv->id,
                                    'buyable_type_id' => $buyable_type_id,
                                    'sr_no' => $k+1,
                                    'value' => $options_list['option'],
                                    'company_id' => auth()->user()->company_id,
                                    'project_id' => auth()->user()->project_id,
                                    'user_id' => auth()->user()->id,
                                ]);
                            }
                        }
                    }
                }
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully created');
        return $this->redirect()->route('purchase.product-variation.index');
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
    public function edit(Request $request, $id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        $data['buyable_type'] = BuyableType::Status()->get();

        if(ProductVariation::where('uuid',$id)->exists()){

            $data['current'] = ProductVariation::with('dtl')->where('uuid',$id)->first();
            $data['options_data'] = [];
            $data['buyable_types'] = [];
            foreach ($data['current']->dtl as $dtl){
                $data['options_data'][$dtl['buyable_type_id']][] = $dtl->toArray();
                $data['buyable_types'][$dtl['buyable_type_id']] = $dtl['buyable_type_id'];
            }
        }else{
            abort('404');
        }

        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        return view('purchase.product_variation.edit', compact('data'));
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
            'buyable_type_id' => 'required|array',
            'display_title' => 'required',
            'value_type' => ['required',Rule::in(['input','select','checkbox','radio','yes_no'])],
        ],[
            'buyable_type_id.required' => 'Product type is required',
            'buyable_type_id.array' => 'Product type is required',
            'display_title.required' => 'Title is required',
            'value_type.required' => 'Value type is required',
            'value_type.in' => 'Value type is required',
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

        DB::beginTransaction();
        try {
            $key_name = trim(strtolower(strtoupper($request->display_title)));
            $key_name = str_replace(' ','_',$key_name);

            $pvup = ProductVariation::where('uuid',$id)
                ->update([
                'display_title' => self::strUCWord($request->display_title),
                /*'key_name' => $key_name,*/
                'description' => $request->description,
                'value_type' => $request->value_type,
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);
            $pv = ProductVariation::where('uuid',$id)->first();

            if(count($request->buyable_type_id) != 0){
                ProductVariationDtl::where('product_variation_id',$pv->id)->delete();
                foreach ($request->buyable_type_id as $k=>$buyable_type_id){
                    if($request->value_type == 'input'){
                        ProductVariationDtl::create([
                            'uuid' => self::uuid(),
                            'value_type' => $request->value_type,
                            'product_variation_id' => $pv->id,
                            'buyable_type_id' => $buyable_type_id,
                            'sr_no' => 1,
                            'value' => "input",
                            'company_id' => auth()->user()->company_id,
                            'project_id' => auth()->user()->project_id,
                            'user_id' => auth()->user()->id,
                        ]);
                    }else{
                        foreach ($request->options_list as $k=>$options_list){
                            if(empty($options_list['option'])){
                                return $this->jsonErrorResponse($data, 'Option value must be filled');
                            }
                            if(!empty($options_list)){
                                ProductVariationDtl::create([
                                    'uuid' => self::uuid(),
                                    'value_type' => $request->value_type,
                                    'product_variation_id' => $pv->id,
                                    'buyable_type_id' => $buyable_type_id,
                                    'sr_no' => $k+1,
                                    'value' => $options_list['option'],
                                    'company_id' => auth()->user()->company_id,
                                    'project_id' => auth()->user()->project_id,
                                    'user_id' => auth()->user()->id,
                                ]);
                            }
                        }
                    }
                }
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
        return $this->redirect()->route('purchase.product-variation.index');
        
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

            ProductVariation::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

    public function getProductVariations(Request $request)
    {
        $data = [];


        DB::beginTransaction();
        try{

            $id = $request->buyable_type_id;
            $pvdtls = ProductVariationDtl::with('product_variation')->where('buyable_type_id',$id)->get()->toArray();
            $data['prod_var'] = [];
            foreach ($pvdtls as $pvdtl ){
                $data['prod_var'][$pvdtl['value_type']][$pvdtl['product_variation_id']][] = $pvdtl;
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get variation by buyable type', 200);
    }
}

