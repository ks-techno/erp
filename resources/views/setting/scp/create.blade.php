@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
        <form id="user_create" class="user_create" action="{{ route('setting.user.store') }}" method="post"
            enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="card-left-side">
                                <h4 class="card-title">{{ $data['title'] }}</h4>

                            </div>
                            <div class="card-link">
                                <button type="submit"
                                    class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                                <a href="{{ $data['list_url'] }}"
                                    class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                            </div>
                        </div>

                        <div class="card-body mt-2">

                            <div class="row">

                                <div class="col-sm-2">
                                    <label class="col-form-label">Product <span class="required">*</span></label>
                                </div>

                                <div class="col-sm-3">

                                    <div class="input-group eg_help_block">
                                        <span class="input-group-text" id="addon_remove"><i
                                                data-feather='minus-circle'></i></span>
                                        <input id="product_name" type="text"
                                            class="product_name form-control form-control-sm text-left">
                                        <input id="product_id" type="hidden" name="product_id">
                                    </div>

                                </div>
                            </div>

                            <div class="mt-2 row">

                                <div class="col-sm-2">
                                    <label class="col-form-label p-0">Department <span class="required">*</span></label>
                                </div>
                                <div class="col-sm-3">
                                    <select class="select2 form-select" id="property_payment_mode_id1"
                                        name="property_payment_mode_id">
                                    </select>
                                </div>
                            </div>

                            <div class="mt-2 row">
                                <div class="col-sm-2">
                                    <label class="col-form-label p-0">Percentage<span class="required">*</span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment" name="down_payment" aria-invalid="false">
                                </div>
                            </div>

                        </div>
                    </div>
        </form>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/setting/user/create.js') }}"></script>
@endsection

@section('script')

@endsection
