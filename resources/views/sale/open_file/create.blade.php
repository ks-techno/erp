@extends('layouts.form')
@section('title', $data['title'])
@section('style')
<style>
    .new_member_and_nominee{
        padding-bottom:1px !important;
    }
    .transfer_process{
        padding-top:1px !important;
    }
    .txt_color{
        color: #0004f8;
    }
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
        #sellerTable{
            width: 450px;
            position: absolute;
            /* left: 8%;
            top: 100%; */
            height: 230px;
        }
        table{
            background: #bbc8fd;
                position: sticky;
                width: 100% !important;
                max-height: 100% !important;
                overflow-y: scroll !important;
                position: -webkit-sticky
        }
        #sellerTable .tr{
            border: 2px solid #e6e8f3;
        }
        table>thead>tr>th {
                background: #5578eb;
                color: #fff !important;
                border: 2px solid #e6e8f3;
                padding-top: 5px;
                padding-bottom: 5px;
                padding-left: 5px;
            }
            tr:hover{
                cursor: pointer;
            }
            table>tbody>tr>td:hover {
                background: #dedede;
            }
            table>tbody>tr:hover {
                background: #dedede;
            }
            table>tbody>tr>td{
                /*white-space: nowrap;*/
                text-overflow: ellipsis;
                overflow: hidden;
                border: 2px solid #e6e8f3;
                font-weight: 400;
                color: #212529;
                font-size: 12px;
                padding-top: 5px;
                padding-bottom: 5px;
                padding-left: 5px;
            }

</style>
@endsection

@section('content')
@php
    $entry_date = date('Y-m-d');
