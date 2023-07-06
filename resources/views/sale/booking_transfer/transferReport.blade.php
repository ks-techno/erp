@extends('layouts.print_layout')
@section('title', $data['title'])
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
        }
        .notes {
            margin: 35px 0px;
        }
        .mb-0{
            margin-bottom: 0px;
        }
        .center{
            width: 100px;
            height: 100px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection

@section('content')
    @permission($data['permission'])

@php
    $current = $data['current'];
@endphp
<table class="" width="100%" >
        <tbody>
            <tr>
                <td style="text-align:center"><h1><u>Transfer Report</u></h1></td>
            </tr>
         

        </tbody>
</table>
<table class="" width="100%" >
        <tbody>
           
            <tr>
                <td style="text-align:center">
                    Registration No. <b>{{ $current->product->code }}</b>
                </td>
               
                <td style="text-align:center">
                Block: <b>{{ $current->product->code }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Plot/House/Apartment No . <b>{{ $current->product->name }}</b>
                </td>
               
                <td style="text-align:center">
                    Size: <b>3 Marla</b>
                </td>
            </tr>

        </tbody>
</table>
<table class="data-table tbl-booking" width="100%" style="margin-top:1%">
    <thead>
    <tr>
        <th colspan="8" style="background-color: #e9e9e9 !important;"><div class="" style="float:left"><h2 class="mb-0">Pictures:</b></div></th>
    </tr>
    <tr>
        <th width="16.66%" class="text-left">Buyer Picture</th>
        <th width="16.66%" class="text-left">Seller Picture</th>
    </tr>

    </thead>
    <tbody>
    <tr>
        <td>
            @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->nm_image;@endphp
            @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                @php $img = $root.'/uploads/'.$image_url; @endphp
            @else
                @php $img = asset('assets/images/avatars/blank-img.png') @endphp
            @endif
            <img id="om_showImage" class="mb-1 center" src="{{ $img }}">
        </td>
        <td>
            @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->om_image;@endphp
            @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                @php $img = $root.'/uploads/'.$image_url; @endphp
            @else
                @php $img = asset('assets/images/avatars/blank-img.png') @endphp
            @endif
            <img id="om_showImage" class="mb-1 center" src="{{ $img }}">
        </td>
    </tr>
    </tbody>
</table>
<table class="" width="100%" style="margin-top:3%">
        <tbody>
           
            <tr><th width="50%"><hr class="sign-line">Buyer Signature</th>
        <th width="50%"><hr class="sign-line">Seller Signature</th>
               
            </tr>

        </tbody>
</table>
<table class="" width="100%" style="margin-top:3%">
        <tbody>
           
            <tr>
                <th style="text-align:center">
                    Buyer Particulars
                </th>
               
                <th style="text-align:center">
                    Seller Particulars
                </th>
            </tr>
            <tr>
                <td style="text-align:center">
                Ownership No.: <b>{{ $current->nm_customer->membership_no }}</b>
                </td>
               
                <td style="text-align:center">
                Ownership No.: <b>{{ $current->om_customer->membership_no }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Name: <b>{{ $current->nm_customer->name }}</b>
                </td>
               
                <td style="text-align:center">
                Name: <b>{{ $current->om_customer->name }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Father/Husband Name: <b>{{ $current->nm_customer->father_name }}</b>
                </td>
               
                <td style="text-align:center">
                Father/Husband Name: <b>{{ $current->om_customer->father_name }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    CNIC: <b>{{ $current->nm_customer->cnic_no }}</b>
                </td>
               
                <td style="text-align:center">
                CNIC: <b>{{ $current->om_customer->cnic_no }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                    Contact No: <b>{{ $current->nm_customer->contact_no }}</b>
                </td>
               
                <td style="text-align:center">
                Contact No: <b>{{ $current->om_customer->contact_no }}</b>
                </td>
            </tr>

        </tbody>
</table>
<table class="" width="100%" style="margin-top:3%">
        <tbody>
           
            <tr><th width="50%">General Manager</th>
        <th width="30%"><hr class="sign-line">Transfer office Signature</th>
               
            </tr>

        </tbody>
</table>

@endpermission
@endsection
@section('script')
@endsection
