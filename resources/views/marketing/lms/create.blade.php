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
                            <a class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>

                    <div class="card-body mt-2">

                        <div class="row">

                            <div class="col-sm-2">
                                <label class="col-form-label">ID<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                            <div class="col-sm-2">
                                <label class="col-form-label">Name<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Select Date: <span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="start_date" name="start_date"
                                    class="form-control form-control-sm flatpickr-basic flatpickr-input"
                                    placeholder="YYYY-MM-DD" value="" />
                            </div>

                            <div class="col-sm-2">
                                <label class="col-form-label">Contact No#<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Email Address</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>

                            <div class="col-sm-2">
                                <label class="col-form-label">Lead Status<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>
                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Assigned To<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control form-control-sm " id="assigned_to" name="assigned_to" aria-invalid="false">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>


                            <div class="col-sm-2">
                                <label class="col-form-label">Feedback</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment"
                                    name="down_payment" aria-invalid="false">
                            </div>
                        </div>

                        <div class="mt-2 row">

                            <div class="col-sm-2">
                                <label class="col-form-label">Follow Up<span class="required">*</span></label>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control form-control-sm" id="follow_up" name="follow_up" aria-invalid="false">
                                    <option value="">Select Follow Up</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>


                            <div class="col-sm-2">
                                <label class="col-form-label">Remarks:</label>
                            </div>
                            <div class="col-sm-3">
                                <textarea class="form-control form-control-sm" rows="1" name="remarks" id="remarks"></textarea>
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
