@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="dealer_create" class="dealer_create" action="{{route('sale.dealer.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            
                        </div>
                        <div class="card-link">
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="name" name="name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Contact No#</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="" id="contact_no" name="contact_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Agency Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="agency_name" name="agency_name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">CNIC No# <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm cnic" value="" id="cnic_no" name="cnic_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Commission(%)</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm validate_number" value="" id="commission" name="commission" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Dealer Type</label>
                                    </div>
                                    <div class="col-sm-9">
                                    <select name="dealer_type" id="dealer_type" class="form-select select2">
                                    <option value="">Select Dealer Type</option>
                                        @foreach (getDealerTypes() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                @include('partials.address')
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>
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
    <script src="{{ asset('/pages/sale/dealer/create.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
    <script>
        $(".cnic").inputmask({
            'mask': '99999-9999999-9'
        });
    </script>
@endsection
