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
            </div>
            <!-- /.container-fluid -->
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
                            <h3 class="card-title">Categories</h3>
                            <div >
                                <a href="{{url('admin/add-edit-category')}}" class="btn btn-block btn-success" style="float: right;max-width: 150px;
                                display:inline-block; ">Add Category</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Section</th>
                                    <th>Parent Category</th>
                                    <th>Category</th>
                                    <th>URl</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    @if(!isset($category->parentcategory->category_name))
                                        <?php $parent_category = "Root"; ?>
                                    @else
                                        <?php $parent_category = $category->parentcategory->category_name; ?>
                                    @endif
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->section->name}}</td>
                                        <td>{{$parent_category}}</td>
                                        <td>{{$category->category_name}}</td>
                                        <td>{{$category->url}}</td>
                                        <td>
                                            @if ($category->status == 1)
                                                <a href="{{url('/admin/update-category-status',$category->id)}}" >Active</a>
                                            @else
                                                <a  href="{{url('/admin/update-category-status',$category->id)}}"  >Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/add-edit-category/'.$category->id)}}">Edit</a>
                                            <br>
                                            <br>
                                            <a  href="javascript:void(0)" record="category" recordid="{{$category->id}}" class="confirmDelete" name="Category">Delete</a> <!-- Previous url href="url('/admin/delete-category/'.$category->id)}}"-->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Section</th>
                                    <th>Parent Category</th>
                                    <th>Category</th>
                                    <th>URl</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
