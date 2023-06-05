@extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
@endsection
@php
    $entry_date = date('Y-m-d');
@endphp
@section('content')
    <div class="datatable">
    <!-- Datatable -->
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                        </div>
                        <div class="card-link">
                            <a href="{{route('exportPDF')}}" class="btn btn-danger btn-sm waves-effect waves-float waves-light">Export to PDF</a>
                           
                        </div>
                       
                    </div>
                    <div class="row mb-1 mt-2 mx-3">
                            <div class="col-sm-3">
                            <label class="col-form-label p-0 ">Vocuher Type: <span class="required">*</span></label>
                            <select name="voucher_type" id="voucher_type" class="form-select select2">
                                    <option value="">Select Vocuher Type</option>
                                        @foreach (getvoucherTypes() as $key => $value)
                                            <option value="{{ $key }}" data-slug="{{$key}}">{{ $value }}</option>
                                        @endforeach
                                        </select>
                            </div>
                            <div class="col-sm-3">
                            <label class="col-form-label p-0">Entry Date: <span class="required">*</span></label>
                            <input type="text" id="entry_date" name="date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($entry_date))}}" />
                            </div>
                            <div class="col-sm-3 mt-2">
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Search</button>

                            </div>
                        </div>
                        <hr>
                    <div class="card-body">
                        <div class="card-datatable">
                            @permission($data['permission_list'])
                            <table class="datatables-ajax table table-responsive" data-url="{{route('accounts.ledgers.index')}}">
                                <thead>
                                <tr>
                                    <th class="cell-fit">Date</th>
                                    <th class="cell-fit">Voucher No</th>
                                    <th class="cell-fit ">Type</th>

                                    <th class="cell-fit text-center">Status</th>
                                    <th class="cell-fit">Total Amount</th>
                                    <th class="cell-fit"></th>
                                </tr>
                                </thead>
                            </table>
                            @endpermission
                        </div>
                    </div>
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

@endsection
