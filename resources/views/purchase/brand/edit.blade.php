@extends('layouts.form')
@section('title', $data['title'])
@section('style')
<style>
.text-right{
    margin-left: 740px;
}
    </style>
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('purchase.brand.update',$data['id']);
        }
    @endphp
    <form id="brand_edit" class="brand_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @if(!$data['view'])
            @csrf
            @method('patch')
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            </div>
                                <div class="card-link">  
                            @if($data['view'])
                                @permission($data['permission_edit'])
                              
                                <a href="{{route('purchase.brand.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                                @endpermission
                               @else
                              
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                        <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                         @endif
                    </div>
                  </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status"
                                                {{$current->status == 1?"checked":""}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/purchase/brand/edit.js') }}"></script>
@endsection

@section('script')

@endsection
