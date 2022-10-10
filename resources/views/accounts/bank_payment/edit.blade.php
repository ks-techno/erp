@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
    @endphp
    <form id="bank_payment_edit" class="bank_payment_edit" action="{{route('accounts.bank-payment.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="mb-1 row">
                            <div class="col-sm-12">
                                <h6>{{$current->voucher_no}}</h6>
                            </div>
                        </div>
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
                                        <label class="col-form-label">Payment Mode <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="payment_mode" name="payment_mode">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['payment_mode'] as $payment_mode)
                                                <option value="{{$payment_mode->id}}" {{$current->payment_mode_id == $payment_mode->id?"selected":""}}> {{$payment_mode->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <div class="data_entry_header">
                                    <div class="hiddenFiledsCount" style="display: inline-block;"><span>0</span> fields hide</div>

                                    <div class="dropdown chart-dropdown" style="display: inline-block;">
                                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                        @php
                                            $headings = ['Sr','Account Code','Account Name','Description','Amount'];
                                        @endphp
                                        <ul class="listing_dropdown dropdown-menu dropdown-menu-end">
                                            @foreach($headings as $key=>$heading)
                                                <li class="dropdown-item">
                                                    <label>
                                                        <input value="{{$key}}" type="checkbox" checked> {{$heading}}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
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
                                                    <th width="7%">Sr</th>
                                                    <th width="20%">Account Code</th>
                                                    <th width="22%">Account Name</th>
                                                    <th width="22%">Description</th>
                                                    <th width="16%">Amount</th>
                                                    <th width="13%" class="text-center">Action</th>
                                                </tr>
                                                <tr class="egt_form_header_input">
                                                    <td>
                                                        <input id="egt_sr_no" readonly type="text" class="form-control form-control-sm">
                                                        <input id="chart_id" type="hidden" class="chart_id form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_chart_code" type="text" class="chart_code form-control form-control-sm text-left" placeholder="Press F2">
                                                    </td>
                                                    <td>
                                                        <input id="egt_chart_name" type="text" class="chart_name form-control form-control-sm" readonly>
                                                    </td>
                                                    <td>
                                                        <input id="egt_description" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_amount" type="text" class="NumberValidate amount form-control form-control-sm">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" id="egt_add" class="egt_add btn btn-primary btn-sm">
                                                            <i data-feather='plus'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <tbody class="egt_form_body">
                                                @if(isset( $data['dtl']) && count( $data['dtl']) > 0)
                                                    @foreach($data['dtl'] as $dtl)
                                                        <tr>
                                                            <td class="handle"><i data-feather="move" class="handle egt_handle"></i>
                                                                <input type="text" data-id="egt_sr_no" name="pd[{{$loop->iteration}}][egt_sr_no]"  value="{{$loop->iteration}}" class="form-control form-control-sm" readonly>
                                                                <input type="hidden" data-id="chart_id" name="pd[{{$loop->iteration}}][chart_id]" value="{{$dtl->chart_account_id}}" class="chart_id form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="text" data-id="egt_chart_code" name="pd[{{$loop->iteration}}][egt_chart_code]" value="{{$dtl->chart_account_code}}" class=" chart_code form-control form-control-sm text-left" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" data-id="egt_chart_name" name="pd[{{$loop->iteration}}][egt_chart_name]" value="{{$dtl->chart_account_name}}" class="chart_name form-control form-control-sm" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" data-id="egt_description" name="pd[{{$loop->iteration}}][egt_description]" value="{{$dtl->description}}"  class="form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input type="text" data-id="egt_amount" name="pd[{{$loop->iteration}}][egt_amount]" value="{{number_format($dtl->debit,3)}}" class="NumberValidate amount form-control form-control-sm">
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="egt_btn-group">
                                                                    <button type="button" class="btn btn-danger btn-sm egt_del">
                                                                        <i data-feather="trash-2"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                                <tfoot class="egt_form_footer">
                                                <tr class="egt_form_footer_total">
                                                    <td class="voucher-total-title">Total</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="voucher-total-amt text-end">
                                                        <span id="tot_amount"></span>
                                                        <input id="tot_voucher_amount" name="tot_voucher_amount" type="hidden" >
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-form-label col-lg-2">Remarks:</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control form-control-sm" rows="3" name="remarks" id="remarks">{{$current->remarks}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endpermission
@endsection
@section('pageJs')
    <script src="{{ asset('/pages/accounts/bank_payment/edit.js') }}"></script>
@endsection

@section('script')
    <script>
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
    <script src="{{asset('/pages/common/erp_grid.js')}}"></script>
    <script src="{{asset('/pages/help/chart_help.js')}}"></script>
    <script src="{{asset('/pages/common/account-calculations.js')}}"></script>
@endsection