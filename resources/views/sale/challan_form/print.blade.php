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
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/icon.png')}}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
    <!-- END: Custom CSS-->
    @yield('style')
<style media="print">
        table.tbl-booking{
            
        }
         table.tbl-booking>thead>tr>th{
          
            vertical-align: middle;
        }
        table.tbl-booking>tbody>tr>td{
            vertical-align: middle;
        }
        .notes {
            margin: 35px 0px;
        }
@media print {
  @page {
    size= A4 landscape;
    margin: 0; 
  }
  
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
        <td width="70%" style="border:none;">
            <div class="fz-22">@yield('title')</div><sub>Customer Copy</sub>
        </td>
        <td class="text-center" width="30%" style="border:none;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:80px; margin-top: 6px;">
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
            <td>
            @foreach (getpaymentModes() as $key => $value)
            @if ($current->property_payment_mode_id === $key)
                {{ $value }}
            @endif
            @endforeach
         </td>
        </tr>
        </tbody>
        </table>
        <table class="data-table tbl-booking" width="100%" style="padding-top:0px !important;">
            <tr>
        <td class="text-left" width="70%"><b>Particulars</b></td>
        <td class="text-left" width="30%"><b>Amount (Rs.)</b></td>
        </tr>
        @foreach($data['particulars'] as $particular)
       
        <tr>
                    <td width="70%">{{$particular->particular->name}}</td>
                    <td  width="30%">{{$particular->amount}}</td>
                  
                </tr>
        @endforeach

                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
        </table>
        <table width="100%" class="data-table tbl-booking">
        <tr>
        <td class="text-left"><b>Total Amount</b></td>
        <td class="text-right">{{isset($current->total_amount)?$current->total_amount:""}}</td>
        </tr>
        <tr>
        <td class="text-left"><b>Total Amount (In words)</b></td>
        <td class="text-right">{{numberToWords(isset($current->total_amount)?$current->total_amount:"")}} rupees only</td>
        </tr>
        </table>
        <table class="mt-10" width="100%" valign="bottom">
    <tr>
        <th width="50%"><hr class="sign-line">{{trans('label.prepared_by')}}</th>
        <th width="50%"><hr class="sign-line">{{trans('label.approved_by')}}</th>
    </tr>
    </tbody>
</table>
            </td>
            <td>
            <table width="100%" class="data-table tbl-booking">
    <tbody>
        <tr style="border:none;">
        <td width="70%" style="border:none;">
            <div class="fz-22">@yield('title')</div><sub>Bank Copy</sub>
        </td>
        <td class="text-center" width="30%" style="border:none;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:80px; margin-top: 6px;">
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
            <td>
            @foreach (getpaymentModes() as $key => $value)
            @if ($current->property_payment_mode_id === $key)
                {{ $value }}
            @endif
            @endforeach
         </td>
        </tr>
        </tbody>
        </table>
        <table class="data-table tbl-booking" width="100%">
            <tr>
        <td class="text-left" width="70%"><b>Particulars</b></td>
        <td class="text-left" width="30%"><b>Amount (Rs.)</b></td>
        </tr>
        @foreach($data['particulars'] as $particular)
       
        <tr>
                    <td width="70%">{{$particular->particular->name}}</td>
                    <td  width="30%">{{$particular->amount}}</td>
                  
                </tr>
                @endforeach
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
       
        </table>
        <table width="100%" class="data-table tbl-booking">
        <tr>
        <td class="text-left"><b>Total Amount</b></td>
        <td class="text-right">{{isset($current->total_amount)?$current->total_amount:""}}</td>
        </tr>
        <tr>
        <td class="text-left"><b>Total Amount (In words)</b></td>
        <td class="text-right">{{numberToWords(isset($current->total_amount)?$current->total_amount:"")}} rupees only</td>
        </tr>
        </table>
        <table class="mt-10" width="100%" valign="bottom">
    <tr>
        <th width="50%"><hr class="sign-line">{{trans('label.prepared_by')}}</th>
        <th width="50%"><hr class="sign-line">{{trans('label.approved_by')}}</th>
    </tr>
    </tbody>
</table>
            </td>
            <td>
            <table width="100%" class="data-table tbl-booking">
    <tbody>
        <tr style="border:none;">
        <td width="70%" style="border:none;">
            <div class="fz-22">@yield('title')</div><sub>Accounts Copy</sub>
        </td>
        <td class="text-center" width="30%" style="border:none;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:80px; margin-top: 6px;">
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
            <td>
            @foreach (getpaymentModes() as $key => $value)
            @if ($current->property_payment_mode_id === $key)
                {{ $value }}
            @endif
            @endforeach
         </td>
        </tr>
        </tbody>
        </table>
        <table class="data-table tbl-booking" width="100%">
            <tr>
        <td class="text-left" width="70%"><b>Particulars</b></td>
        <td class="text-left" width="30%"><b>Amount (Rs.)</b></td>
        </tr>
        @foreach($data['particulars'] as $particular)
       
        <tr>
                    <td width="70%">{{$particular->particular->name}}</td>
                    <td  width="30%">{{$particular->amount}}</td>
                  
                </tr>
        @endforeach
        <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
                <tr>
                    <td width="70%"></td>
                    <td  width="30%"></td>
                  
                </tr>
        </table>
        <table width="100%" class="data-table tbl-booking">
        <tr>
        <td class="text-left"><b>Total Amount</b></td>
        <td class="text-right">{{isset($current->total_amount)?$current->total_amount:""}}</td>
        </tr>
        <tr>
        <td class="text-left"><b>Total Amount (In words)</b></td>
        <td class="text-right">{{numberToWords(isset($current->total_amount)?$current->total_amount:"")}} rupees only</td>
        </tr>
        </table>
        <table class="mt-10" width="100%" valign="bottom">
    <tr>
        <th width="50%"><hr class="sign-line">{{trans('label.prepared_by')}}</th>
        <th width="50%"><hr class="sign-line">{{trans('label.approved_by')}}</th>
    </tr>
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
