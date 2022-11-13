@extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
    <style>
        .datatables-ajax>tbody>tr:hover {
            background: #f0f8ff;
        }
    </style>
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
                            <a href="{{route('setting.project.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            @permission($data['permission_list'])
                            <table class="datatables-ajax table table-responsive" data-url="{{route('setting.project.index')}}">
                                <thead>
                                <tr>
                                    <th class="cell-fit">Name</th>
                                    <th class="cell-fit">Contact No</th>
                                    <th class="cell-fit">Company</th>
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
    <script>
        $(document).on('click','.datatables-ajax>tbody>tr>td',function(){
            var thix = $(this);
            if(thix.find('a.item-edit').length == 0){
                var tr = thix.parents('tr');
                var edit_url = tr.find('a.item-edit').attr('href');
                location.href = edit_url+'?view=true'
            }
        })
    </script>
@endsection
