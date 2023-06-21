@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    <form id="user_create" class="user_create" action="{{ route('setting.user.store') }}" method="post"
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
                            <a href="{{ $data['list_url'] }}"
                                class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
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
                                    @foreach ($data['projects'] as $project)
                                        <option value="{{ $project->id }}"> {{ $project->name }} </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-2">
                                <label class="col-form-label">Surcharge<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Monthly maintenance fee<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>


                            <div class="col-sm-2">
                                <label class="col-form-label">Utility Charges<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                        </div>

                        <div class="mt-0 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Other Charges<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                        </div>

                    </div>{{-- Card Div --}}
                </div>
            </div>
        </div>
    </form>
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/setting/user/create.js') }}"></script>
@endsection

@section('script')

@endsection
