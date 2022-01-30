@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Banners</h2>
                            <div >
                                <a href="{{url('admin/add-edit-banner')}}" class="btn btn-block btn-success" style="float: right;max-width: 150px;
                                display:inline-block; ">Add Banner</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="sections" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Image</th>
                                    <th>link</th>
                                    <th>title</th>
                                    <th>alt</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($banners as $banner)
                                    <tr>
                                        <td>{{$banner['id']}}</td>
                                        <td><img style="width: 200px" src="{{asset('img/banner_img/'.$banner['image'])}}" alt=""></td>
                                        <td>{{$banner['link']}}</td>
                                        <td>{{$banner['title']}}</td>
                                        <td>{{$banner['alt']}}</td>
                                        <td>
                                            @if ($banner['status'] == 1)
                                                <a href="{{url('/admin/update-banner-status',$banner['id'])}}" >Active</a>
                                            @else
                                                <a  href="{{url('/admin/update-banner-status',$banner['id'])}}"  >Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/add-edit-banner/'.$banner['id'])}}"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a  href="javascript:void(0)" record="banner" recordid="{{$banner['id']}}" class="confirmDelete" name="Banner"><i class="fas fa-trash-alt"></i></a> <!-- Previous url href="url('/admin/delete-category/'.$category->id)}}"-->

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>id</th>
                                    <th>Image</th>
                                    <th>link</th>
                                    <th>title</th>
                                    <th>alt</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Remove</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
