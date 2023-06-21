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
                                {{-- @permission($data['permission_create']) --}}
                                <a href="{{route('refund-file-print')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" target="_blank">Print</a>
                                <a href="{{route('sale.refund-file.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                                {{-- @endpermission --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-datatable">

                                <table class="datatables-ajax table table-responsive" data-url="{{route('queries.index')}}">
                                    <thead>
                                    <tr>

                                        <th class="cell-fit">Query Number</th>
                                        <th class="cell-fit">query date</th>
                                        <th class="cell-fit">query Type</th>
                                        <th class="cell-fit">action taken</th>
                                        <th class="cell-fit">forwarded to</th>
                                        <th class="cell-fit">Customer name</th>

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
