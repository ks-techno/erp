@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @php
        $current = $data['current'];
        $country_id = isset($current->addresses->country_id)?$current->addresses->country_id:"";
        $region_id = isset($current->addresses->region_id)?$current->addresses->region_id:"";
        $city_id = isset($current->addresses->city_id)?$current->addresses->city_id:"";
        $city_id = isset($current->addresses->city_id)?$current->addresses->city_id:"";
        $address = isset($current->addresses->address)?$current->addresses->address:"";
    @endphp
    <form id="staff_edit" class="staff_edit" action="{{route('setting.staff.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Name <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Contact No# </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="{{$current->contact_no}}" id="contact_no" name="contact_no" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Project <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="project_id" name="project_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['projects'] as $project)
                                                        <option value="{{$project->id}}" {{$project->id == $current->project_id?"selected":""}}> {{$project->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Department <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="department_id" name="department_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['departments'] as $department)
                                                        <option value="{{$department->id}}" {{$department->id == $current->department_id?"selected":""}}> {{$department->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Country <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select countryList" id="country_id" name="country_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['countries'] as $country)
                                                        <option value="{{$country->id}}" {{$country_id == $country->id?"selected":""}}> {{$country->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Region <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                @php
                                                    $regions = \App\Models\Region::where(['country_id'=>$country_id])->get()
                                                @endphp
                                                <select class="select2 form-select regionList" id="region_id" name="region_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($regions as $region)
                                                        <option value="{{$region->id}}" {{$region_id == $region->id?"selected":""}}> {{$region->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">City <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                @php
                                                    $cities = \App\Models\City::where(['country_id'=>$country_id,'region_id'=>$region_id])->get()
                                                @endphp
                                                <select class="select2 form-select cityList" id="city_id" name="city_id">
                                                    <option value="0" selected>Select</option>]
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" {{$city_id == $city->id?"selected":""}}> {{$city->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Address </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="address" name="address" value="{{$address}}">
                                            </div>
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
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/setting/staff/edit.js') }}"></script>
@endsection

@section('script')

@endsection
