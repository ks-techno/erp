@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="user_create" class="user_create" action="{{route('setting.user.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
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
                                                <label class="col-form-label">Email <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="" id="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Default Project <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="project_id" name="project_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['projects'] as $project)
                                                        <option value="{{$project->id}}"> {{$project->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Optional Project</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="projects" name="projects[]" multiple>
                                                    @foreach($data['projects'] as $project)
                                                        <option value="{{$project->id}}"> {{$project->name}} </option>
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
                                                <label class="col-form-label">Status</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-primary form-switch">
                                                    <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Password <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-sm" value="" id="password" name="password" />
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Confirm Password <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-sm" value="" id="confirm_password" name="confirm_password" />
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
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/setting/user/create.js') }}"></script>
@endsection

@section('script')

@endsection
