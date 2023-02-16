<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Brand;
use App\Models\BuyableType;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class InventoryController extends Controller
{
    private static function Constants()
    {
        $name = 'inventory';
        return [
            'title' => 'Inventory',
            'list_url' => route('purchase.inventory.index'),
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

            $dataSql = Product::where('product_form_type','inventory')->where(Utilities::CompanyId())->orderByName();

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
            $entries = [];
            foreach ($allData as $row) {
                $entry_status = $this->getStatusTitle()[$row->status];
                $urlEdit = route('purchase.inventory.edit',$row->uuid);
                $urlDel = route('purchase.inventory.destroy',$row->uuid);

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
                    $row->code,
                    $row->name,
                    '<div class="text-center"><span class="badge rounded-pill ' . $entry_status['class'] . '">' . $entry_status['title'] . '</span></div>',
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

        return view('purchase.inventory.list', compact('data'));
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
        $doc_data = [
            'model'             => 'Product',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('pi'),
            'form_type_field'        => 'product_form_type',
            'form_type_value'       => 'inventory',
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        $data['suppliers'] = Supplier::where('status',1)->OrderByName()->get();
        $data['manufacturers'] = Manufacturer::where('status',1)->OrderByName()->get();
        $data['brands'] = Brand::where('status',1)->OrderByName()->get();
        $data['categories'] = Category::where('parent_id',null)->OrderByName()->get();
        $data['buyable'] = BuyableType::OrderByName()->get();

        return view('purchase.inventory.create', compact('data'));
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
            'name' => 'required',
            'supplier_id' => ['required',Rule::notIn([0,'0'])],
            'manufacturer_id' => ['required',Rule::notIn([0,'0'])],
            'brand_id' => ['required',Rule::notIn([0,'0'])],
            'parent_category' => ['required',Rule::notIn([0,'0'])],
            'category_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'name.required' => 'Name is required',
            'supplier_id.required' => 'Supplier is required',
            'supplier_id.not_in' => 'Supplier is required',
            'manufacturer_id.required' => 'Manufacturer is required',
            'manufacturer_id.not_in' => 'Manufacturer is required',
            'brand_id.required' => 'Brand is required',
            'brand_id.not_in' => 'Brand is required',
            'parent_category.required' => 'Parent Category Type is required',
            'parent_category.not_in' => 'Parent Category Type is required',
            'category_id.required' => 'Category is required',
            'category_id.not_in' => 'Category is required',
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
            $doc_data = [
                'model'             => 'Product',
                'code_field'        => 'code',
                'code_prefix'       => strtoupper('pi'),
                'form_type_field'        => 'product_form_type',
                'form_type_value'       => 'inventory',
            ];
            $data['code'] = Utilities::documentCode($doc_data);

            $product = Product::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'code' => $data['code'],
                'external_item_id' => $request->external_item_id,
                'is_taxable' => isset($request->is_taxable) ? "1" : "0",
                'status' => isset($request->status) ? "1" : "0",
                'supplier_id' => $request->supplier_id,
                'manufacturer_id' => $request->manufacturer_id,
                'brand_id' => $request->brand_id,
                'parent_category' => $request->parent_category,
                'category_id' => $request->category_id,
                'default_purchase_price' => $request->default_purchase_price,
                'stock_on_hand_units' => $request->stock_on_hand_units,
                'stock_on_hand_packages' => $request->stock_on_hand_packages,
                'product_form_type' => 'inventory',
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

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
    public function edit(Request $request,$id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];

        if(Product::where('uuid',$id)->exists()){

            $data['current'] = Product::where('uuid',$id)->first();


        }else{
            abort('404');
        }

        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        $data['suppliers'] = Supplier::where('status',1)->OrderByName()->get();
        $data['manufacturers'] = Manufacturer::where('status',1)->OrderByName()->get();
        $data['brands'] = Brand::where('status',1)->OrderByName()->get();
        $data['categories'] = Category::where('parent_id',null)->OrderByName()->get();

        return view('purchase.inventory.edit', compact('data'));
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
            'name' => 'required',
            'supplier_id' => ['required',Rule::notIn([0,'0'])],
            'manufacturer_id' => ['required',Rule::notIn([0,'0'])],
            'brand_id' => ['required',Rule::notIn([0,'0'])],
            'parent_category' => ['required',Rule::notIn([0,'0'])],
            'category_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'name.required' => 'Name is required',
            'supplier_id.required' => 'Supplier is required',
            'supplier_id.not_in' => 'Supplier is required',
            'manufacturer_id.required' => 'Manufacturer is required',
            'manufacturer_id.not_in' => 'Manufacturer is required',
            'brand_id.required' => 'Brand is required',
            'brand_id.not_in' => 'Brand is required',
            'parent_category.required' => 'Parent Category Type is required',
            'parent_category.not_in' => 'Parent Category Type is required',
            'category_id.required' => 'Category is required',
            'category_id.not_in' => 'Category is required',
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
            return $this->redirect()->route('purchase.inventory.index');
        }

        DB::beginTransaction();
        try {
            Product::where('uuid',$id)
                ->update([
                    'name' => self::strUCWord($request->name),
                    'external_item_id' => $request->external_item_id,
                    'is_taxable' => isset($request->is_taxable) ? "1" : "0",
                    'status' => isset($request->status) ? "1" : "0",
                    'supplier_id' => $request->supplier_id,
                    'manufacturer_id' => $request->manufacturer_id,
                    'brand_id' => $request->brand_id,
                    'parent_category' => $request->parent_category,
                    'category_id' => $request->category_id,
                    'default_purchase_price' => $request->default_purchase_price,
                    'stock_on_hand_units' => $request->stock_on_hand_units,
                    'stock_on_hand_packages' => $request->stock_on_hand_packages,
                    'product_form_type' => 'inventory',
                    'company_id' => auth()->user()->company_id,
                    'project_id' => auth()->user()->project_id,
                    'user_id' => auth()->user()->id,
                ]);

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
        $data = [];
        DB::beginTransaction();
        try{

            Product::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }
}
