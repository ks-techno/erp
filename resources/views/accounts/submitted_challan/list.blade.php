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
                            
                        </div>
                        <div class="card-body">
                            <div class="card-datatable">
                                @permission($data['permission_list'])
                                <table class="datatables-ajax table table-responsive" data-url="{{route('accounts.submitted-challan.index')}}">
                                    <thead>
                                    <tr>
                                        <th class="cell-fit">Challan Number</th>
                                        <th class="cell-fit">Plot Number</th>
                                        <th class="cell-fit">Block</th>
                                        <th class="cell-fit">Customer</th>
                                        <th class="cell-fit">File Status</th>
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
<script src="{{ asset('/pages/accounts/submitted_challan/create.js') }}"></script>
@endsection

@section('script')

@endsection
