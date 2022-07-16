@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @php
        $case = isset($data['form_type']) ? $data['form_type'] : "";
        if($case == 'new'){

        }
        if($case == 'edit'){
            $id = $data['current']->uuid;
            $name = $data['current']->name;
            $status = $data['current']->country_status;
        }
    @endphp
    <form id="country_form" class="country_form" action="{{route('setting.country.store',isset($id)?$id:"")}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">{{$data['action']}}</button>
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
                                        <label class="col-form-label">Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{isset($name)?$name:""}}" id="name" name="name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            @if($case == 'edit')
                                                @php $entry_status = isset($status)?$status:""; @endphp
                                                <input type="checkbox" class="form-check-input" id="country_status" name="country_status" {{$entry_status==1?"checked":""}}>
                                            @else
                                                <input type="checkbox" class="form-check-input" id="country_status" name="country_status" checked>
                                            @endif
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
    <script src="{{ asset('/pages/setting/country/form.js') }}"></script>
@endsection

@section('script')

@endsection
