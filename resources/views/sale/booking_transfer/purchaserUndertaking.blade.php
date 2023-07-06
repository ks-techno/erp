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
        <p><u><b>UNDERTAKING BY THE PURCHASER</b></u></p>
    </div>

    <div class="offset-1 col-md-10">

        <div class="mb-4">
            <p>
                I  <u> {{ $current->nm_customer->name }} </u>  , S/D/W of  <u> {{ $current->nm_customer->father_name }} </u>  
                holding,
                CNIC No. <u> {{ $current->nm_customer->cnic_no }} </u>  ,
                R/O <u> {{  $current->nm_nominee_name  }} </u>, in full possession
                of
                faculties &amp; senses and with my free will and without any
                coercion or
                duress do hereby solemnly affirm and declare as under:
            </p>
        </div>

        <div>
            <p>
                <b>1.</b> That I have purchased a Plot /Elite Unit/ Villas/ Apartment
                No.<u> {{ $current->product->name }} </u> ,
                bearing registration No. <u> {{ $current->product->external_item_id }} </u> Measuring ___ Marla
                <u> {{ $current->product->block }} </u> Block
                situated in <b>Palm Villas (Pvt) Ltd</b>, Lahore
                from________________,
                with
                all rights and liabilities. I undertake to abide by all terms
                and
                conditions of allotment of the above said property with all the
                present
                and future terms and conditions, rules and regulations of <b>Palm
                    Villas (Pvt) Ltd.</b>
            </p>
        </div>

        <div>
            <p>
                <b>2.</b> To pay all dues, fees, charges etc., payable by the previous
                owner of
                the Plot Plot/Elite Unit/Villa/Apartment to the <b>Palm Villas
                    (Pvt) Ltd.</b>
                or any other Government dues etc. in respect of the above said
                Plot/Elite Unit/Villa/Apartment.
            </p>
        </div>
        <div>

            <p>
                <b>3.</b> To use the land for the same purpose for which it was
                allotted
                and to
                comply with all relevant rules and regulations of the <b>Palm
                    Villas (Pvt) Ltd.</b>
            </p>
        </div>

        <div>
            <p>
                <b>4.</b> To pay the <b>Palm Villas (Pvt) Ltd.</b> any variation in
                development
                charges on demand.
            </p>
        </div>

        <div>
            <p>
                <b>5.</b> That I do hereby acknowledge and agree with the present
                status of
                the
                above said Plot/Elite Unit/Villa/Apartment and shall not claim
                any
                other
                Plot in lieu of the above said property.
            </p>
        </div>
        <div>
            <p>
                <b>6.</b> That I also undertake to pay on demand any other charges as
                the
                Management of <b>Palm Villas (Pvt) Ltd.</b> may decide from time
                to
                time.
            </p>
        </div>

        <div>
            <p>
                <b>7.</b> That I do hereby acknowledge that there is no legal dispute
                on
                the
                above said Plot/Elite Unit/Villa/Apartment, if any, I shall
                defend
                the
                same in the Court of Law and <b>Palm Villas (Pvt) Ltd.</b>
                shall have
                no
                responsibility whatsoever in this regard.
            </p>
        </div>

        <div>
            <p>
                <b>8.</b> Possession Charges as levied by <b>Palm Villas (Pvt) Ltd.</b>
                will
                be
                paid
                by me at the time of possession.
            </p>
        </div>

        <div class="mb-4 mt-4">
            <p>
                Name: _______________________
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <u>Signature &amp; Thumb Impression :</u>
            </p>
        </div>

        <div class="mb-4 mt-4">
            <p>
                CNIC No.: _______________________
            </p>
        </div>

    </div>
@endsection

@section('script')
@endsection
