@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')

    @include('accounts.chart_of_account.form')

@endsection
@section('pageJs')
    @yield('pageJsScript')
@endsection

@section('script')
    @yield('scriptCustom')
@endsection