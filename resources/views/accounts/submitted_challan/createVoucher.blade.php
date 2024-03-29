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
    .select2-container--classic .select2-dropdown, .select2-container--default .select2-dropdown {
    border-color: #d8d6de;
    z-index: 99999999;
    position: fixed;
    left: 27%;
    top: 35%;
}
    </style>
@endsection

@section('content')
    @permission($data['permission'])
    <form id="challan_vocuher_create" class="challan_vocuher_create"
     action="{{route('accounts.submitted-challan.storeVoucher',$data['id'])}}"
      method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            </div>
                            
                        <div class="card-link">
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Create</button>
                            <a href="{{$data['list_url']}}"
                            class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                        </div>
                    <div class="card-body mt-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <h6>{{$data['voucher_no']}}</h6>
                            </div>
                            <div class="col-sm-4">
                            <label class="col-form-label">Code <span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="{{ $data['chart_of_account_data']->code }}" id="chart_account_code" name="chart_account_code" readonly="">
                            <input type="text" class="form-control form-control-sm" value="{{ $data['chart_of_account_data']->id }}" id="chart_account_id" name="chart_account_id" readonly="" hidden>
                            </div>
                            <div class="col-sm-4">
                            <label class="col-form-label">Name <span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="{{ $data['chart_of_account_data']->name }}" id="chart_account_name" name="chart_account_name" readonly="">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-1">
                        <h6>Challan Details</h6>
                        <div class="col-sm-4">
                            <label class="col-form-label">Challan No. <span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="{{ $data['current']->challan_no }}" id="challan_no" name="challan_no" readonly="">
                            <input type="text" class="form-control form-control-sm" value="{{ $data['current']->id }}" id="challan_no" name="challan_no" readonly="" hidden>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Challan No. <span class="required">*</span></label>
                            <input type="text" class="form-control form-control-sm" value="{{ $data['current']->challan_no }}" id="challan_no" name="challan_no" readonly="">
                            <input type="text" class="form-control form-control-sm" value="{{ $data['current']->id }}" id="challan_no" name="challan_no" readonly="" hidden>
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
@section('pageJsScript')
   
@endsection

@section('script')
<script src="{{ asset('/pages/accounts/submitted_challan/create.js') }}"></script>
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
        var var_egt_readonly_fields = ['egt_chart_name'];
    </script>
    <script src="{{asset('/js/jquery-12.js')}}"></script>
    <script src="{{asset('/pages/common/erp_grid.js')}}"></script>
    <script src="{{asset('/pages/help/chart_help.js')}}"></script>
    <script src="{{asset('/pages/common/account-calculations.js')}}"></script>
    <script  src="{{asset('/pages/common/number-format.js')}}"></script>
@endsection
