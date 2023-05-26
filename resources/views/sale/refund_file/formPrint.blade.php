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
<div class="offset-1 col-md-10">
        <div class="text-center">
            <p><b> REFUND REQUEST FORM</b></p>
        </div>

        <div id="content">
            <h6><b>To, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; Date: ____________</b></h6>
            <!-- <p>Date: <span id="date">_____________</span></p> -->
            <h6><b>The Management</b></h6>
            <p><b>Palm Villas (Pvt) Ltd. Lahore.</b></p>

            <h6>Subject: <b>Refund Request</b></h6>

            <p>Respectfully, it is stated that I _____________________ bearing
                CNIC no. ____________________ purchased a file for Plot / Villa
                / Elite Unit / Apartment no. _____Reg no. __________________.
                Due to some financial constraints or other reasons
                ____________________________________
                _____________________________________________. I could not pay
                my installments on time, and consequently, my property has been
                canceled by the Society.</p>

            <p>In this regard, you are requested to process my application and
                refund the upfront amount as per the company policy. I have paid
                _________________ against the above-said property.</p>

            <p>I shall be thankful for this favor.</p>

            <div id="signature">
                <p>Name: ____________________________</p>
                <p>Signature: __________________________</p>
            </div>

            <div id="department">
                <p>CR Department: ____________________________</p>
                <p>Approved by: ______________________________</p>
            </div>
        </div>
    </div>

@endpermission
@endsection
@section('script')
@endsection