@endphp
<form id="open_file_create" class="open_file_create" action="{{route('sale.open-file.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" id="form_type" value="booking_transfer">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-left-side">
                        <h4 class="card-title">{{$data['title']}}</h4>
                        
                    </div>
                    <div class="card-link">
                    <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                    <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>   
                </div>
                </div>
               
                <div class="card-body mt-2 new_member_and_nominee">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>{{$data['code']}} </h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="col-form-label p-0">Entry Date: <span class="required">*</span></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" id="entry_date" name="date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($entry_date))}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label class="col-form-label p-0">Status:</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="booking_transfer_status" name="status" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <hr>
                <div class="card-body transfer_process">
                    <h3>Open File Process</h3>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-12 mb-1">
                                <label class="col-form-label p-0">Member <span class="required">*</span></label>
                                <div class="input-group eg_help_block">
                                    <span class="input-group-text" id="om_addon_remove"><i data-feather='minus-circle'></i></span>
                                    <input id="om_customer_name" name="om_customer_name" type="text" class="om_customer_name form-control form-control-sm text-left">
                                    <input id="om_customer_id" type="hidden" class="om_customer_id" name="om_customer_id">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Membership No#</label>
                                    <input type="hidden" class="form-control form-control-sm om_membership_no" value="" id="om_membership_no_input" name="om_membership_no" />
                                    <p class="col-form-label om_membership_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">CNIC No#</label>
                                    <input type="hidden" class="form-control form-control-sm cnic" value="" id="om_cnic_no" name="om_cnic_no" />
                                    <p class="col-form-label om_cnic_no p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <!-- <div class="col-sm-6">
                                    <label class="col-form-label p-0">Registration No#</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_registration_no_input" name="om_registration_no" />
                                    <p class="col-form-label om_registration_no p-0 txt_color"></p>
                                </div> -->
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Mobile No#</label>
                                    <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="" id="om_mobile_no_input" name="om_mobile_no" />
                                    <p class="col-form-label om_mobile_no p-0 txt_color"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h3>Nominee Info</h3>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Nominee Name</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_name_input" name="om_nominee_name" />
                                    <p class="col-form-label om_nominee_name p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">S/O,D/O,W/O Name</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_parent_name_input" name="om_nominee_parent_name" />
                                    <p class="col-form-label om_nominee_parent_name p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Relation With Client </label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_relation_input" name="om_nominee_relation" />
                                    <p class="col-form-label om_nominee_relation_name p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Contact No#</label>
                                    <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="" id="om_nominee_contact_no_input" name="om_nominee_contact_no" />
                                    <p class="col-form-label om_nominee_contact_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">CNIC No# </label>
                                    <input type="hidden" class="form-control form-control-sm cnic" value="" id="om_nominee_cnic_no" name="om_nominee_cnic_no" />
                                    <p class="col-form-label om_nominee_cnic_no p-0 txt_color"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                            <style>
                                .AClass {
                                    right: 100px;
                                    position: absolute;
                                    top: 77px;
                                    width: 1rem;
                                    font-size: larger;
                                    height: 1rem;
                                    background-color: crimson;
                                    border-radius: 20%;
                                }
                                .img_remove{
                                    position: absolute;
                                    top: -6px;
                                    left: 2px;
                                    color:white;
                                }
                            </style>
                            <div style="position: relative;">
                                <a onclick="document.getElementById('om_showImage').src='{{ $img }}'" class="close AClass" id="om_resetInput">
                                    <span class="img_remove">&times;</span>
                                </a>
                                {{-- @dd($img); --}}
                                <img id="om_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: {{session()->get('locale') == 'ar' ?"left":"right"}};">
                            </div>
                            <input class="form-control form-control-sm" type="file" id="om_image_url"  name="om_image"/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body booking_list">
                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <div class="mb-1 row">
                                    <div class="col-sm-12">
                                        <label class="col-form-label p-0">Booking List <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm text-left sellerList" id="booking_name" name="booking_name">
                                        <input type="hidden" id="booking_id" name="booking_id">
                                        <div id="sellerTable"></div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Booking Code</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_booking_code_input" name="booking_code" />
                                        <p class="col-form-label om_booking_code p-0 txt_color"></p>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Plot Number </label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_product_name_input_id" name="product_id" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_product_name_input_name" name="product_name" />
                                        <p class="col-form-label om_product_name p-0 txt_color"></p>
                                    </div>
                                    
                                </div>
                                <div class="mb-1 row">
                                <div class="col-sm-6">
                                        <label class="col-form-label p-0">Down Payment</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_down_payment_input" name="down_payment" />
                                        <p class="col-form-label om_down_payment p-0 txt_color"></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">On Possession</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_on_possession_input" name="on_possession" />
                                        <p class="col-form-label om_on_possession p-0 txt_color"></p>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">File Status</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_file_status_input_id" name="file_status_id" />
                                        <p class="col-form-label om_file_status p-0 txt_color"></p>
                                    </div>
                                     <div class="col-sm-6">
                                        <label class="col-form-label p-0">Registration Number</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_external_item_id_input_id" name="external_item_id" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_external_item_id_input_name" name="external_item_id" />
                                        <p class="col-form-label om_external_item_id p-0 txt_color"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                    <div class="col-sm-6 mb-1">
                                        <label class="col-form-label p-0">Booking Price</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_booked_price_input_id" name="booked_price" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_booked_price_input_name" name="booked_price" />
                                        <p class="col-form-label om_booked_price p-0 txt_color"></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Currency Note</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_currency_note_no_input_id" name="currency_note_no" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_currency_note_no_input_name" name="currency_note_no" />
                                        <p class="col-form-label om_currency_note_no p-0 txt_color"></p>
                                    </div>
                                    
                            </div>
                        </div>
                    </div>{{--end row--}}
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade right" id="createNewCustomer" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" style="">
            <div class="modal-content" id="modal_create_customer">
                <div class="modal-body " style="height:100vh">
                    @include('sale.customer.form')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/open_file/create.js') }}"></script>

@endsection

