<div id="inLineHelp" data-id="product">
    <div class="inLineHelp inline_help_table">
        <style>

            div.inline_help {
                background: #bbc8fd;
                position: absolute;
                left: 0;
                z-index: 9999;
                width: 100%;
                box-shadow: 0px 3px 5px 0px #d4d4d4;
                max-height: 230px;
                overflow: auto;
            }
            #inLineHelp{
                position: absolute;
                width: 500px;
                height: 230px;
                z-index: 9999;
            }
            div.inline_help_table {
                background: #bbc8fd;
                position: sticky;
                width: 100% !important;
                max-height: 100% !important;
                overflow-y: scroll !important;
                position: -webkit-sticky
            }
            .data_tbody_row.selected_row,
            .data_tbody_row:hover{
                background-color: #e8e8e8;
            }
            .data_tbody_row>table {
                table-layout: fixed;
            }
            .inline_help_table>.data_thead_row>table>thead>tr>th,
            .inline_help>.data_thead_row>table>thead>tr>th {
                background: #5578eb;
                color: #fff !important;
                padding-top: 5px;
                padding-bottom: 5px;
                padding-left: 5px;
            }
            .inline_help>.data_thead_row>table>thead>tr>th,
            .inline_help>.data_tbody_row>table>tbody>tr>td,
            .inline_help_table>.data_thead_row>table>thead>tr>th,
            .inline_help_table>.data_tbody_row>table>tbody>tr>td{
                /*white-space: nowrap;*/
                text-overflow: ellipsis;
                overflow: hidden;
                border: 1px solid #e6e8f3;
                font-weight: 400;
                color: #212529;
                font-size: 12px;
                padding-top: 5px;
                padding-bottom: 5px;
                padding-left: 5px;
            }
            .inline_help_table>.data_thead_row>table>thead>tr>th,
            .inline_help_table>.data_tbody_row>table>tbody>tr>td {
                font-weight: 600 !important;
                padding-top: 5px;
                padding-bottom: 5px;
                padding-left: 5px;
            }
            .inline_help>.data_tbody_row>table>tbody>tr.data-dtl {
                background-color: #f7f8fa;
            }
            .data_tbody_row:hover>table>tbody>tr>td,
            .data_tbody_row.selected_row>table>tbody>tr>td,
            .data_tbody_row.selected_row>table>tbody>tr>td:hover {
                background: #dedede;
            }
            .data_tbody_row:hover {
                cursor: pointer;
            }
        </style>
        <div class="data_thead_row" id="productHelp">
            <table border="1" class="" width="100%">
                <thead>
                <tr>
                    <th data-field="Product Code" width="25%">Registration No.</th>
                    <th data-field="Product Name" width="50%">Plot Number</th>
                    <th data-field="Sale Price" width="25%">Block</th>
                </tr>
                </thead>
            </table>
        </div>
        @if(count($data['property']) == 0)
            <div class="data_tbody_row">
                <table border="1" class="val_table" width="100%">
                    <tbody>
                    <tr class="data-dtl">
                        <td data-view="show">Data not found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endif
        @foreach($data['property'] as $property)
            <div class="data_tbody_row">
                <table border="1" class="val_table" width="100%">
                    <tbody>
                    <tr class="data-dtl">
                        <td data-field="product_code" width="25%">{{$property->code}}</td>
                        <td data-view="show" data-field="product_name" width="50%">{{$property->name}}</td>
                            @php
                                $prod_var = $data['prod_var'];
                            @endphp
                            @if(isset($prod_var['input']))
                                @foreach($prod_var['input'] as $input_name=>$input_list)
                                    @php
                                        $thix_list = $input_list[0];
                                        $product_variation = $thix_list['product_variation'];
                                    @endphp
                                @if($product_variation['display_title']=='Block')
                        <td data-view="show" data-field="sale_price" width="25%">{{isset($data['property_values'][$input_name])?current($data['property_values'][$input_name]):""}}</td>
                        @endif            
                        @endforeach
                            @endif
                    </tr>
                    <tr class="d-none">
                        <td data-field="product_id">{{$property->id}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
