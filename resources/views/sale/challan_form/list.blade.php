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
                                @permission($data['permission_create'])
                                <a href="{{route('sale.challan-form.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                                @endpermission
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-datatable">
                                @permission($data['permission_list'])
                                <table class="datatables-ajax table table-responsive" data-url="{{route('sale.challan-form.index')}}">
                                    <thead>
                                    <tr>
                                        <th class="cell-fit">Challan Number</th>
                                        <th class="cell-fit">Plot Number</th>
                                        <th class="cell-fit">Prpoerty Type</th>
                                        <th class="cell-fit">Payment Mode</th>
                                        <th class="cell-fit">Customer</th>
                                        <th class="cell-fit">Status</th>
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
