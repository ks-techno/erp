@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
@permission($data['permission_create'])
    <form id="scp_create" class="scp_create" action="{{route('setting.scp.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                    <div class="mb-1 row">
                                    <div class="col-sm-2">
                                        <label class="col-form-label">Property Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="select2 form-select" id="property_typeID" name="property_typeID">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['buyable'] as $buyable)
                                                <option value="{{$buyable->id}}"> {{$buyable->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                    <div class="mt-2 row">

                    <div class="col-sm-2">
                        <label class="col-form-label p-0">Department <span class="required">*</span></label>
                    </div>
                    <div class="col-sm-3">
                    <select class="select2 form-select" id="department_id" name="department_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['department'] as $department)
                                                <option value="{{$department->id}}"> {{$department->name}} </option>
                                            @endforeach
                                        </select>
                    </div>
                    </div>

                    <div class="mt-2 row">
                    <div class="col-sm-2">
                        <label class="col-form-label p-0">Percentage<span class="required">*</span></label>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm FloatValidate" id="percentage" name="percentage" aria-invalid="false">
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
    <script src="{{ asset('/pages/setting/scp/create.js') }}"></script>
@endsection

@section('script')

@endsection
