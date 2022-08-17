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

class ProductController extends Controller
{
    private static function Constants()
    {
        return [
            'title' => 'Product',
            'list_url' => route('purchase.product.index'),
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
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Product::where('id','<>',0)->orderByName();

            $allData = $dataSql->get();

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $entries = [];
            foreach ($allData as $row) {
                $entry_status = $this->getStatusTitle()[$row->status];
                $urlEdit = route('purchase.product.edit',$row->uuid);
                $urlDel = route('purchase.product.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                $actions .= '<div class="d-inline-flex">';
                $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                $actions .= '<a href="javascript:;" data-url="'.$urlDel.'" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                $actions .= '</div>'; // end dropdown-menu
                $actions .= '</div>'; // end d-inline-flex
                $actions .= '<a href="'.$urlEdit.'" class="item-edit"><i data-feather="edit"></i></a>';
                $actions .= '</div>'; //end main div

                $entries[] = [
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

        return view('purchase.product.list', compact('data'));
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
        $doc_data = [
            'model'             => 'Product',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('p')
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        $data['suppliers'] = Supplier::where('status',1)->OrderByName()->get();
        $data['manufacturers'] = Manufacturer::where('status',1)->OrderByName()->get();
        $data['brands'] = Brand::where('status',1)->OrderByName()->get();
        $data['categories'] = Category::where('parent_id',null)->OrderByName()->get();
        $data['buyable'] = BuyableType::OrderByName()->get();

        return view('purchase.product.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->toArray());
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'supplier_id' => ['required',Rule::notIn([0,'0'])],
            'manufacturer_id' => ['required',Rule::notIn([0,'0'])],
            'brand_id' => ['required',Rule::notIn([0,'0'])],
            'parent_category' => ['required',Rule::notIn([0,'0'])],
            'category_id' => ['required',Rule::notIn([0,'0'])],
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
                'code_prefix'       => strtoupper('p')
            ];
            $data['code'] = Utilities::documentCode($doc_data);

            $product = Product::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'code' => $data['code'],
                'is_purchase_able' => isset($request->is_purchase_able) ? "1" : "0",
                'is_taxable' => isset($request->is_taxable) ? "1" : "0",
                'status' => isset($request->status) ? "1" : "0",
                'supplier_id' => $request->supplier_id,
                'manufacturer_id' => $request->manufacturer_id,
                'brand_id' => $request->brand_id,
                'parent_category' => $request->parent_category,
                'category_id' => $request->category_id,
                'default_sale_price' => $request->default_sale_price,
                'default_purchase_price' => $request->default_purchase_price,
                'stock_on_hand_units' => $request->stock_on_hand_units,
                'stock_on_hand_packages' => $request->stock_on_hand_packages,
                'sold_in_quantity' => $request->sold_in_quantity,
                'sell_by_package_only' => $request->sell_by_package_only,
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
    public function edit($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];

        if(Product::where('uuid',$id)->exists()){

            $data['current'] = Product::where('uuid',$id)->first();


        }else{
            abort('404');
        }
        $data['suppliers'] = Supplier::where('status',1)->OrderByName()->get();
        $data['manufacturers'] = Manufacturer::where('status',1)->OrderByName()->get();
        $data['brands'] = Brand::where('status',1)->OrderByName()->get();
        $data['categories'] = Category::where('parent_id',null)->OrderByName()->get();

        return view('purchase.product.edit', compact('data'));
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
            Product::where('uuid',$id)
                ->update([
                    'name' => self::strUCWord($request->name),
                    'is_purchase_able' => isset($request->is_purchase_able) ? "1" : "0",
                    'is_taxable' => isset($request->is_taxable) ? "1" : "0",
                    'status' => isset($request->status) ? "1" : "0",
                    'supplier_id' => $request->supplier_id,
                    'manufacturer_id' => $request->manufacturer_id,
                    'brand_id' => $request->brand_id,
                    'parent_category' => $request->parent_category,
                    'category_id' => $request->category_id,
                    'default_sale_price' => $request->default_sale_price,
                    'default_purchase_price' => $request->default_purchase_price,
                    'stock_on_hand_units' => $request->stock_on_hand_units,
                    'stock_on_hand_packages' => $request->stock_on_hand_packages,
                    'sold_in_quantity' => $request->sold_in_quantity,
                    'sell_by_package_only' => $request->sell_by_package_only,
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
