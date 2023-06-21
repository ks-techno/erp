@php
        $sum_debit = 0;
        $sum_credit = 0;
        $balance = 0;
@endphp
<table class="data-table tbl-booking" width="100%" border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
        <th class="text-left">Account Name</th>
        <th class="text-left">Account Code</th>
        <th class="text-left">Date</th>
        <th class="text-left ">Debit</th>
        <th class="text-left">Credit</th>
        <th class="text-left">Balance</th>
       
        </tr>
    </thead>
    <tbody>
    @foreach($data['results'] as $result)
   
    <tr>
    <td class="text-left">{{isset($result->voucher->chart_account_name) ? $result->voucher->chart_account_name : ""}}</td>
        <td class="text-left">{{isset($result->voucher->chart_account_code) ? $result->voucher->chart_account_code : ""}}</td>
        <td class="text-left">{{isset($result->voucher->date) ? $result->voucher->date : ""}}</td>
        <td class="text-left">{{format_number($result->voucher->debit)}}</td>
        <td class="text-left">{{ format_number($result->voucher->credit)}}</td>
        <td class="text-left">
        @php
        
        $sum_debit += $result->voucher->debit;
        $sum_credit += $result->voucher->credit;
        $balance = $sum_credit - $sum_debit;
    @endphp
    {{format_number($balance)}}
        </td>
    </tr>
   
@endforeach


    </tbody>
</table>