<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'KSD') }}</title>
    <link rel="apple-touch-icon" href="{{asset('assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/icon.png')}}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
    <!-- END: Custom CSS-->
    @yield('style')
    <style media="print">
 @page {
  size: auto;
  margin: 0;
       }
</style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body>
<table class="head" width="100%" >
    <tbody>
    <tr>
        <td width="50%">
            <div class="fz-26">@yield('page_title')</div>
        </td>
        <td class="text-center" width="50%">
        <img src="https://dev.ks-technologies.net/assets/images/logo.png" alt="logo" style="height:100px;">
            <div class="fz-26 pt-15">{{auth()->user()->project->name}}</div>
        </td>
    </tr>
    </tbody>
</table>

<table class="data-table tbl-booking" width="100%" border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
        <th class="text-left">Account Name</th>
        <th class="text-left">Account Code</th>
        <th class="text-left">Date</th>
        <th class="text-left ">Debit</th>
        <th class="text-left">Credit</th>
        <th class="cell-fit">Closing Balance</th>
        <th class="cell-fit">Closing Balance (In words)</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data['results'] as $result)
    
    <tr>
    <td class="text-left">{{isset($result->voucher->chart_account_name) ? $result->voucher->chart_account_name : ""}}</td>
        <td class="text-left">{{isset($result->voucher->chart_account_code) ? $result->voucher->chart_account_code : ""}}</td>
        <td class="text-left">{{isset($result->voucher->date) ? $result->voucher->date : ""}}</td>
        <td class="text-left">{{format_number($result->voucher->debit)}}</td>
        <td class="text-left">{{ format_number($result->voucher->credit)}}</td>
        <td class="text-left">{{format_number($result->voucher->total_credit)}}</td>
        <td class="text-left">{{numberToWords($result->voucher->total_credit)}}</td>
    </tr>
@endforeach

    </tbody>
</table>
<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

@yield('script')


<!-- <table class="pt-15" {{--style="position: absolute;bottom: 0;"--}}>
    <tr>
        <td class="text-right">Print Date & Time: {{date("d-m-Y h:i:s")}}</td>
    </tr>
</table> -->
</body>
<!-- END: Body-->

</html>

@section('style')
    <style>
        table.tbl-booking>thead>tr>th{
            height: 30px;
            vertical-align: middle;
        }
        table.tbl-booking>tbody>tr>td{
            height: 50px;
            vertical-align: top;
            padding-top: 5px;
            vertical-align: middle;
            text-align = center;
        }
        
    </style>
@endsection

@section('script')
@endsection
