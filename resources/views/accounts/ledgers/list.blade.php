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
                        <div class="card-link">
                        <a href="{{ route('exportPDF') }}" class="btn btn-danger btn-sm waves-effect waves-float waves-light export-pdf-button">Export to PDF</a>  
                        </div>
                       
                    </div>
                    <form id ="ledger_create" action="{{route('accounts.ledgers.index')}}"
                        method="get" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                    <div class="row mb-1 mt-2 mx-3">
                            <div class="col-sm-3">
                            <label class="col-form-label p-0 ">Account Type: <span class="required">*</span></label>
                            <select class="select2 chart_code form-select" name="chart_code" id="chart_code">
                                <option value="">Select Value</option>
                                @foreach($data['chart'] as $chart)
                                <option value="{{$chart->id}}"> {{$chart->code}} - ({{$chart->name}})</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-3">
                            <label class="col-form-label p-0">Start Date: <span class="required">*</span></label>
                            <input type="text" id="start_date" name="start_date" class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD" value="" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-form-label p-0">End Date: <span class="required">*</span></label>
                            <input type="text" id="end_date" name="end_date" class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD" value="" />
                            </div>
                            <div class="col-sm-3 mt-2">
                            <button type="submit" value="get" class="btn btn-success btn-sm waves-effect waves-float waves-light">Search</button>
                            </div>
                        </div>
                        </form>
                        <hr>
                    <div class="card-body">
                        <div class="card-datatable">
                            @permission($data['permission_list'])
                            <table class="datatables-ajax table table-responsive" data-url="{{route('accounts.ledgers.index')}}">
                                <thead>
                                <tr>
                                    <th class="cell-fit">Account Name</th>
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
                            @endpermission
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

        var exportUrl = "{{ route('exportPDF') }}?" + formData;
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
