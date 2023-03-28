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
            <td width="33.33%">
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
            <th>Sr No#</th>
            <th>Account Code</th>
            <th>Account Name</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>
    <tbody>
        @if(isset( $data['dtl']) && count( $data['dtl']) > 0)
            @foreach($data['dtl'] as $dtl)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$dtl->chart_account_code}}</td>
                    <td>{{$dtl->chart_account_name}}</td>
                    <td>{{$dtl->description}}</td>
                    <td class="text-right">{{number_format($dtl->debit)}}</td>
                    <td class="text-right">{{number_format($dtl->credit)}}</td>
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
            <td colspan="4" class="border-right">Total in Words</td>
            <td class="text-right border-right">
                {{ numberToWords($sum_debit) }}
            </td>
            <td class="text-right">
            {{ numberToWords($sum_credit) }}
            </td>
        </tr>
        </tfoot>
</table>

<table class="mt-150" width="100%" valign="bottom">
    <tr>
        <th width="25%"><hr class="sign-line">{{trans('label.prepared_by')}}</th>
        <th width="25%"><hr class="sign-line">{{trans('label.authorized_by')}}</th>
        <th width="25%"></th>
        <th width="25%"></th>
    </tr>
</table>
@endpermission
@endsection
@section('script')
@endsection
