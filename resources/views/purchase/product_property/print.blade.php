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
@section('page_title', $data['title'])

<table class="data-table tbl-booking" width="100%">
    <thead>
        <tr>
            <th width="10%" class="text-left">Code</th>
            <th width="10%" class="text-left">Plot No.</th>
            <th width="10%" class="text-left">Sale Price</th>
            <th width="10%" class="text-left">Reg. No.</th>
            <th width="10%" class="text-left">Property Type</th>
            <th width="50%" class="text-left">Details</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data['property'] as $property)
        <tr>
            <td>{{isset($property->code)?$property->code:""}}</td>
            <td>{{isset($property->name)?$property->name:""}}</td>
            <td>{{isset($property->default_sale_price)?$property->default_sale_price:""}}</td>
            <td>{{isset($property->external_item_id)?$property->external_item_id:""}}</td>
            <td>{{isset($property->buyable_type->name)?$property->buyable_type->name:""}}</td>
            <td>
            @if(isset($property->id) && $property->id != null)
                @php
                  $prod = $property->id;
                  $sql = "SELECT p.id p_id,p.name p_name,p.buyable_type_id,pvs.value,pvs.product_variation_id,pv.display_title,pvs.sr_no FROM products p
                            left join property_variations pvs on pvs.product_id = p.id
                            left join product_variations pv on pv.id = pvs.product_variation_id
                            where p.id = $property->id order by pv.display_title;";
                  $variations = \Illuminate\Support\Facades\DB::select($sql);
                  $lists = [];
                  foreach ($variations as $variation){
                      $lists[$variation->display_title][] = $variation->value;
                  }
                  //dd($lists);
                @endphp
                @foreach($lists as $title=>$rows)
                    <div style="padding-bottom: 5px;width: 33%; float: left">
                        <b>{{$title}}:</b>
                        @if(count($rows) == 1)
                        @foreach($rows as $k=>$value)
                                <span>{{$value}}</span>
                        @endforeach
                        @else
                            @foreach($rows as $ki=>$val)
                                <span>{{$value}}, </span>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endif
        </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
@section('script')
@endsection
