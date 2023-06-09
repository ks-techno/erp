@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    {{-- @permission($data['permission']) --}}
    <form id="purchaseDemand_create" class="purchaseDemand_create" action="{{route('purchase.purchase-demand.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>

                        </div>
                        <div class="card-link">
                        <button type="submit" name="current_action_id" value="store" class="btn btn-success btn-sm waves-effect waves-float waves-light">Create</button>
                        </div>

                    </div>
                    <div class="card-body mt-2">
                        {{-- <div class="mb-1 row">
                            <div class="col-sm-12">
                                <h6>query code</h6>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Date <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="date" name="date" class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD" value="{{date('Y-m-d')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Demand By <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                    <select class="select2 form-select" id="demandBy_id" name="demandBy_id">
                                            <option value="0" selected>Select</option>
                                            {{-- @foreach($data['staff'] as $satffs)
                                                <option value="{{$satffs->id}}"> {{$satffs->name}} </option>
                                            @endforeach --}}
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-lg-12">
                                <div id="erp_grid_table" class="egt">
                                    <div class="erp_form___block">
                                        <div class="table-scroll form_input__block">
                                            <table class="egt_form_table table table-bordered">
                                                <thead class="egt_form_header">
                                                <tr class="egt_form_header_title">
                                                    <th width="">Sr</th>
                                                    <th width="">Product</th>
                                                    <th width="">Supplier</th>
                                                    <th width="">UOM</th>
                                                    <th width="">packing</th>
                                                    <th width="">Physical Stock</th>
                                                    <th width="">Store Stock</th>
                                                    <th width="">Suggest Reorder</th>
                                                    <th width="">Suggest Consumption</th>
                                                    <th width="">Demand QTY</th>
                                                    <th width="">LPO Stock</th>
                                                    <th width="" class="text-center">Action</th>
                                                </tr>
                                                <tr class="egt_form_header_input">
                                                    <td>
                                                        <input id="egt_sr_no" readonly type="text" class="form-control form-control-sm">
                                                        <input id="chart_id" type="hidden" class="chart_id form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                    <div class="input-group eg_help_block">
                                                        <input id="product_name" type="text" class="product_name form-control form-control-sm text-left">
                                                        <input id="product_id" type="hidden" name="product_id">
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <input id="supplier_name"  type="text" class="supplier_name form-control form-control-sm text-left">
                                                    <input id="supplier_id" type="hidden" name="supplier_id">
                                                    </td>
                                                    <td>
                                                        <input id="uom" name="uom" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="packing" name="packing" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="physical_stock" name="physical_stock" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="store_stock" name="store_stock" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="reorder" name="reorder" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="consumption" name="consumption" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="quantity" name="quantity" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="lpo_stock" name="lpo_stock" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" id="egt_add" class="egt_add btn btn-primary btn-sm">
                                                            <i data-feather='plus'></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                                </thead>
                                                <tbody class="egt_form_body">
                                                </tbody>
                                                <tfoot class="egt_form_footer">
                                                <tr class="egt_form_footer_total">
                                                    <td colspan="9" class="voucher-total-title">Total Quantity</td>
                                                    <td class="voucher-total-credit text-end">
                                                        <input id="total_qty" name="" type="hidden" >
                                                    </td>

                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-8">
                                <div class="row">
                                    <label class="col-form-label col-lg-2">Notes:</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control form-control-sm" rows="3" name="notes" id="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-lg-8">
                        <div class="row">

                    </div>
                    </div>


              </div>
            </div>
        </div>
    </form>

    {{-- @endpermission --}}
@endsection
@section('pageJs')

@endsection

@section('script')
<script src="{{ asset('/pages/purchase/purchase_demand/create.js') }}"></script>
    <script>
         var current_project_id = '{{auth()->user()->project_id}}';
         var product_form_type = 'inventory';
        var var_egt_fields = [

        ];
        var var_egt_required_fields = [
            {
                'id' : 'egt_chart_name',
                'message' : 'Account Name is required'
            },
            {
                'id' : 'egt_amount',
                'message' : 'Amount is required'
            }

        ];
        var var_egt_readonly_fields = ['egt_chart_code','egt_chart_name'];
    </script>
    <script src="{{asset('/js/jquery-12.js')}}"></script>
    <script src="{{asset('/pages/help/product_help.js')}}"></script>
    <script src="{{asset('/pages/common/erp_grid_single.js')}}"></script>

@endsection
