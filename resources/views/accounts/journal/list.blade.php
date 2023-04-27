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
                            <a href="{{route('accounts.journal.revertList')}}" class="btn btn-danger btn-sm waves-effect waves-float waves-light">Archive List</a>
                            @permission($data['permission_create'])
                            <a href="{{route('accounts.journal.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            @permission($data['permission_list'])
                            <table class="datatables-ajax table table-responsive" data-url="{{route('accounts.journal.index')}}">
                                <thead>
                                <tr>
                                    <th class="">Date</th>
                                    <th class="">Voucher No</th>
                                    <th class="cell-fit text-center">status</th>
                                    <th class="cell-fit">Total</th>
                                    <th class="cell-fit">Prepared By</th>
                                    <th class="cell-fit">Approved By</th>
                                    <th class=""></th>
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
