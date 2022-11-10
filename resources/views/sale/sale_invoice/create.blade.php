@extends('layouts.form')
@section('title', $data['title'])
@section('style')
    <style>
        .right .modal-dialog {
            position: fixed;
            margin: auto;
           /* width: 320px;*/
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .show .modal-dialog {
            /*position: absolute;*/right: 0px !important;
        }
        .right.fade .modal-dialog {
            right: -320px;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }
        .right.fade.in .modal-dialog {
            right: 0;
        }
    </style>
@endsection

@section('content')
    @permission($data['permission'])
    <form id="sale_invoice_create" class="sale_invoice_create" action="{{route('sale.sale-invoice.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <b>{{$data['code']}}</b>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Project <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="project_id" name="project_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['project'] as $project)
                                                <option value="{{$project->id}}"> {{$project->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Product <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="product_id" name="product_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['property'] as $property)
                                                <option value="{{$property->id}}"> {{$property->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Customer <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="customer_name" type="text" class="customer_name form-control form-control-sm text-left">
                                            <input id="customer_id" type="hidden" name="customer_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="customer_id" name="customer_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['customer'] as $customer)
                                                <option value="{{$customer->id}}"> {{$customer->name}} </option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-select" id="seller_type" name="seller_type">
                                            <option value="0" selected>Select</option>
                                            <option value="dealer">Dealer</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select sellerList" id="seller_id" name="seller_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Sale Price</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" readonly class="form-control form-control-sm" id="sale_price" name="sale_price">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Booking Price</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" id="booked_price" name="booked_price">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">is Installment</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_installment" name="is_installment" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">is Booked</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_booked" name="is_booked">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">is Purchased</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_purchased" name="is_purchased">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade right" id="createNewCustomer" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Customer <small>New</small></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
                </div>
                <div class="modal-body" style="height:100vh">
                    <p>
                        Biscuit powder jelly beans. Lollipop candy canes croissant icing chocolate cake. Cake fruitcake
                        powder pudding pastry.
                    </p>
                    <p>
                        Tootsie roll oat cake I love bear claw I love caramels caramels halvah chocolate bar. Cotton
                        candy gummi bears pudding pie apple pie cookie. Cheesecake jujubes lemon drops danish dessert I
                        love caramels powder.
                    </p>
                    <p>
                        Chocolate cake icing tiramisu liquorice toffee donut sweet roll cake. Cupcake dessert icing
                        dragée dessert. Liquorice jujubes cake tart pie donut. Cotton candy candy canes lollipop
                        liquorice chocolate marzipan muffin pie liquorice.
                    </p>
                    <p>
                        Powder cookie jelly beans sugar plum ice cream. Candy canes I love powder sugar plum tiramisu.
                        Liquorice pudding chocolate cake cupcake topping biscuit. Lemon drops apple pie sesame snaps
                        tootsie roll carrot cake soufflé halvah. Biscuit powder jelly beans. Lollipop candy canes
                        croissant icing chocolate cake. Cake fruitcake powder pudding pastry.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal">Create</button>
                </div>
            </div>
        </div>
    </div>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/sale_invoice/create.js') }}"></script>

@endsection

@section('script')
    <script src="{{asset('/pages/help/customer_help.js')}}"></script>
    <script>
        $(document).on('change','#seller_type',function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
                ntoastr.error("Select Seller Type");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    seller_type : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.sale-invoice.getSellerList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var seller = response.data['seller'];
                            var length = seller.length;
                            var options = "<option value='0' selected>Select</option>";
                            for(var i=0;i<length;i++){
                                if(seller[i]['name']){
                                    options += '<option value="'+seller[i]['id']+'">'+seller[i]['name']+'</option>';
                                }
                            }
                            $('form').find('.sellerList').html(options);
                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });
            }
        })

        $(document).on('change','#product_id',function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
                //  ntoastr.error("Select Any Product");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    product_id : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.sale-invoice.getProductDetail') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var product = response.data['product'];

                            $('form').find('#sale_price').val(product.default_sale_price);
                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });
            }
        })
    </script>
@endsection
