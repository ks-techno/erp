@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('sale.customer.update',$data['id']);
        }
    @endphp
    <form id="customer_edit" class="customer_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @if(!$data['view'])
            @csrf
            @method('patch')
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            @if($data['view'])
                                @permission($data['permission_edit'])
                                <a href="{{route('sale.customer.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                @endpermission
                            @else
                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                            @endif
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
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Father Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->father_name}}" id="father_name" name="father_name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Husband Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->husband_name}}" id="husband_name" name="husband_name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Contact No#</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="{{$current->contact_no}}" id="contact_no" name="contact_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Mobile No#</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="{{$current->mobile_no}}" id="mobile_no" name="mobile_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->email}}" id="email" name="email" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">CNIC No# <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm cnic" value="{{$current->cnic_no}}" id="cnic_no" name="cnic_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Nominee No.</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->nominee_no}}" id="nominee_no" name="nominee_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Nominee Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->nominee_name}}" id="nominee_name" name="nominee_name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Registration No.</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm"  value="{{$current->registration_no}}" id="registration_no" name="registration_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Membership No.</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" disabled value="{{$current->membership_no}}" id="membership_no" name="registration_no" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status"
                                                {{$current->status == 1?"checked":""}}>
                                        </div>
                                    </div>
                                </div>
                                @include('partials.address')
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
    <script src="{{ asset('/pages/sale/customer/edit.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
    <script>
        $(".cnic").inputmask({
            'mask': '99999-9999999-9'
        });
    </script>
@endsection
