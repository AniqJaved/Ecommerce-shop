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
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Brands</h2>
                            <div >
                                <a href="{{url('admin/add-edit-brand')}}" class="btn btn-block btn-success" style="float: right;max-width: 150px;
                                display:inline-block; ">Add Brand</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="sections" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $brand)
                                    <tr>
                                        <td>{{$brand->id}}</td>
                                        <td>{{$brand->name}}</td>
                                        <td>
                                            @if ($brand->status == 1)
                                                <a href="{{url('/admin/update-brand-status',$brand->id)}}" >Active</a>
                                            @else
                                                <a  href="{{url('/admin/update-brand-status',$brand->id)}}"  >Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/add-edit-brand/'.$brand->id)}}"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a  href="javascript:void(0)" record="brand" recordid="{{$brand->id}}" class="confirmDelete" name="Brand"><i class="fas fa-trash-alt"></i></a> <!-- Previous url href="url('/admin/delete-category/'.$category->id)}}"-->

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
