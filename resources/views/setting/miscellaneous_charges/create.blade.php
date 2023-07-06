@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection
@php
$charges = $data['charges'];

@endphp
@section('content')
    <form id="charges_create" class="charges_create" action="{{ route('setting.miscellaneous-charges.store') }}" method="post"
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
                            <!-- <a href="{{ $data['list_url'] }}"
                                class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a> -->
                        </div>
                    </div>

                    <div class="card-body mt-2">

                        <div class="row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Select Project<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <select class="select2 form-select" id="project_id" name="project_id">
                                    <option value="0" selected>Select</option>
                                    @if ($charges)
                                    @foreach ($data['projects'] as $project)
                                        <option value="{{ $project->id }}" {{ $project->id == $charges->project_id ? 'selected' : '' }}> {{ $project->name }} </option>
                                    @endforeach
                                    @endif
                                    @foreach ($data['projects'] as $project)
                                        <option value="{{ $project->id }}" > {{ $project->name }} </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-2">
                                <label class="col-form-label">Surcharge<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="surcharge"
                                    name="surcharge" value ="{{ isset($charges->surcharge) ? $charges->surcharge:null }}"  aria-invalid="false">
                            </div>

                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Monthly Maintenance Fee<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="monthly_maintainance_fee"
                                    name="monthly_maintainance_fee" aria-invalid="false" value ="{{ isset($charges->monthly_maintainance_fee) ? $charges->monthly_maintainance_fee:null }}" >
                            </div>


                            <div class="col-sm-2">
                                <label class="col-form-label">Utility Charges<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="utility_charges"
                                    name="utility_charges" aria-invalid="false" value ="{{ isset($charges->utility_charges) ? $charges->utility_charges:null }}">
                            </div>

                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Other Charges<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="other_charges"
                                    name="other_charges" aria-invalid="false" value ="{{ isset($charges->other_charges) ? $charges->other_charges:null }}">
                            </div>

                        </div>

                    </div>{{-- Card Div --}}
                </div>
            </div>
        </div>
    </form>
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/setting/miscellaneous_charges/create.js') }}"></script>
@endsection

@section('script')

@endsection
