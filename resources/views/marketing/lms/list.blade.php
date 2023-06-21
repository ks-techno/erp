@extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
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
                            <h4 class="card-title">{{$data['title']}}</h4>
                        </div>
                        <div class="card-link">
                            {{-- <a href="{{route('accounts.cash-payment.revertList')}}" class="btn btn-danger btn-sm waves-effect waves-float waves-light">Archive List</a> --}}
                            <a href="{{route('accounts.cash-payment.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <table class="datatables-ajax table table-responsive" data-url="{{route('accounts.cash-payment.index')}}">
                                <thead>
                                <tr>
                                    <th class="cell-fit">Name</th>
                                    <th class="cell-fit">Platform</th>
                                    <th class="cell-fit">Lead Status</th>
                                    <th class="cell-fit">Assigned to</th>
                                    <th class="cell-fit">Follow up</th>
                                    <th class="cell-fit">Remarks</th>
                                </tr>
                                </thead>
                            </table>
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