@section('script')
    <script src="{{ asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{ asset('/pages/help/old_customer_help.js') }}"></script>
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
    <script>
        $(".cnic").inputmask({
            'mask': '99999-9999999-9'
        });

        var entry_date = $('#entry_date');
        if (entry_date.length) {
            entry_date.flatpickr({
                dateFormat: 'd-m-Y',
            });
        }

        // get customer data new member

        function funcGetNewMemberDetail(customer_id) {
            var validate = true;
            if(valueEmpty(customer_id)){
                // ntoastr.error("Select New Customer");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    customer_id : customer_id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.booking-transfer.getCustomerList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var customer = response.data['customer'];
                            var length = customer.length;

                            $('form').find('.nm_membership_no').html(customer.membership_no);
                            $('form').find('#nm_membership_no_input').val(customer.membership_no);

                            $('form').find('.nm_registration_no').html(customer.registration_no);
                            $('form').find('#nm_registration_no_input').val(customer.registration_no);

                            $('form').find('.nm_cnic_no').html(customer.cnic_no);
                            $('form').find('#nm_cnic_no_input').val(customer.cnic_no);

                            $('form').find('.nm_mobile_no').html(customer.mobile_no);
                            $('form').find('#nm_mobile_no_input').val(customer.mobile_no);

                            $('form').find('.nm_nominee_no').html(customer.nominee_no);
                            $('form').find('#nm_nominee_no_input').val(customer.nominee_no);

                            $('form').find('.nm_nominee_name').html(customer.nominee_name);
                            $('form').find('#nm_nominee_name_input').val(customer.nominee_name);

                            $('form').find('.nm_nominee_parent_name').html(customer.nominee_father_name);
                            $('form').find('#nm_nominee_parent_name_input').val(customer.nominee_father_name);

                            $('form').find('.nm_nominee_contact_no').html(customer.nominee_contact_no);
                            $('form').find('#nm_nominee_contact_no_input').val(customer.nominee_contact_no);

                            $('form').find('.nm_nominee_cnic_no').html(customer.nominee_cnic_no);
                            $('form').find('#nm_nominee_cnic_no').val(customer.nominee_cnic_no);

                            $('form').find('.nm_nominee_relation_name').html(customer.nominee_relation);
                            $('form').find('#nm_nominee_relation_input').val(customer.nominee_relation);
                            // $('.nm_customer_name').focusout();
                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });

            }
        }

        //remove customer in new member
        $(document).on('click','#addon_remove',function(){
            $('form').find('.nm_customer_id').val('');

            $('form').find('.nm_membership_no').html('');
            $('form').find('#nm_membership_no_input').val('');

            $('form').find('.nm_registration_no').html('');
            $('form').find('#nm_registration_no_input').val('');

            $('form').find('.nm_cnic_no').html('');
            $('form').find('#nm_cnic_no_input').val('');

            $('form').find('.nm_mobile_no').html('');
            $('form').find('#nm_mobile_no_input').val('');

            $('form').find('.nm_nominee_no').html('');
            $('form').find('#nm_nominee_no_input').val('');

            $('form').find('.nm_nominee_name').html('');
            $('form').find('#nm_nominee_name_input').val('');

            $('form').find('.nm_nominee_parent_name').html('');
            $('form').find('#nm_nominee_parent_name_input').val('');

            $('form').find('.nm_nominee_contact_no').html('');
            $('form').find('#nm_nominee_contact_no_input').val('');

            $('form').find('.nm_nominee_cnic_no').html('');
            $('form').find('#nm_nominee_cnic_no').val('');

            $('form').find('.nm_nominee_relation_name').html('');
            $('form').find('#nm_nominee_relation_input').val('');

        });

        // get customer data old member
        function funcGetOldMemberDetail(customer_id) {
            var validate = true;
            if(valueEmpty(customer_id)){
                // ntoastr.error("Select New Customer");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    customer_id : customer_id
                };
                var buyer = $('#om_customer_id').val();
                var saller = $('#customer_id').val();
                if(buyer==saller){
                    ntoastr.error('Saller and Buyer can not be same');
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.open-file.getCustomerList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var customer = response.data['customer'];
                            var sales = response.data['customer'].sales;
                            var product = response.data['customer'].product;
                            var options = "<option value='0' selected>Select</option>";
                            var length = customer.length;
                            var sales_length = customer.sales.length;

                            
                            table = "<div class='table-wrapper'><table><thead><tr><th>Plot No.</th><th>Block</th></tr></thead><tbody>";
                            for(var i=0;i<sales_length;i++){
                                var products = sales[i].product;
                                var product_length = sales[i].product.length;
                            table += '<tr data-id="'+customer.sales[i]['id']+'" data-name="'+customer.sales[i]['code']+'"><td><b>'+sales[i].product.name+'</b></td><td><b>'+sales[i].product.block+'</b></td></tr>';
                                   // options += '<option value="'+customer.sales[i]['id']+'">'+customer.sales[i]['code']+''+customer.product[i]['block']+'</option>';
                                }   
                            
                                table += "</tbody></table>";
                                $('#sellerTable').html(table);
                            
                            $('form').find('.bookingList').html(options);

                            $('form').find('.om_membership_no').html(customer.membership_no);
                            $('form').find('#om_membership_no_input').val(customer.membership_no);

                            $('form').find('.om_registration_no').html(customer.registration_no);
                            $('form').find('#om_registration_no_input').val(customer.registration_no);

                            $('form').find('.om_cnic_no').html(customer.cnic_no);
                            $('form').find('#om_cnic_no').val(customer.cnic_no);

                            $('form').find('.om_mobile_no').html(customer.mobile_no);
                            $('form').find('#om_mobile_no_input').val(customer.mobile_no);

                            $('form').find('.om_booking_code').html('');
                            $('form').find('#om_booking_id_input').val('');
                            $('form').find('#om_booking_code_input').val('');

                            $('form').find('.om_product_name').html('');
                            $('form').find('#om_product_name_input_id').val('');
                            $('form').find('#om_product_name_input_name').val('');

                            $('form').find('.om_file_status').html('');
                            $('form').find('#om_file_status_input_id').val('');

                            $('form').find('.om_nominee_no').html(customer.nominee_no);
                            $('form').find('#om_nominee_no_input').val(customer.nominee_no);

                            $('form').find('.om_nominee_name').html(customer.nominee_name);
                            $('form').find('#om_nominee_name_input').val(customer.nominee_name);

                            $('form').find('.om_nominee_parent_name').html(customer.nominee_father_name);
                            $('form').find('#om_nominee_parent_name_input').val(customer.nominee_father_name);

                            $('form').find('.om_nominee_contact_no').html(customer.nominee_contact_no);
                            $('form').find('#om_nominee_contact_no_input').val(customer.nominee_contact_no);

                            $('form').find('.om_nominee_cnic_no').html(customer.nominee_cnic_no);
                            $('form').find('#om_nominee_cnic_no').val(customer.nominee_cnic_no);

                            $('form').find('.om_nominee_relation_name').html(customer.nominee_relation);
                            $('form').find('#om_nominee_relation_input').val(customer.nominee_relation);



                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });
            }
        }

        //remove customer in old member
        $(document).on('click','#om_addon_remove',function(){
            $('form').find('.om_customer_id').val('');

            $('form').find('.om_membership_no').html('');
            $('form').find('#om_membership_no_input').val('');

            $('form').find('.om_registration_no').html('');
            $('form').find('#om_registration_no_input').val('');

            $('form').find('.om_cnic_no').html('');
            $('form').find('#om_cnic_no_input').val('');

            $('form').find('.om_mobile_no').html('');
            $('form').find('#om_mobile_no_input').val('');

            $('form').find('.om_nominee_no').html('');
            $('form').find('#om_nominee_no_input').val('');

            $('form').find('.om_nominee_name').html('');
            $('form').find('#om_nominee_name_input').val('');

            $('form').find('.om_nominee_parent_name').html('');
            $('form').find('#om_nominee_parent_name_input').val('');

            $('form').find('.om_nominee_contact_no').html('');
            $('form').find('#om_nominee_contact_no_input').val('');

            $('form').find('.om_nominee_cnic_no').html('');
            $('form').find('#om_nominee_cnic_no').val('');

            $('form').find('.om_nominee_relation_name').html('');
            $('form').find('#om_nominee_relation_input').val('');

            $('form').find('#booking_id').html('');

            $('form').find('.om_booking_code').html('');
            $('form').find('#om_booking_code_input').val('');

            $('form').find('.om_product_name').html('');
            $('form').find('#om_product_name_input').val('');

            $('form').find('.om_file_status').html('');
            $('form').find('#om_file_status_input').val('');

        });

        //Booking Data
        $(document).on('click','#sellerTable tbody tr',function(){
            var validate = true;
            var thix = $(this);
            var val = $(this).attr('data-id');
            //var val = $('#booking_id').val();
           // var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
                ntoastr.error("Select New Booking");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    sale_id : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.booking-transfer.getBookingDtl') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var sales = response.data['sales'];
                            var product = response.data['product'];
                            var length = sales.length;
                            console.log(product);
                            $('form').find('.om_booking_code').html(sales.code);
                            $('form').find('#om_booking_id_input').val(sales.id);
                            $('form').find('#om_booking_code_input').val(sales.code);

                            $('form').find('.om_product_name').html(sales.product.name);
                            $('form').find('#om_product_name_input_id').val(sales.product.id);
                            $('form').find('#om_product_name_input_name').val(sales.product.name);

                            $('form').find('.om_booked_price').html(sales.booked_price);
                            $('form').find('#om_booked_price_input_id').val(sales.booked_price);
                            $('form').find('#om_booked_price_input_name').val(sales.booked_price);

                            $('form').find('.om_down_payment').html(sales.down_payment);
                            $('form').find('#om_down_payment_input_id').val(sales.down_payment);
                            $('form').find('#om_down_payment_input_name').val(sales.down_payment);

                            $('form').find('.om_on_possession').html(sales.on_possession);
                            $('form').find('#om_on_possession_input_id').val(sales.on_possession);
                            $('form').find('#om_on_possession_input_name').val(sales.on_possession);

                            $('form').find('.om_external_item_id').html(sales.product.external_item_id);
                            $('form').find('#om_external_item_id_input_id').val(sales.product.external_item_id);
                            $('form').find('#om_external_item_id_input_name').val(sales.product.external_item_id);

                            $('form').find('.om_currency_note_no').html(sales.currency_note_no);
                            $('form').find('#om_currency_note_no_input_id').val(sales.currency_note_no);
                            $('form').find('#om_currency_note_no_input_name').val(sales.currency_note_no);
                            
                            $('form').find('.om_file_status').html(sales.file_status.name);
                            $('form').find('#om_file_status_input_id').val(sales.file_status.id);

                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });
            }
        });
    </script>
    <script>
        //  $(document).ready(function() {
        //     $('#om_customer_name').on('change', function() {
                
        //     });
        // });
        //Reset Image on Cross Click
        $(document).ready(function() {
            $('#nm_resetInput').on('click', function() {
                $('#nm_image_url').val('');
            });
        });
        //Reset Image on Cross Click
        $(document).ready(function() {
            $('#om_resetInput').on('click', function() {
                $('#om_image_url').val('');
            });
        });
        $(document).on('click','#sellerTable tbody tr',function(){
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        $('#booking_id').val(id);
        $('#booking_name').val(name);
        });
        $(document).on('click','#sellerTable tbody tr',function(){
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        $('#booking_id').val(id);
        $('#booking_name').val(name);
        
        if ($('#booking_name').val() == '') {
            $('#sellerTable').show();
        } else {
            $('#sellerTable').hide();
        }
        });
        $(document).on('change keyup','#booking_name',function(){
        if ($(this).val() == '') {
            $('#sellerTable').show();
        } else {
            $('#sellerTable').hide();
        }
        });

    </script>
    <script type="text/javascript">
        //Show image on change picture
        $(document).ready(function() {
            $('#nm_image_url').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#nm_showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
        //Show image on change picture
        $(document).ready(function() {
            $('#om_image_url').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#om_showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
        $(document).on('keydown', function(e) {
    if ($('.table-wrapper').length) {
        
        var inLineHelp = $('.table-wrapper');
        var scrollHeight = inLineHelp.prop('scrollHeight');
        var scrollTop = inLineHelp.scrollTop();
        var lineHeight = parseInt(inLineHelp.css('line-height'));
        var offsetTop = parseInt(inLineHelp.css('top'));
        var keyCode = e.keyCode;
        if (keyCode == 38) { // up arrow key
            e.preventDefault();
            //$('#egt_cheque_no').focus();
            inLineHelp.scrollTop(scrollTop - lineHeight);
            if (inLineHelp.scrollTop() == 0) {
                inLineHelp.css('top', offsetTop + lineHeight + 'px');
            }
            var selectedRow = inLineHelp.find('.selected');
            if (selectedRow.prev().length) {
                selectedRow.removeClass('selected');
                selectedRow.prev().addClass('selected');
            }
        } else if (keyCode == 40) { // down arrow key
            e.preventDefault();
            //$('#egt_cheque_no').focus();
            inLineHelp.scrollTop(scrollTop + lineHeight);
            if (inLineHelp.scrollTop() + inLineHelp.innerHeight() == scrollHeight) {
                inLineHelp.css('top', offsetTop - lineHeight + 'px');
            }
            var selectedRow = inLineHelp.find('.selected');
            if (selectedRow.next().length) {
                selectedRow.removeClass('selected');
                selectedRow.next().addClass('selected');
            }
        }
        
        
    }
});
    </script>
@endsection

