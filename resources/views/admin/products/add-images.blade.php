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
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{Session::get('error_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form name="addimageform" id="AddImageForm" action="{{url('/admin/add-images/'.$productdata['id'])}}" method="post" enctype="multipart/form-data">@csrf
                <!-- SELECT2 EXAMPLE -->
                    <input type="hidden" name="product_id" value="{{$productdata['id']}}">
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
                                        <label for="product_color" style="font-weight: normal;"><span style="font-weight: bold;">Product Name:&nbsp;</span>{{$productdata['product_name']}}</label>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_color" style="font-weight: normal;"><span style="font-weight: bold;">Product Code:&nbsp;</span>{{$productdata['product_code']}}</label>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_color" style="font-weight: normal;"><span style="font-weight: bold;">Product Color:</span>&nbsp;{{$productdata['product_color']}}</label>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        @if(!empty($productdata['main_image']))
                                            <img src="{{asset('img/product_img/small_img/'.$productdata['main_image'])}}" width="100px" alt="">
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <br>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <div class="field_wrapper">
                                        <div>
                                            <input id="images"  placeholder="Choose file" multiple=""  type="file" required name="images[]" style="width: 120px"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
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
                    <form name="editproductimageform" id="EditProductImageForm" action="{{url('/admin/edit-images/'.$productdata['id'])}}" method="post" enctype="multipart/form-data">@csrf

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Added product images</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="products" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Images</th>
                                        <th>Action</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($productdata['images'] as $productimages)
                                        <input style="display: none;" type="text" name="attrId[]" value="{{$productimages['id']}}">
                                        <tr>
                                            <td>{{$productimages['id']}}</td>
                                            <td>
                                                @if(!empty($productimages['image']))
                                                    <img src="{{asset('img/product_img/small_img/'.$productimages['image'])}}" width="100px" alt="">
                                                @endif
                                            </td>

                                            <td>
                                                @if ($productimages['status'] == 1)
                                                    <a href="{{url('/admin/update-image-status',$productimages['id'])}}" >Active</a>
                                                @else
                                                    <a  href="{{url('/admin/update-image-status',$productimages['id'])}}"  >Inactive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a  href="javascript:void(0)" record="image" recordid="{{$productimages['id']}}" class="confirmDelete" name="ProductsImage"><i class="fas fa-trash-alt"></i></a> <!-- Previous url href="url('/admin/delete-category/'.$category->id)}}"-->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Images</th>
                                        <th>Action</th>
                                        <th>Remove</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
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
