@extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.min.css') }}">
    <!-- END: Vendor CSS-->
    @yield('themeStyle')
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themes/semi-dark-layout.css') }}">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/pickers/form-pickadate.css') }}">
@endsection

@section('content')
    <div class="datatable">
        <!-- Datatable -->
        <section id="ajax-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="card-left-side">
                                <h4 class="card-title">{{ $data['title'] }}</h4>
                            </div>

                            <div class="card-link">

                                <button type="submit"
                                    class="btn btn-success btn-sm waves-effect waves-float waves-dark">Today</button>
                                <a href="#"
                                    class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Yesterday</a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mt-2 row">
                                    <div class="col-sm-5">
                                        <label class="col-form-label">Select Date <span class="required">*</span></label>
                                    </div>
                                    <div class=" col-sm-9">
                                        <input type="text" id="date" name="date"
                                            class="form-control form-control-sm flatpickr-basic flatpickr-input"
                                            placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card-body">
                            <div class="card-datatable">
                                <table class="datatables-ajax table table-responsive"
                                    data-url="{{ route('customer.index') }}">
                                    <thead>
                                        <tr>
                                            <th class="cell-fit">Name</th>
                                            <th class="cell-fit">Contact No</th>
                                            <th class="cell-fit">Membership No.</th>
                                            <th class="cell-fit text-center">Status</th>
                                            <th class="cell-fit"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
        <!--/ Datatable -->
    </div>
@endsection

@section('pageJs')
@endsection

@section('script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('assets/js/scripts/forms/form-validation.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <script src="{{ asset('/js/jquery-12.js') }}"></script>
    <script src="{{ asset('/pages/common/erp_grid.js') }}"></script>
    <script src="{{ asset('/pages/help/chart_help.js') }}"></script>
    <script src="{{ asset('/pages/common/account-calculations.js') }}"></script>
@endsection
