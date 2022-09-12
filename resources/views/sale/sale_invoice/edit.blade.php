@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @php
        $current = $data['current'];
    @endphp
    @permission($data['permission'])
    <form id="sale_invoice_edit" class="sale_invoice_edit" action="{{route('sale.sale-invoice.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
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
                                        <b>{{$current->code}}</b>
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
                                                <option value="{{$project->id}}" {{$current->project_id == $project->id?"selected":""}}> {{$project->name}} </option>
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
                                                <option value="{{$property->id}}" {{$current->product_id == $property->id?"selected":""}}> {{$property->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Customer <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="customer_id" name="customer_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['customer'] as $customer)
                                                <option value="{{$customer->id}}" {{$current->customer_id == $customer->id?"selected":""}}> {{$customer->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="seller_type" name="seller_type">
                                            <option value="0" selected>Select</option>
                                            <option value="dealer" {{ $current->sale_by_staff == 0?"selected":""}}>Dealer</option>
                                            <option value="staff" {{ $current->sale_by_staff == 1?"selected":""}}>Staff</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller <span class="required">*</span></label>
                                    </div>
                                    @php
                                        $sellers = [];
                                        $selected_seller = [];
                                        if($current->sale_by_staff == 1){
                                            $sellers = App\Models\Staff::OrderByName()->get();
                                            $selected_seller = isset($current->staff->sale_sellerable_id)?$current->staff->sale_sellerable_id:"";
                                        }
                                        if($current->sale_by_staff == 0){
                                            $sellers = App\Models\Dealer::OrderByName()->get();
                                            $selected_seller = isset($current->dealer->sale_sellerable_id)?$current->dealer->sale_sellerable_id:"";
                                        }
                                    @endphp
                                    <div class="col-sm-9">
                                        <select class="select2 form-select sellerList" id="seller_id" name="seller_id">
                                            <option value='0' selected>Select</option>
                                            @foreach($sellers as $seller)
                                                <option value="{{$seller->id}}" {{$selected_seller == $seller->id?"selected":""}}>{{$seller->name}}</option>
                                            @endforeach
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
                                        <input type="text" class="form-control form-control-sm" value="{{$current->sale_price}}" id="sale_price" name="sale_price">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Booking Price</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->booked_price}}" id="booked_price" name="booked_price">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">is Installment</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_installment" name="is_installment" {{$current->is_installment == 1?"checked":""}}>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">is Booked</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_booked" name="is_booked" {{$current->is_booked == 1?"checked":""}}>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">is Purchased</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_purchased" name="is_purchased" {{$current->is_purchased == 1?"checked":""}}>
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
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/sale_invoice/edit.js') }}"></script>

@endsection

@section('script')
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
    </script>
@endsection
