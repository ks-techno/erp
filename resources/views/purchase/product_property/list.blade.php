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
                                @permission($data['print'])
                                <a href="{{route('product-property-print')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Print</a>
                                @endpermission
                                @permission($data['permission_create'])
                                <a href="{{route('product-property.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                                @endpermission
                            </div>
    
                        </div>
                        <div class="card-body">
                            <div class="card-datatable">
                                @permission($data['permission_list'])
                                <table class="datatables-ajax table table-responsive" data-url="{{route('product-property.index')}}">
                                    <thead>
                                    <tr>
                                        <th class="cell-fit">Code</th>
                                        <th class="cell-fit">Plot No</th>
                                        <th class="cell-fit">property type</th>
                                        <th class="cell-fit">block</th>
                                        <th class="cell-fit text-center">Status</th>
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
<script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
<script>
    var entry_date = $('#entry_date');
        if (entry_date.length) {
            entry_date.flatpickr({
                dateFormat: 'd-m-Y',
            });
        }
</script>
@endsection
