@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Advanced Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Catalogue</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('success_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form name="bannerform" id="ProductForm"
                      @if(empty($bannerdata['id'])) action="{{url('admin/add-edit-banner/')}}"
                      @else action="{{url('admin/add-edit-banner/'.$bannerdata['id'])}}"
                      @endif method="post" enctype="multipart/form-data">@csrf
                <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{$title}}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="banner_title">Banner title</label>
                                        <input type="text" class="form-control" name="banner_title" id="banner_title" placeholder="Enter Banner title"
                                               @if(!empty($bannerdata['title']))
                                               value="{{$bannerdata['title']}}"
                                               @else
                                               value="{{old('title')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="banner_link">Banner Link</label>
                                        <input type="text" class="form-control" name="banner_link" id="banner_link" placeholder="Enter Banner link"
                                               @if(!empty($bannerdata['link']))
                                               value="{{$bannerdata['link']}}"
                                               @else
                                               value="{{old('link')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->

                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="banner_title">Banner Alternative text</label>
                                        <input type="text" class="form-control" name="banner_alt" id="banner_alt" placeholder="Enter Banner Alternative text"
                                               @if(!empty($bannerdata['alt']))
                                               value="{{$bannerdata['alt']}}"
                                               @else
                                               value="{{old('alt')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputFile">Banner image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        @if(!empty($bannerdata['image']))
                                            <img src="{{asset('img/banner_img/'.$bannerdata['image'])}}" width="200px" alt="">
                                            <a href="javascript:void(0)" class="confirmDelete" record="banner-image" recordid="{{$bannerdata['id']}}" name="image" >Delete image</a>
                                        @endif

                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
