@extends('layouts.print_layout')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
@permission($data['permission'])
@section('page_title', $data['title'])
@php
    $current = $data['current'];
    $sum_debit = 0;
    $sum_credit = 0;
@endphp
<table class="info-table" width="100%">
    <tbody>
        <tr>
            <td width="10%">
                <div class="info-block">
                    <span class="heading heading-block">Code :</span>
                    <span class="normal normal-block">{{$current->voucher_no}}</span>
                </div>
                <div class="info-block">
                    <span class="heading heading-block">Date :</span>
                    <span class="normal-block">{{date('Y-m-d',strtotime($current->date))}}</span>
                </div>
            </td>
            <td width="33.33%">
            </td>
            <td width="33.33%">
                <div class="info-block">
                    <span class="heading heading-block">Remarks :</span>
                    <span class="normal-block">{{$current->remarks}}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table class="data-table" width="100%">
    <thead>
        <tr>
            <th width="5%">Sr No#</th>
            <th width="10%">Account Code</th>
            <th width="15%">Account Name</th>
            <th width="10%">Cheque No#</th>
            <th width="10%">Cheque Date</th>
            <th width="20%">Description</th>
            <th width="15%">Debit</th>
            <th width="15%">Credit</th>
        </tr>
    </thead>
    <tbody>
        @if(isset( $data['dtl']) && count( $data['dtl']) > 0)
            @foreach($data['dtl'] as $dtl)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$dtl->chart_account_code}}</td>
                    <td>{{$dtl->chart_account_name}}</td>
                    <td>{{$dtl->cheque_no}}</td>
                    @php
                        $cheque_date = date('d-m-Y',strtotime($dtl->cheque_date));
                        $cheque_date = ($cheque_date == '01-01-1970')?"":$cheque_date;
                    @endphp
                    <td>{{$cheque_date}}</td>
                    <td>{{$dtl->description}}</td>
                    <td class="text-right">{{ format_number($dtl->debit)}}</td>
                    <td class="text-right">{{ format_number($dtl->credit)}}</td>
                </tr>
                @php
                $sum_debit += $dtl->debit;
                $sum_credit += $dtl->credit;
                @endphp
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="border-right">Total in figures</td>
            <td class="text-right border-right">
                {{$sum_debit }}
            </td>
            <td class="text-right border-right">
            {{ $sum_credit }}
            </td>
        </tr>
        <tr>
            <td colspan="6" class="border-right">Total in Words</td>
            <td class="text-right border-right">
                {{ numberToWords($sum_debit) }} rupees only
            </td>
            <td class="text-right">
            {{ numberToWords($sum_credit) }} rupees only
            </td>
        </tr>
        </tfoot>
</table>

<table class="mt-150" width="100%" valign="bottom">
    <tr>
        <th width="25%"><hr class="sign-line">{{trans('label.prepared_by')}}</th>
        <th width="25%"><hr class="sign-line">{{trans('label.authorized_by')}}</th>
        <th width="25%"><hr class="sign-line">Generated By: {{auth()->user()->name}}</th>
        <th width="25%"></th>
    </tr>
</table>
@endpermission
@endsection
@section('script')
@endsection
