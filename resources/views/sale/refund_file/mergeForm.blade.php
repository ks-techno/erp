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
@php
    $current = $data['current'];
@endphp
@section('content')
<div class="offset-1 col-md-10">
        <div class="text-center mb-4">
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
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; Date: ____________</b></h6>
            <!-- <p>Date: <span id="date">_____________</span></p> -->
            <h6><b>The Management</b></h6>
            <p><b>Palm Villas (Pvt) Ltd. Lahore.</b></p>

            <h6><b>Lahore</b></h6>

        </div>
        <h6 class="mb-4 mt-4"><u><b>Dissolve file detail:</b></u></h6>

        <table style="width:100%" border="1">
            <tr style="height:70px">
                <th style="width: 40%;">Plot /Elite Unit/ Villas/ Apartment No.
                </th>
                <th>Registration No. </th>
                <th>Floor </th>
                <th>Size </th>
                <th>Block </th>
            </tr>
            <tr style="height:100px">
                <!-- <td>Alfreds Futterkiste</td>
                <td>Maria Anders</td> -->
                <th>{{ $current->product->external_item_id}}</th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $current->product->block}}</th>
            </tr>
        </table>

        <h6 class="mb-4 mt-4"><u><b>Retain file detail:</b></u></h6>

        <table style="width:100%" border="1">
            <tr style="height:70px">
                <th style="width: 40%;">Plot /Elite Unit/ Villas/ Apartment No.
                </th>
                <th>Registration No. </th>
                <th>Floor </th>
                <th>Size </th>
                <th>Block </th>
            </tr>
            <tr style="height:100px">
                <!-- <td>Alfreds Futterkiste</td>
                <td>Maria Anders</td> -->
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </table>

        <div class="mb-4 mt-4">
            <p>
                Remarks by CR Department:
                ____________________________________________________________
            </p>
        </div>
        <div>
        </div>
        <div>
            <p>
                Muhammad Akram
            </p>
        </div>
        <div>
            <p>
                35202-5698745-8
            </p>
        </div>
        <div>
            <p>
                Spring Block Bahria Town Lahore
            </p>
        </div>
        <div>
            <p>
                0302-55236589
            </p>
        </div>
        <div class="text-right">
            <p>
                CR Department: _____________________
            </p>
        </div>
        <div>
        </div>
        <div>
            <p>
                Signature &amp; Thumb Impression
                Approved By:
            </p>
        </div>
    </div>

@endsection
@section('script')
@endsection
