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
        <p><u><b>AFFIDAVIT BY THE SELLER</b></u></p>
    </div>

    <div class="offset-1 col-md-10">
        <div>
            <p>
                I <u> {{ $current->om_customer_name}} </u>, S/D/W of <u> {{ $current->om_customer->father_name}} </u>
                holding
                CNIC No. <u> {{ $current->om_cnic_no}} </u>,
                R/O <u> {{ $current->om_nominee_relation}} </u>, in full possession
                of
                faculties &amp; senses and with my free will and without any
                coercion or
                duress do hereby solemnly affirm and declare as under:
            </p>
        </div>

        <div>
            <p>
                1. That I have sold a Plot /Elite Unit/ Villas/ Apartment No.
                <u> {{ $current->product->name}} </u>
                bearing Reg No.<u> {{ $current->product->external_item_id}} </u>, Measuring ___ Marla in <u> {{ $current->product->block}} </u>
                Block,
                situated in <b>Palm Villas (Pvt) Ltd.</b>, Lahore
                to <u> {{ $current->nm_customer->name}} </u>,
                S/D/W of <u> {{ $current->nm_customer->father_name}} </u> holding CNIC No.
                <u> {{ $current->nm_customer->cnic_no }} </u>along
                with all rights and liabilities.
            </p>
        </div>

        <div>
            <p>
                2. That I hereby return the Original Application and Allotment
                Letter
                for the purposes of cancellation and relinquishment of above
                said Plot
                /Elite Unit/ Villas/ Apartment in favor of <u> {{ $current->nm_customer->name}} </u>.
            </p>
        </div>

        <div>
            <p>
                3. That having relinquished the above said Plot /Elite Unit/
                Villas/
                Apartment to <b>Palm Villas (Pvt) Ltd.</b> for allotment to
                <u> {{ $current->nm_customer->name}} </u> has conferred exclusive ownership
                rights of
                the above said property upon the above said transferee.
            </p>
        </div>

        <div>
            <p>
                4. That I affirm and declare that the name of
                <u> {{ $current->nm_customer->name}} </u> should be entered into the record of <b>Palm
                    Villas (Pvt) Ltd.</b> as the owner of the aforesaid Plot
                /Elite Unit/
                Villas/
                Apartment.
            </p>
        </div>

        <div>
            <p>
                5. That I do hereby declare that I have no rights title or
                interest in
                the aforesaid Plot /Elite Unit/ Villas/ Apartment and
                <u> {{ $current->nm_customer->name}} </u> is the exclusive owner of the same
                since
                today.
            </p>
        </div>

        <div>
            <p>
                6. That I do hereby acknowledge that there is no legal dispute
                on the
                above said Plot /Elite Unit/ Villas/ Apartment, if any, 1 shall
                defend
                the same in the Court of Law and <b>Palm Villas (Pvt) Ltd.</b>
                shall
                have no
                responsibility whatsoever in this regard.
            </p>
        </div>

        <div class="text-right">
            <p>
                <b>DEPONENT</b>
            </p>
        </div>

        <div>
            <p>
                Verified on oath at Lahore on this ____ day of __________, 20___
                that
                the contents in the above said affidavit are true and correct to
                the
                best of my knowledge and belief and nothing has been concealed
                therein.
            </p>
        </div>

        <div class="text-right">
            <p>
                <b>DEPONENT</b>
            </p>
        </div>

        <div class="mt-4 mb-4">
            <p>
                <u><b>1st Witness:</b></u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; 
                &nbsp;
                <u><b>2nd Witness:</b></u>
            </p>
        </div>

        <div class="mt-4 mb-4">
            <p>
                Name: ______________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                Name: _______________________
            </p>
        </div>

        <div class="mt-4 mb-4">
            <p>
                Signature: ___________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                Signature: ____________________
            </p>
        </div>

    </div>

    @endsection

@section('script')
@endsection
