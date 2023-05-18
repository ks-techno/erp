@extends('layouts.auth')
@section('title', 'Default Project')
@section('style')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo--><a class="brand-logo" href="javascript:;">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:100px;">
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('assets/images/pages/login-v2.svg')}}" alt="Login V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">Welcome to KSD! 👋</h2>
                            {{--<p class="card-text mb-2">Please sign-in to your account</p>--}}
                            <form id="default_project_store" class="default-project-form mt-2" action="{{ route('defaultProjectStore') }}" method="POST">
                                @csrf
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">Project</label>
                                    <select class="select2 form-select" id="project_id" name="project_id">
                                        <option value="0" selected>Select</option>
                                        @if(count($data->projects) != 0)
                                            @foreach($data->projects as $project)
                                                <option value="{{$project->id}}"> {{$project->name}} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button class="btn btn-primary w-100" tabindex="4">Continue</button>
                            </form>
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageJs')
    <script src="{{asset('pages/auth/default-project.js')}}"></script>
@endsection

@section('script')

@endsection
