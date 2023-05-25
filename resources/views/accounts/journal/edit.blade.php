@extends('layouts.form')
@section('title', $data['title'])
@section('style')
    <style>
        .right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 800px;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .show .modal-dialog {
            /*position: absolute;*/right: 0px !important;
        }
        .right.fade .modal-dialog {
            right: -320px;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }
        .right.fade.in .modal-dialog {
            right: 0;
        }
        .table-scroll{
    overflow: visible !important;
}
    </style>
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('accounts.journal.update',$data['id']);
        }
    @endphp
    <form id="journal_edit" class="journal_edit" action="{{isset($url)?$url:""}}"  method="post" enctype="multipart/form-data" autocomplete="off">
        @if(!$data['view'])
            @csrf
            @method('patch')
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            </div>
                              <div class="card-link">  
                            @if($data['view'])
                               @if(!$data['posted'])
                                @permission($data['permission_edit'])
                                <a href="{{route('accounts.journal.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                                @endpermission
                               @endif
                               @else
                          
                              <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                              <button type="submit" name="current_action_id" value="post" class="btn btn-warning btn-sm waves-effect waves-float waves-light">Post</button>
                              <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                         @endif
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <div class="data_entry_header">
                                    <div class="hiddenFiledsCount" style="display: inline-block;"><span>0</span> fields hide</div>

                                    <div class="dropdown chart-dropdown" style="display: inline-block;">
                                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                        @php
                                            $headings = ['Sr','Account Code','Account Name','Description','Debit','Credit'];
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
                                                    <th width="16%">Debit</th>
                                                    <th width="16%">Credit</th>
                                                    <th width="13%" class="text-center">Action</th>
                                                </tr>
                                                <tr class="egt_form_header_input">
                                                    <td>
                                                        <input id="egt_sr_no" readonly type="text" class="form-control form-control-sm">
                                                        <input id="chart_id" type="hidden" class="chart_id form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                    <select class="select2 form-select" id="egt_chart_code" name="egt_chart_code">
                                                    <option value="">Select Value</option>
                                                    @foreach($data['chart'] as $chart)
                                                    <option value="{{$chart->id}}" data-chart-id="{{$chart->id}}" data-chart-name="({{$chart->name}})" data-chart-code="{{$chart->code}}"> {{$chart->code}} - ({{$chart->name}})</option>
                                                    @endforeach
                                                    </select>
                                                    </td>
                                                    <td>
                                                        <input id="egt_chart_name" type="text" class="chart_name form-control form-control-sm" readonly>
                                                    </td>
                                                    <td>
                                                        <input id="egt_description" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_debit" type="text" class="FloatValidate debit form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_credit" type="text" class="FloatValidate credit form-control form-control-sm">
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
                                                                <input data-id="egt_debit" type="text" name="pd[{{$loop->iteration}}][egt_debit]" value="{{ format_number($dtl->debit)}}" class="FloatValidate debit form-control form-control-sm">
                                                            </td>
                                                            <td>
                                                                <input data-id="egt_credit" type="text" name="pd[{{$loop->iteration}}][egt_credit]" value="{{ format_number($dtl->credit)}}" class="FloatValidate credit form-control form-control-sm">
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
                                                    <td class="voucher-total-debit text-end">
                                                        <span id="tot_debit"></span>
                                                        <input id="tot_voucher_debit" name="tot_voucher_debit" type="hidden" >
                                                    </td>
                                                    <td class="voucher-total-credit text-end">
                                                        <span id="tot_credit"></span>
                                                        <input id="tot_voucher_credit" name="tot_voucher_credit" type="hidden" >
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
    <div class="modal fade right" id="createNewCustomer" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" style="">
            <div class="modal-content" id="modal_create_customer">
                <div class="modal-body " style="height:100vh">
                    @include('accounts.chart_of_account.form')
                </div>
            </div>
        </div>
    </div>
    @endpermission
@endsection
@section('pageJs')
    
@endsection

@section('script')
<script src="{{ asset('/pages/accounts/journal/edit.js') }}"></script>
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
