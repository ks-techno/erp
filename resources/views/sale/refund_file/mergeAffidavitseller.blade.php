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
        <div>
            <div class="text-center mb-4">
                <h3>
                    AFFIDAVIT FOR MERGING
                </h3>
            </div>

        </div>
        <div>
            <p>
                I,<u> {{ $current->customer->name}} </u>, S/D/W/of <u> {{ $current->customer->name}} </u>,
                holding CNIC No.<u> {{ $current->customer->cnic_no}} </u>,Resident of
                ___________________________________________________
            </p>
        </div>
        <div>
            <p>
                In possession of my Full Faculties and senses arid my free will
                and
                without duress do hereby solemnly affirm and declare as under:
            </p>
        </div>
        <div>
            <p>
                1. That I am a bonafide member of <u>Palm Villas (Pvt) Ltd.</u>
                and I
                was
                allotted/transferred Plot / Villa / Elite Unit / Apartment
                no. <u> {{ $current->product->name}} </u>
                bearing registration no <u> {{ $current->product->external_item_id}} </u>,
                measuring_________, block <u> {{ $current->product->block}} </u> in <u>Palm Villas (Pvt) Ltd.</u>
            </p>
        </div>
        <div>
            <p>
                2. That I have decided to merge above said property into Plot /
                Villa / Elite Unit / Apartment no._______ bearing registration
                no.____________ measuring_________, Block____ in<u>Palm Villas
                    (Pvt) Ltd.</u>
            </p>
        </div>
        <div>
            <p>
                3. That I hereby return the original application and allotment
                letter for merging and relinquish the above said property (Para
                #.1) in favor of <u>Palm Villas (Pvt)
                    Ltd.</u>
            </p>
        </div>
        <div>
            <p>
                4. I affirmed and declare; I have surrendered the aforesaid
                property (Para #.1) for the merging purpose to<u>Palm
                    Villas
                    (Pvt) Ltd.</u>
            </p>
        </div>
        <div>
            <p>
                5. That I agree for the deduction policy of merging and I
                further confirm that I will abide by all the rules/regulations
                in this regard made by the<u>Palm Villas (Pvt) Ltd.</u>
            </p>
        </div>
        <div>
            <p>
                6. That I solemnly declare that I have no rights, title or
                interest in said property (para #1) and I will not claim of the
                merged property after merging to <u>Palm Villas (Pvt) Ltd.</u>
            </p>
        </div>
        <div>
            <p>
                7.That I do hereby acknowledge that there is no legal dispute on
                this plot/Villa/Elite Unit/Apartment (Para #.1), if any I shall
                defend in the court(s) and Palm Villas (Pvt) Ltd. has no
                responsibility in this regard.
            </div>
            <div>
                <p>
                    8. That what is stated above is true to the best of my
                    knowledge and belief.
                </p>
            </div>

            <div>
                <p>
                    Deponent
                </p>
            </div>
            <div>
                <p>
                    <u>Verifications:</u>
                </p>
            </div>
            <div>
                <p>
                    Verified on Oath at Lahore this ____________ that the
                    contents
                    contained
                    in the above said affidavit are true and correct to the best
                    of
                    my
                    knowledge and believe and nothing has been concealed
                    therein.
                </p>
            </div>

            <div class="offset-11">
                <p>
                    Deponent
                </p>
            </div>

        </div>

@endsection
@section('script')
@endsection
