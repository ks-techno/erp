@extends('layouts.form')
@section('title', $data['title'])
@section('style')
<style>
        .txt_color{
        color: #0004f8;
    }
        .text-right{
            margin-left: 670px;
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
    @permission($data['permission'])
    @php
        $current = $data['current'];
        // dd($current->toArray());
        if(!$data['view']){
            $url = route('sale.open-file.update',$data['id']);
        }
    @endphp
    <form id="refund_file_edit" class="refund_file_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                @permission($data['permission_edit'])
                                
                                <a href="{{route('sale.refund-file.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                               
                                @endpermission
                                @else
                               
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                        <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                         @endif
                        </div>
                    </div>
                    <div class="card-body mt-2 new_member_and_nominee">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4>{{$current->code}} </h4>
                                <input id="code" type="hidden" class="code" name="code" value="{{ $current->code }}">
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label p-0">Entry Date: <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="entry_date" name="date" value="{{date('d-m-Y', strtotime($current->file_date))}}" class="form-control form-control-sm" />
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
                            <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="col-form-label p-0">File Type:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                    <select class="select2 form-select" id="file_type" name="file_type">
                                        <option value="" selected>Select File Type </option>
                                        <option value="Refund" data-slug="Refund" {{ $current->file_type == 'Refund' ? 'selected' : '' }}> Refund File </option>
                                        <option value="Merge" data-slug="Merge" {{ $current->file_type == 'Merge' ? 'selected' : '' }}> Merge File </option>
                                    </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="refund_type" style="display: none" >
                                <div class="col-sm-4">
                                    <label class="col-form-label p-0">Refund Type:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                    <input type="radio" id="cancel" name="refund_type" value="Cancel" {{ ($current->refund_type =='Cancel')? "checked" : "" }}>
                                    <label for="cancel">Cancel</label><br>
                                    <input type="radio" id="withdrawal" name="refund_type" value="Withdrawal" {{ ($current->refund_type =='Withdrawal')? "checked" : "" }}> 
                                    <label for="withdrawal">Withdrawal</label><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <label class="col-form-label p-0">Reason:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                    <textarea class="form-control form-control-sm" value="{{ $current->notes }}" rows="3" name="notes" id="notes">{{ $current->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="card-body transfer_process">
                        <h3>Refund/Merg File Process</h3>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="col-sm-12 mb-1">
                                    <label class="col-form-label p-0">Customer</label>
                                    <div class="input-group eg_help_block">
                                        <span class="input-group-text om_addon_remove" id="om_addon_remove"><i data-feather='minus-circle'></i></span>
                                        <input id="om_customer_name" name="om_customer_name" type="text" class="om_customer_name form-control form-control-sm text-left" value="{{ $current->customer->name}}">
                                        <input id="om_customer_id" type="hidden" class="om_customer_id" name="om_customer_id" value="{{ $current->om_customer_id}}">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Membership No#</label>
                                        <input type="hidden" class="form-control form-control-sm om_membership_no" value="{{ $current->customer->membership_no}}" id="om_membership_no_input" name="om_membership_no" />
                                        <p class="col-form-label om_membership_no p-0 txt_color">{{ $current->customer->membership_no}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">CNIC No# <span class="required">*</span></label>
                                        <input type="hidden" class="form-control form-control-sm cnic" value="{{ $current->customer->cnic_no}}" id="om_cnic_no" name="om_cnic_no" />
                                        <p class="col-form-label om_cnic_no p-0 txt_color">{{ $current->customer->cnic_no}}</p>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <!-- <div class="col-sm-6">
                                        <label class="col-form-label p-0">Registration No#</label>
                                        <input type="hidden" class="form-control form-control-sm" value="{{ $current->om_registration_no}}" id="om_registration_no_input" name="om_registration_no" />
                                        <p class="col-form-label om_registration_no p-0 txt_color">{{ $current->om_registration_no}}</p>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Mobile No#</label>
                                        <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="{{ $current->customer->mobile_no}}" id="om_mobile_no_input" name="om_mobile_no" />
                                        <p class="col-form-label om_mobile_no p-0 txt_color">{{ $current->customer->mobile_no}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <h3>Nominee Info</h3>
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Nominee Name</label>
                                        <input type="hidden" class="form-control form-control-sm" value="{{ $current->customer->nominee_name}}" id="om_nominee_name_input" name="om_nominee_name" />
                                        <p class="col-form-label om_nominee_name p-0 txt_color">{{ $current->customer->nominee_name}}</p>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">S/O, D/O,W/O Name</label>
                                        <input type="hidden" class="form-control form-control-sm" value="{{$current->customer->nominee_parent_name}}" id="om_nominee_parent_name_input" name="om_nominee_parent_name" />
                                        <p class="col-form-label om_nominee_parent_name p-0 txt_color">{{ $current->customer->nominee_parent_name}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Relation With Client </label>
                                        <input type="hidden" class="form-control form-control-sm" value="{{ $current->customer->nominee_relation}}" id="om_nominee_relation_input" name="om_nominee_relation" />
                                        <p class="col-form-label om_nominee_relation_name p-0 txt_color">{{ $current->customer->nominee_relation}}</p>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Contact No#</label>
                                        <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="{{ $current->customer->nominee_contact_no}}" id="om_nominee_contact_no_input" name="om_nominee_contact_no" />
                                        <p class="col-form-label om_nominee_contact_no p-0 txt_color">{{ $current->customer->nominee_contact_no}}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">CNIC No# </label>
                                        <input type="hidden" class="form-control form-control-sm cnic" value="{{ $current->customer->nominee_cnic_no}}" id="om_nominee_cnic_no" name="om_nominee_cnic_no" />
                                        <p class="col-form-label om_nominee_cnic_no p-0 txt_color">{{ $current->customer->nominee_cnic_no}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->om_image;@endphp
                                @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                                @php $img = $root.'/uploads/'.$image_url; @endphp
                                @else
                                @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                                @endif
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
                                    <a onclick="document.getElementById('om_showImage').src='{{ $img }}'" value="{{ $image_url }}" class="close AClass" id="om_resetInput">
                                        <span class="img_remove">&times;</span>
                                    </a>
                                    <img id="om_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: right;">
                                </div>
                                <input class="form-control form-control-sm" value="{{ $image_url }}" type="file" id="om_image_url" name="om_image"/>
                                <input type="hidden" value="{{ $image_url }}" name="om_hidden_image" id="om_hidden_avatar">
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
                                            <label class="col-form-label p-0">Booking List</label>
                                          
                                                <input type="text" class="form-control form-control-sm text-left sellerList" id="booking_name" value="{{ $current->code }}" name="booking_name">
                                                <input type="hidden" id="booking_id" name="booking_id" value="{{ $current->id }}">
                                                

                                        <div id="sellerTable"></div>
                                      
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-1 row">
                                        <div class="col-sm-6">
                                            <label class="col-form-label p-0">Booking Code</label>
                                            <input type="hidden" class="form-control form-control-sm" value="{{ $current->booking_id}}" id="om_booking_id_input" name="booking_id" />
                                            <input type="hidden" class="form-control form-control-sm" value="{{ $current->booking_code}}" id="om_booking_code_input" name="booking_code" />
                                            <p class="col-form-label om_booking_code p-0 txt_color">{{ $current->booking_code}}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label p-0">Plot Numner</label>
                                            <input type="hidden" class="form-control form-control-sm" value="{{ $current->product_id}}" id="om_product_name_input_id" name="product_id" />
                                            <input type="hidden" class="form-control form-control-sm" value="{{ $current->product_name}}" id="om_product_name_input_name" name="product_name" />
                                            <p class="col-form-label om_product_name p-0 txt_color">{{ $current->product_name}}</p>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                    <div class="col-sm-6">
                                            <label class="col-form-label p-0">Down Payment</label>
                                            <input type="hidden" class="form-control form-control-sm" value="" id="om_down_payment_input" name="down_payment" />
                                            <p class="col-form-label om_down_payment p-0 txt_color">{{ isset($current->sales->down_payment) ? $current->sales->down_payment : '' }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label p-0">On Possession</label>
                                            <input type="hidden" class="form-control form-control-sm" value="" id="om_on_possession_input" name="on_possession" />
                                            <p class="col-form-label om_on_possession p-0 txt_color">{{ isset($current->sales->on_possession) ? $current->sales->on_possession : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <div class="col-sm-6">
                                            <label class="col-form-label p-0">File Status</label>
                                            <input type="hidden" class="form-control form-control-sm" value="{{ $current->file_status->id}}" id="om_file_status_input_id" name="file_status_id" />
                                            <p class="col-form-label om_file_status p-0 txt_color">{{ $current->file_status->name}}</p>
                                        </div>
                                        <div class="col-sm-6">
                                        <label class="col-form-label p-0">Registration Number</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_external_item_id_input_id" name="external_item_id" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_external_item_id_input_name" name="external_item_id" />
                                        <p class="col-form-label om_external_item_id p-0 txt_color">{{ $current->product->external_item_id }}</p>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                <div class="col-sm-6 mb-1">
                                        <label class="col-form-label p-0">Booking Price</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_booked_price_input_id" name="booked_price" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_booked_price_input_name" name="booked_price" />
                                        <p class="col-form-label om_booked_price p-0 txt_color">{{ isset($current->sales->booked_price) ? $current->sales->booked_price : '' }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Currency Note</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_currency_note_no_input_id" name="currency_note_no" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_currency_note_no_input_name" name="currency_note_no" />
                                        <p class="col-form-label om_currency_note_no p-0 txt_color">{{ isset($current->sales->on_possession) ? $current->sales->on_possession : ''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>{{--end row--}}
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/refund_file/edit.js') }}"></script>
    <script src="{{ asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{ asset('/pages/help/old_customer_help.js') }}"></script>

@endsection

@section('script')
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
                            var sales = response.data['customer'].sales;
                            var product = response.data['customer'].product;
                            var options = "<option value='0' selected>Select</option>";
                            var length = customer.length;
                            var sales_length = customer.sales.length;

                            console.log(product);
                            table = "<div class='table-wrapper'><table><thead><tr><th>Plot No.</th><th>Block</th></tr></thead><tbody>";
                            for(var i=0;i<sales_length;i++){
                                if(customer.sales[i]['code']){
                            table += '<tr data-id="'+customer.sales[i]['id']+'" data-name="'+customer.sales[i]['code']+'"><td><b>'+customer.product[i]['name']+'</b></td><td><b>'+customer.product[i]['block']+'</b></td>';
                                   // options += '<option value="'+customer.sales[i]['id']+'">'+customer.sales[i]['code']+''+customer.product[i]['block']+'</option>';
                                }
                                table += "</tbody></table>";
                                $('#sellerTable').html(table);
                            }
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


        //remove customer in new member
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
        $(document).on('change','#file_type',function(){
           var slug = $(this).find('option:selected').attr('data-slug');
            $('#refund_type').hide();
           if(slug == 'Refund'){
                $('#refund_type').show()
           }
        });
        var slug = $('#file_type').find('option:selected').attr('data-slug');
        if(slug == 'Refund'){
            $('#refund_type').show()
        }
    </script>

@endsection
