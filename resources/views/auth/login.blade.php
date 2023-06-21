@extends('layouts.auth')
@section('title', 'Login')
@section('style')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">

        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo--><a class="brand-logo" href="javascript:;">
                    <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height:100px;"> -->
                        <!-- <h2 class="brand-text text-primary ms-1">KSD</h2> -->
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->

                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Login V2" /></div>
                    </div>
                    
                    <!-- /Left Text-->

                    <!-- Login-->

                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5" >
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">Welcome to KSD! 👋</h2>
                            <!-- {{--<p class="card-text mb-2">Please sign-in to your account</p>--}} -->
                            <form id="auth_login_form" class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                                @csrf
                                
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">Email</label>
                                    <input class="form-control" id="email" type="text" name="email" aria-describedby="email" autofocus="" tabindex="1" />
                                </div>

                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">Password</label>
                                        <a href="{{route('password.show_form')}}"><small>Forgot Password?</small></a>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="password" type="password" name="password" aria-describedby="password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                                <!-- {{--<div class="mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                        <label class="form-check-label" for="remember-me"> Remember Me</label>
                                    </div>
                                </div>--}} -->
                                <button class="btn btn-primary w-100" tabindex="4">Sign in</button>
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
    <script src="{{asset('pages/auth/login.js')}}"></script>
@endsection

@section('script')

@endsection
