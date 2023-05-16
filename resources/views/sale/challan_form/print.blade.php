@section('title', $data['title'])
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
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/ico/favicon.ico')}}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
    <!-- END: Custom CSS-->
    @yield('style')
<style media="print">
 @page {
  size: auto;
  margin: 0;
       }
         table.tbl-booking>thead>tr>th{
            height: 30px;
            vertical-align: middle;
        }
        table.tbl-booking>tbody>tr>td{
            height: 50px;
            vertical-align: top;
            padding-top: 8px !important;
        }
        .notes {
            margin: 35px 0px;
        }
        
</style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body>
@permission($data['permission'])
@section('page_title', $data['title'])
@php
    $current = $data['current'];
@endphp
<table width="100%">
    <tbody>
        <tr>
            <td>
            <table width="100%" class="data-table tbl-booking">
    <tbody>
        <tr style="border:none;">
        <td width="50%" style="border:none;">
            <div class="fz-22">@yield('title')</div>
        </td>
        <td class="text-center" width="50%" style="border:none;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:100px;">
            <div class="fz-22 pt-15">{{auth()->user()->project->name}}</div>
        </td>
        </tr>
        <tr>
            <td style="border:none;"><div><b>Challan Number:</b> {{$current->challan_no}}</div> </td>
            <td style="border:none;"></td>
        </tr>
        <tr style="border-top: 1px solid;">
            <td class="text-left"><b>Membership No.</b></td>
            <td>{{isset($current->customer->cnic_no)?$current->customer->cnic_no:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Customer Name</b></td>
            <td>{{isset($current->customer->name)?$current->customer->name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>S/O,D/O,W/O</b></td>
            <td>{{isset($current->customer->father_name)?$current->customer->father_name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Plot Number</b></td>
            <td>{{isset($current->product->name)?$current->product->name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Block</b></td>
            <td>{{isset($current->product->block)?$current->product->block:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Payment Mode</b></td>
            <td>{{ getpaymentModes($current->property_payment_mode_id) }}</td>
        </tr>
        <tr>
        <td class="text-left" width="70%"><b>Particulars</b></td>
        <td class="text-left" width="30%"><b>Amount (Rs.)</b></td>
        </tr>   
        @foreach($data['particulars'] as $particular)
       
        <tr>
                    <td width="70%">{{$particular->particular->name}}</td>
                    <td width="30%">{{$particular->amount}}</td>
                  
                </tr>
        @endforeach
    </tbody>
</table>
            </td>
            <td>
            <table width="100%" class="data-table tbl-booking">
    <tbody>
        <tr style="border:none;">
        <td width="50%" style="border:none;">
            <div class="fz-22">@yield('title')</div>
        </td>
        <td class="text-center" width="50%" style="border:none;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:100px;">
            <div class="fz-22 pt-15">{{auth()->user()->project->name}}</div>
        </td>
        </tr>
        <tr>
            <td style="border:none;"><div><b>Challan Number:</b> {{$current->challan_no}}</div> </td>
            <td style="border:none;"></td>
        </tr>
        <tr style="border-top: 1px solid;">
            <td class="text-left"><b>Membership No.</b></td>
            <td>{{isset($current->customer->cnic_no)?$current->customer->cnic_no:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Customer Name</b></td>
            <td>{{isset($current->customer->name)?$current->customer->name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>S/O,D/O,W/O</b></td>
            <td>{{isset($current->customer->father_name)?$current->customer->father_name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Plot Number</b></td>
            <td>{{isset($current->product->name)?$current->product->name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Block</b></td>
            <td>{{isset($current->product->block)?$current->product->block:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Payment Mode</b></td>
            <td>{{ getpaymentModes($current->property_payment_mode_id) }}</td>
        </tr>
        <tr>
        <td class="text-left" width="70%"><b>Particulars</b></td>
        <td class="text-left" width="30%"><b>Amount (Rs.)</b></td>
        </tr>   
        @foreach($data['particulars'] as $particular)
       
        <tr>
                    <td width="70%">{{$particular->particular->name}}</td>
                    <td width="30%">{{$particular->amount}}</td>
                  
                </tr>
        @endforeach
    </tbody>
</table>
            </td>
            <td>
            <table width="100%" class="data-table tbl-booking">
    <tbody>
        <tr style="border:none;">
        <td width="50%" style="border:none;">
            <div class="fz-22">@yield('title')</div>
        </td>
        <td class="text-center" width="50%" style="border:none;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:100px;">
            <div class="fz-22 pt-15">{{auth()->user()->project->name}}</div>
        </td>
        </tr>
        <tr>
            <td style="border:none;"><div><b>Challan Number:</b> {{$current->challan_no}}</div> </td>
            <td style="border:none;"></td>
        </tr>
        <tr style="border-top: 1px solid;">
            <td class="text-left"><b>Membership No.</b></td>
            <td>{{isset($current->customer->cnic_no)?$current->customer->cnic_no:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Customer Name</b></td>
            <td>{{isset($current->customer->name)?$current->customer->name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>S/O,D/O,W/O</b></td>
            <td>{{isset($current->customer->father_name)?$current->customer->father_name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Plot Number</b></td>
            <td>{{isset($current->product->name)?$current->product->name:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Block</b></td>
            <td>{{isset($current->product->block)?$current->product->block:""}}</td>
        </tr>
        <tr>
            <td class="text-left"><b>Payment Mode</b></td>
            <td>{{ getpaymentModes($current->property_payment_mode_id) }}</td>
        </tr>
        <tr>
        <td class="text-left" width="70%"><b>Particulars</b></td>
        <td class="text-left" width="30%"><b>Amount (Rs.)</b></td>
        </tr>   
        @foreach($data['particulars'] as $particular)
       
        <tr>
                    <td width="70%">{{$particular->particular->name}}</td>
                    <td width="30%">{{$particular->amount}}</td>
                  
                </tr>
        @endforeach
    </tbody>
</table>
            </td>
        </tr>
    </tbody>
</table>
@endpermission
   


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
