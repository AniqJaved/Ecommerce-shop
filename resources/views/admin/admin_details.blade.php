@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/admin/update-admin-details')}}">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Change password</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{Session::get('error_message')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
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
                            <div style="margin-top: 10px;">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <form role="form" method="post" action="{{url('/admin/update-admin-details')}}"
                                  name="updatePasswordForm" id="updatePasswordForm" enctype="multipart/form-data">@csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Email</label>
                                        <input type="email" class="form-control" id="email" name="email" readonly="" value="{{$adminDetails->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Type</label>
                                        <input type="type" class="form-control" id="type" readonly="" value="{{$adminDetails->type}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Admin name</label>
                                        <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Admin Name" required="" value="{{$adminDetails->name}}">
                                        <span id="chkCurrentPwd"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mobile</label>
                                        <input type="text" class="form-control" id="admin_mobile" name="admin_mobile" placeholder="New mobile" required="" value="{{$adminDetails->mobile}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="Image">Upload</label>
                                        <input type="file" class="form-control" name="admin_image" id="admin_image" accept="image/*">
                                        @if(!empty(Auth::guard('admin')->user()->image))
                                            <a href="{{url('img/admin_img/admin_photos/'.Auth::guard('admin')->user()->image)}}" target="_blank">View image</a>
                                            <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                                        @endif
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection
