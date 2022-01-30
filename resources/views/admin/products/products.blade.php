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
                            <h3 class="card-title">Products</h3>
                            <div >
                                <a href="{{url('admin/add-edit-product')}}" class="btn btn-block btn-success" style="float: right;max-width: 150px;
                                display:inline-block; ">Add Product</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Product color</th>
                                    <th>Product category</th>
                                    <th>Product section</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->product_code}}</td>
                                        <td>
                                            <?php $product_image_path = "img/product_img/small_img/".$product->main_image; ?>
                                                @if(!empty($product->main_image) && file_exists($product_image_path))
                                                    <img src="{{asset('img/product_img/small_img/'.$product->main_image)}}" style="width: 100px;">
                                                @else
                                                    <img src="{{asset('img/product_img/small_img/no_image.png')}}" style="width: 100px;">
                                                @endif
                                        </td>
                                        <td>{{$product->product_color}}</td>
                                        <td>{{$product->category->category_name}}</td>
                                        <td>{{$product->section->name}}</td>
                                        <td>
                                            @if ($product->status == 1)
                                                <a href="{{url('/admin/update-product-status',$product->id)}}" >Active</a>
                                            @else
                                                <a  href="{{url('/admin/update-product-status',$product->id)}}"  >Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/add-attributes/'.$product->id)}}"><i class="fas fa-plus"></i></a>
                                            <br>
                                            <br>
                                            <a href="{{url('/admin/add-edit-product/'.$product->id)}}"><i class="fas fa-edit"></i></a>
                                            <br>
                                            <br>
                                            <a  href="javascript:void(0)" record="product" recordid="{{$product->id}}" class="confirmDelete" name="Product"><i class="fas fa-trash-alt"></i></a> <!-- Previous url href="url('/admin/delete-category/'.$category->id)}}"-->
                                            <br>
                                            <br>
                                            <a href="{{url('/admin/add-images/'.$product->id)}}"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>product image</th>
                                    <th>Product color</th>
                                    <th>Product category</th>
                                    <th>Product section</th>
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
