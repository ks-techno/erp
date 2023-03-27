<div id="inLineHelp" data-id="old_customer">
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
           /* for header fixed
           .inline_help_table>.data_thead_row{
                position: fixed;
                width: 484px;
            }*/
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
        <div class="data_thead_row" id="oldCustomerHelp">
            <table border="1" class="" width="100%">
                <thead>
                <tr>
                    <th data-field="Customer Name" width="50%">Customer Name</th>
                    <th data-field="Customer Phone" width="50%">Customer Phone</th>
                </tr>
                </thead>
            </table>
        </div>
        @if(count($data['old_customer']))
            <div class="data_tbody_row">
                <table border="1" class="val_table" width="100%">
                    <tbody>
                    <tr class="data-dtl">
                        <td class="create_new" data-view="show" data-field="create_new_customer">New Customer -  Create New
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        
        @foreach($data['old_customer'] as $customer)
            <div class="data_tbody_row">
                <table border="1" class="val_table" width="100%">
                    <tbody>
                    <tr class="data-dtl">
                        <td data-field="customer_name" width="50%">{{$customer->name}}</td>
                        <td data-view="show" data-field="customer_phone" width="50%">{{$customer->contact_no}}</td>
                    </tr>
                    <tr class="d-none">
                        <td data-field="customer_id">{{$customer->id}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
    @else
    <div class="data_tbody_row">
                <table border="1" class="val_table" width="100%">
                    <tbody>
                    <tr class="data-dtl">
                        <td class="create_new" data-view="show" data-field="create_new_customer">New Customer -  Create New
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
    @endif
</div>
