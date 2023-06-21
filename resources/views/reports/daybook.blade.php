{{-- @extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.min.css') }}">
    <!-- END: Vendor CSS-->
    @yield('themeStyle')
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/semi-dark-layout.css') }}">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/pickers/form-pickadate.css') }}">
@endsection

@section('content')

    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{ $data['title'] }}</h4>
                        </div>

                        <div class="card-link">

                            <div class="dropdown">
                                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Export
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" >
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    <li><a class="dropdown-item" href="#">Excel</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card" style="height: 300px;">

            <div class="row">

                <div class="offset-1 col-sm-3 mt-1">
                    <label class="col-form-label">Select Date <span class="required">*</span></label>
                    <input type="text" id="date" name="date"
                        class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD"
                        value="{{ date('Y-m-d') }}" />
                </div>

                <div class="col-sm-3 mt-1">
                    <label class="col-form-label">Select Account <span class="required">*</span></label>
                    <select id="account" name="account" class="form-control form-control-sm">
                        <option value="account1">Level 3</option>
                        <option value="account2">Level 4</option>
                    </select>
                </div>

                <div class="col-sm-4 mt-4">
                    <button type="submit" class="btn btn-warning btn-sm waves-effect waves-float waves-dark">Today</button>
                    <button type="submit" class="btn btn-dark btn-sm waves-effect waves-float waves-dark">Yesterday</button>
                </div>

            </div>

        </div>





    </section>


@endsection

@section('pageJs')
@endsection

@section('script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('assets/js/scripts/forms/form-validation.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <script src="{{ asset('/js/jquery-12.js') }}"></script>
    <script src="{{ asset('/pages/common/erp_grid.js') }}"></script>
    <script src="{{ asset('/pages/help/chart_help.js') }}"></script>
    <script src="{{ asset('/pages/common/account-calculations.js') }}"></script>
@endsection --}}
@extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
 <!-- BEGIN: Vendor CSS-->
 <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.min.css')}}">
    <!-- END: Vendor CSS-->
    @yield('themeStyle')
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/semi-dark-layout.css')}}">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/extensions/ext-component-toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/pickers/form-flat-pickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/pickers/form-pickadate.css')}}">
@endsection
@php
    $entry_date = date('Y-m-d');
@endphp
@section('content')
    <div class="datatable">
    <!-- Datatable -->
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="min-width:100%;">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel</a></li>
                            </ul>
                        </div>
                    </div>
                    <form id ="ledger_create" action=""
                        method="get" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                    <div class="row mb-1 mt-2 mx-3">
                            <div class="col-sm-3">
                            <label class="col-form-label p-0 " > Select Account: <span class="required">*</span></label>
                            <select id="account" name="account" class="form-control form-control-sm">
                                <option value="account1">Level 3</option>
                                <option value="account2">Level 4</option>
                            </select>
                            </div>

                            <div class="col-sm-3">
                            <label class="col-form-label p-0">Select Date: <span class="required">*</span></label>
                            <input type="text" id="start_date" name="start_date" class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD" value="" />
                            </div>
                            
                            {{-- <div class="col-sm-3">
                            <label class="col-form-label p-0">End Date: <span class="required">*</span></label>
                            <input type="text" id="end_date" name="end_date" class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD" value="" />
                            </div> --}}
                            <div class="col-sm-3 mt-2">
                                <button type="submit" class="btn btn-warning btn-sm waves-effect waves-float waves-dark" >Today</button>
                                <button type="submit" class="btn btn-dark btn-sm waves-effect waves-float waves-dark" >Yesterday</button>
                            </div>
                        </div>
                        </form>

                    <div class="card-body">
                        <div class="card-datatable">

                            <table class="datatables-ajax table table-responsive" data-url="">
                                <thead>
                                <tr>
                                    {{-- <th class="cell-fit">Account Name</th> --}}
                                    <th class="cell-fit">Account Code</th>
                                    <th class="cell-fit">Date</th>
                                    <th class="cell-fit ">Debit</th>
                                    <th class="cell-fit text-center">Credit</th>
                                    <th class="cell-fit">Closing Balance</th>
                                    <th class="cell-fit">Closing Balance (In words)</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            {{-- @endpermission --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Datatable -->
    </div>
@endsection
@section('pageJs')
@endsection
@section('script')
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{asset('assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<script src="{{asset('assets/js/scripts/forms/form-validation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/pickers/form-pickers.js')}}"></script>
<script>
$(document).ready(function() {
  $('#ledger_create').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    // Send the AJAX request to retrieve the selected results
    $.ajax({
      url: $(this).attr('action'),
      type: 'GET',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        var tableBody = $('.datatables-ajax tbody');
        tableBody.empty();
        $.each(response.data, function(index, row) {
          var newRow = $('<tr>');
          newRow.append('<td>' + row[0] + '</td>');
          newRow.append('<td>' + row[1] + '</td>');
          newRow.append('<td>' + row[2] + '</td>');
          newRow.append('<td>' + row[3] + '</td>');
          newRow.append('<td>' + row[4] + '</td>');
          newRow.append('<td>' + row[5] + '</td>');
          newRow.append('<td>' + row[6] + '</td>');
          tableBody.append(newRow);
        });
        var exportUrl = "" + formData;
        $('.export-pdf-button').attr('href', exportUrl);
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
});
</script>
@endsection
