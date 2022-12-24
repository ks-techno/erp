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
    </style>
@endsection

@section('content')
@permission($data['permission'])
@section('page_title', $data['title'])
@php
    $current = $data['current'];
@endphp
<div><b>Booking Code:</b> {{$data['current']->code}}</div>
<table class="data-table tbl-booking" width="100%">
    <thead>
        <tr>
            <th width="16.66%" class="text-left">Membership No.</th>
            <th width="16.66%" class="text-left">Member Name</th>
            <th width="16.66%" class="text-left">S/O,D/O,W/O</th>
            <th width="16.66%" class="text-left">Reg. No.</th>
            <th width="16.66%" class="text-left">Category</th>
            <th width="16.66%" class="text-left">Form No.</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td>{{isset($data['current']->customer->name)?$data['current']->customer->name:""}}</td>
            <td>{{isset($data['current']->customer->father_name)?$data['current']->customer->father_name:""}}</td>
            <td></td>
            <td>{{isset($data['current']->product->buyable_type->name)?$data['current']->product->buyable_type->name:""}}</td>
            <td></td>
        </tr>
    </tbody>
</table>
<table class="data-table tbl-booking" width="100%">
    <thead>
    <tr>
        <th width="16.66%" class="text-left">Mailing Address</th>
        <th width="16.66%" class="text-left">Permanent Address</th>
        <th width="16.66%" class="text-left">CNIC Number</th>
        <th width="16.66%" class="text-left">Mobile No.</th>
        <th width="16.66%" class="text-left">Residence Number</th>
        <th width="16.66%" class="text-left">Email ID</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <div>
                {{isset($data['current']->customer->addresses->address)?$data['current']->customer->addresses->address:""}},
            </div>
            <div>
                {{isset($data['current']->customer->addresses->city->name)?$data['current']->customer->addresses->city->name:""}},
                {{isset($data['current']->customer->addresses->region->name)?$data['current']->customer->addresses->region->name:""}},
                {{isset($data['current']->customer->addresses->country->name)?$data['current']->customer->addresses->country->name:""}}
            </div>
        </td>
        <td>
            <div>
                {{isset($data['current']->customer->addresses->address)?$data['current']->customer->addresses->address:""}},
            </div>
            <div>
                {{isset($data['current']->customer->addresses->city->name)?$data['current']->customer->addresses->city->name:""}},
                {{isset($data['current']->customer->addresses->region->name)?$data['current']->customer->addresses->region->name:""}},
                {{isset($data['current']->customer->addresses->country->name)?$data['current']->customer->addresses->country->name:""}}
            </div>
        </td>
        <td>{{isset($data['current']->customer->cnic_no)?$data['current']->customer->cnic_no:""}}</td>
        <td>{{isset($data['current']->customer->mobile_no)?$data['current']->customer->mobile_no:""}}</td>
        <td>{{isset($data['current']->customer->contact_no)?$data['current']->customer->contact_no:""}}</td>
        <td>{{isset($data['current']->customer->email)?$data['current']->customer->email:""}}</td>
    </tr>
    </tbody>
</table>
<table class="data-table tbl-booking" width="100%">
    <thead>
    <tr>
        <th width="16.66%" class="text-left">Property Type</th>
        <th width="16.66%" class="text-left">File Status</th>
        <th width="16.66%" class="text-left">Size</th>
        <th width="16.66%" class="text-left">Location</th>
        <th width="16.66%" class="text-left">Payment</th>
        <th width="16.66%" class="text-left">Booking Person</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{isset($data['current']->property_payment_mode->name)?$data['current']->property_payment_mode->name:""}}</td>
        <td>
            @if(isset($data['current']->dealer->dealer->name))
                <b>Dealer:</b> {{$data['current']->dealer->dealer->name}}
            @endif
            @if(isset($data['current']->staff->staff->name))
                <b>Staff:</b> {{$data['current']->staff->staff->name}}
            @endif
        </td>
    </tr>
    </tbody>
</table>
<h1>Nominee Information</h1>
<table class="data-table tbl-booking" width="100%">
    <thead>
    <tr>
        <th width="20%" class="text-left">Name</th>
        <th width="20%" class="text-left">S/O,D/O,W/O</th>
        <th width="20%" class="text-left">CNIC No.</th>
        <th width="20%" class="text-left">Cntact No.</th>
        <th width="20%" class="text-left">Relation with Client</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{isset($data['current']->customer->nominee_name)?$data['current']->customer->nominee_name:""}}</td>
        <td>{{isset($data['current']->customer->nominee_father_name)?$data['current']->customer->nominee_father_name:""}}</td>
        <td>{{isset($data['current']->customer->nominee_cnic_no)?$data['current']->customer->nominee_cnic_no:""}}</td>
        <td>{{isset($data['current']->customer->nominee_contact_no)?$data['current']->customer->nominee_contact_no:""}}</td>
        <td>{{isset($data['current']->customer->nominee_relation)?$data['current']->customer->nominee_relation:""}}</td>
    </tr>
    </tbody>
</table>

<div class="notes">
    **Membership no. will be generated once for one client, if a client has more than 1 plot or villa at the same time then one membership number will beapplied on all files.
    When we put CNIC the membership no will be shown and there would be an option for another entry for client property.
</div>

@endpermission
@endsection
@section('script')
@endsection
