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

<div class="text-center mb-4 mt-4">
        <p><u><b>INDEMNITY BOND BY THE TRANSFEREE </b></u></p>
    </div>
    <div class="offset-1 col-md-10">

        <div>
            <p>
                This deed of indemnity is made at Lahore, _____ day of _____ ,
                20____
                between <u> {{ $current->nm_customer->name }} </u>  S/D/W of
                <u> {{  $current->nm_customer->father_name  }} </u>  R/O
                <u> {{  $current->nm_nominee_name  }} </u>
                having
                CNIC
                No. <u> {{ $current->nm_customer->cnic_no }} </u>( hereinafter referred to as
                the
                “Transferee” of the one part).
            </p>
        </div>
        <div>
            <p>
                And
            </p>
        </div>
        <div>
            <p>
                <b>Palm Villas (Pvt) Ltd.</b>, Lahore hereinafter referred to as
                <b>“Palm Villas”</b>
                of the other Part.
            </p>
        </div>

        <div>
            <p>
                WHEREAS Mr./Mrs./Miss <u> {{ $current->om_customer_name}} </u> was allotted a
                plot
                of
                land bearing registration No. <u> {{ $current->product->external_item_id }} </u> Plot /Elite
                Unit/
                Villas/ Apartment No.______, in <u> {{ $current->product->block }} </u>BLOCK, Lahore measuring
                ____Marla,
                in the <b>Palm Villas (Pvt) Ltd.</b>, and I have purchased the said
                plot
                along
                with all rights and liabilities.
            </p>
        </div>
        <div>
            <p>
                AND WHEREAS the transferee has applied to Palm Villas (Pvt)
                Ltd., to
                transfer the said plot in his/her name.
            </p>
        </div>

        <div>
            <p>
                AND FURTHER WHEREAS Palm Villas (Pvt) Ltd. has agreed to do so
                provided
                the transferee executes this deed of indemnity’ in favor of<b>Palm Villas (Pvt) Ltd.</b>,and the transferee has agreed to do so.
            </p>
        </div>

        <div>
            <p>
                NOW THIS DEED WITNESSETH AS FOLLOWS:
            </p>
        </div>
        <div>
            <p>
                That pursuant to do premises above the ‘transferee’ hereby agree
                to
                indemnify and keep indemnified
            </p>
        </div>
        <div>
            <p>
                <b>Palm Villas (Pvt) Ltd.</b>, against the claims, demands, losses,
                injuries,
                harms, damages, dues, judgements, charges and expenses incurred
                or
                suffered by <b>Palm Villas (Pvt) Ltd.</b>, arising from the said
                transfer to
                membership and plot to the name of the transferee.
            </p>
        </div>

        <div>
            <p>
                Signed and delivered by the above-named Transferee, this __day
                of
                ___________, 20___
            </p>
        </div>

        <div>
            <p>
                Signature
                Witnesses
            </p>
        </div>

        <div>
            <p>
                Name: _________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                Name: _______________________
            </p>
        </div>

        <div>
            <p>
                CNIC No: _______________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                CNIC No: _____________________
            </p>
        </div>

        <div>
            <p>
                Signature: ______________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                Signature: ____________________
            </p>
        </div>

    </div>
    @endsection
@section('script')
@endsection
