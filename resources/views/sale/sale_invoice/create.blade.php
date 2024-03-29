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
        .table-wrapper {
        max-height: 230px !important;
        overflow: auto;
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
            width: 493px;
            position: absolute;
            left: 8%;
            top: 100%;
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
    <form id="sale_invoice_create" class="sale_invoice_create" action="{{route('sale.sale-invoice.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" id="form_type" value="sale_invoice">
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
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <b>{{$data['code']}}</b>
                                    </div>
                                </div>{{--
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Project <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="project_id" name="project_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['project'] as $project)
                                                <option value="{{$project->id}}"> {{$project->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>--}}
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Product <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="product_name" type="text" class="product_name form-control form-control-sm text-left">
                                            <input id="product_id" type="hidden" name="product_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Customer <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="customer_name" type="text" class="customer_name form-control form-control-sm text-left">
                                            <input id="customer_id" type="hidden" name="customer_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="seller_type" name="seller_type">
                                        <option value="0" selected>Select</option>
                                        <option value="dealer">Dealer</option>
                                        <option value="staff">Staff</option>
                                        </select>
                                      
                                    </div>
                                    </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                    <div class="input-group">
                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                        <input type="text" class="form-control form-control-sm text-left sellerList" id="seller_name" name="seller_name">
                                        <input type="hidden" id="seller_id" name="seller_id">
                                        <div id="sellerTable"></div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3 pr-0">
                                        <label class="col-form-label p-0">File Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="file_status_id" name="file_status_id">
                                            @foreach($data['file_status'] as $file_status)
                                                <option value="{{$file_status->id}}" data-slug="{{$file_status->slug}}"> {{$file_status->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3 pr-0">
                                        <label class="col-form-label p-0">Payment Mode</label>
                                </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="property_payment_mode_id" name="property_payment_mode_id">
                                            @foreach($data['property_payment_mode'] as $property_payment_mode)
                                                <option value="{{$property_payment_mode->id}}" data-slug="{{$property_payment_mode->slug}}"> {{$property_payment_mode->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Sale Price</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="" class="form-control form-control-sm" id="sale_price" name="sale_price" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label p-0">Sale Discount<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="sale_discount" name="sale_discount">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Booking Price<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="booked_price" name="booked_price"  aria-invalid="false" readonly>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3 pr-0">
                                        <label class="col-form-label p-0">Down Payment<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment" name="down_payment" aria-invalid="false">
                                    </div>
                                </div>
                                <div id="installments_block" style="display: none">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label p-0">On Balloting</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm FloatValidate" id="on_balloting" name="on_balloting" aria-invalid="false">
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label p-0">Installment Type</label>
                                        </div>
                                        <div class="col-sm-9">
                                        <select class="select2 form-select" id="installment_type" name="installment_type">
                                            <option value="0" selected>Select</option>
                                                <option value="Monthly" data-slug="Monthly">Monthly</option>
                                                <option value="Bi-Annual" data-slug="Bi-Annual">Bi-Annual</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 row" id="biannual_block" style="display: none">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6 pr-0">
                                                    <label class="col-form-label p-0">No. Of Bi-Annual</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="no_of_bi_annual" name="no_of_bi_annual" aria-invalid="false">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Installments</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="installment_bi_annual" name="installment_bi_annual" aria-invalid="false"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 row"  id="monthly_block" style="display: none">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-form-label p-0">No. of Month</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="no_of_month" name="no_of_month" aria-invalid="false"> </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Installments</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="installment_amount_monthly" name="installment_amount_monthly" aria-invalid="false"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label p-0">Installment Start Date</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" id="installment_start_time" name="installment_start_time"
                                                    class="form-control form-control-sm flatpickr-basic flatpickr-input"
                                                    placeholder="YYYY-MM-DD" value="" />
                                                </div>
                                    </div>
                                    <div class="row mb-1">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label p-0">Installment End Date</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" id="installment_end_time" name="installment_end_time"
                                                    class="form-control form-control-sm" readonly="readonly"
                                                    placeholder="YYYY-MM-DD" value="" />
                                                </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">On Possession<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="on_possession" name="on_possession" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label p-0">Currency Note No.<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" id="currency_note_no" name="currency_note_no">
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
                    @include('sale.customer.form')
                </div>
            </div>
        </div>
    </div>
    @endpermission
@endsection

@section('pageJs')
    <script>
        var current_project_id = '{{auth()->user()->project_id}}';
        var product_form_type = 'property';
    </script>
    <script src="{{ asset('/pages/sale/sale_invoice/create.js') }}"></script>
    @yield('pageJsScript')
@endsection

@section('script')
    <script src="{{asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{asset('/pages/help/product_help.js')}}"></script>
    <script>
      $(document).on('change','#seller_type',function(){
    var validate = true;
    var thix = $(this);
    var val = thix.find('option:selected').val();
    if(valueEmpty(val)){
      ntoastr.error("Select Seller Type");
      validate = false;
      return false;
    }
    if(validate){
      var formData = {
        seller_type : val
      };
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '{{ route('sale.sale-invoice.getSellerList') }}',
        dataType	: 'json',
        data        : formData,
        success: function(response,data) {
          if(response.status == 'success'){
            var seller = response.data['seller'];
            var departments = response.data['departments'];
            console.log(seller); 
            var length = seller.length;
            var lengthd = departments ? departments.length : 0;
            if(val== 'dealer'){
                table = "<div class='table-wrapper'><table><thead><tr><th>Name</th><th>Agency Name</th></tr></thead><tbody>";
            }
            else{
                table = "<div class='table-wrapper'><table><thead><tr><th>Name</th><th>Department</th></tr></thead><tbody>";
            }
                var departmentMap = {};
                for (var i = 0; i < lengthd; i++) {
                departmentMap[departments[i].id] = departments[i].name;
                }
            for(var i=0;i<length;i++){
              if(seller[i]['name']){
                if(val== 'dealer'){
                table += '<tr data-id="'+seller[i]['id']+'" data-name="'+seller[i]['name']+'"><td><b>'+seller[i]['name']+'</b></td><td><b>'+seller[i]['agency_name']+'</b></td>';
                }
                else{
                    var departmentName = departmentMap[seller[i]['department_id']];
                    table += '<tr data-id="' + seller[i]['id'] + '" data-name="' + seller[i]['name'] + '"><td><b>' + seller[i]['name'] + '</b></td><td><b>' + departmentName + '</b></td>';
                }
              }
            }
            table += "</tbody></table>";
            $('#sellerTable').html(table);
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
  $(document).on('click','#sellerTable tbody tr',function(){
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    $('#seller_id').val(id);
    $('#seller_name').val(name);
  });
  $(document).on('click','#sellerTable tbody tr',function(){
  var id = $(this).attr('data-id');
  var name = $(this).attr('data-name');
  $('#seller_id').val(id);
  $('#seller_name').val(name);
  
  if ($('#seller_name').val() == '') {
    $('#sellerTable').show();
  } else {
    $('#sellerTable').hide();
  }
});
$(document).on('change keyup','#seller_name',function(){
  if ($(this).val() == '') {
    $('#sellerTable').show();
  } else {
    $('#sellerTable').hide();
  }
});


        $(document).on('change','#project_id',function(){
            $('form').find('#product_name').val("");
            $('form').find('#product_id').val("");
        })
        $(document).on('change','#property_payment_mode_id',function(){
           var slug = $(this).find('option:selected').attr('data-slug');
            $('#installments_block').hide();
            $('#installments_block').find('input').val("");
           if(slug == 'installment'){
                $('#installments_block').show()
           }
        })
        $(document).on('change','#installment_type',function(){
           var slug = $(this).find('option:selected').attr('data-slug');
           $('#monthly_block').hide();
           $('#monthly_block').find('input').val("");
           $('#biannual_block').hide();
           $('#biannual_block').find('input').val("");
           if(slug == 'Monthly'){
                $('#monthly_block').show();
                $('#biannual_block').hide()
           }
           if(slug == 'Bi-Annual'){
                $('#biannual_block').show();
                $('#monthly_block').hide();
           }
        })
        $(document).on('change keyup', '#installment_start_time,#no_of_month,#no_of_bi_annual', function() {
        var start_date = $('#installment_start_time').val();
        var installment_type = $('#installment_type').val();
        var end_date;

        if (installment_type == 'Monthly') {
            var no_of_month = parseInt($('#no_of_month').val());
            end_date = new Date(start_date);
            end_date.setMonth(end_date.getMonth() + no_of_month);
        }
        if (installment_type == 'Bi-Annual') {
            var no_of_bi_annual = parseInt($('#no_of_bi_annual').val());
            end_date = new Date(start_date);
            end_date.setMonth(end_date.getMonth() + (no_of_bi_annual * 12));
        }
        var formatted_end_date = end_date.getFullYear() + '-' + padNumber(end_date.getMonth() + 1) + '-' + padNumber(end_date.getDate());
        $('#installment_end_time').val(formatted_end_date);
        });
        function padNumber(number) {
        return (number < 10 ? '0' : '') + number;
        }




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
    <script>
    $(document).ready(function() {
    // Get the sale price and sale discount input fields
    var salePriceInput = $('#sale_price');
    var saleDiscountInput = $('#sale_discount');

    // Get the booking price input field
    var bookedPriceInput = $('#booked_price');

    // Calculate the booking price whenever the sale price or sale discount changes
    salePriceInput.on('keyup', calculateBookingPrice);
    saleDiscountInput.on('keyup', calculateBookingPrice);

    function calculateBookingPrice() {
        // Get the sale price and sale discount values
        var salePrice = parseFloat(salePriceInput.val()) || 0;
        var saleDiscount = parseFloat(saleDiscountInput.val()) || 0;
        if (saleDiscount >= salePrice) {
            // If sale discount is greater or equal to sale price, set booking price to 0
            ntoastr.error('Sale discount must be less than Sale price');
        } else {
        // Calculate the booking price
        var bookedPrice = salePrice - saleDiscount;
        }
        // Set the booking price input field value
        bookedPriceInput.val(bookedPrice);
    }
});
</script>

    @yield('scriptCustom')
@endsection
