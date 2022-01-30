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
                <form name="productform" id="ProductForm"
                      @if(empty($productdata['id'])) action="{{url('admin/add-edit-product/')}}"
                      @else action="{{url('admin/add-edit-product/'.$productdata['id'])}}"
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
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product name"
                                               @if(!empty($productdata['product_name']))
                                               value="{{$productdata['product_name']}}"
                                               @else
                                               value="{{old('product_name')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($categories as $section)
                                                <optgroup label="{{$section['name']}}">
                                                    @foreach($section['categories'] as $category)
                                                        <option value="{{$category['id']}}"
                                                            @if(!empty(old('category_id') ) && $category['id']==old('category_id'))
                                                                selected=""
                                                            @elseif(!empty($productdata['category_id']) && $productdata['category_id']== $category['id'])
                                                                selected=""
                                                            @endif>{{$category['category_name']}}
                                                        </option>
                                                        @foreach($category['subcategories'] as $subcategory)
                                                            <option value="{{$subcategory['id']}}"
                                                                    @if(!empty(old('category_id') ) && $subcategory['id']==old('category_id'))
                                                                    selected=""
                                                                    @elseif(!empty($productdata['category_id']) && $productdata['category_id']== $subcategory['id'])
                                                                    selected=""
                                                                    @endif>
                                                                &nbsp;&nbsp;--&nbsp;&nbsp;{{$subcategory['category_name']}}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Select Brand</label>
                                        <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($brands as $brand)
                                                        <option value="{{$brand['id']}}"
                                                                @if(!empty(old('brand_id') ) && $brand['id']==old('brand_id'))
                                                                selected=""
                                                                @elseif(!empty($productdata['brand_id']) && $productdata['brand_id']== $brand['id'])
                                                                selected=""
                                                            @endif>{{$brand['name']}}
                                                        </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_discount">Product Price</label>
                                        <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter product price"
                                               @if(!empty($productdata['product_price']))
                                               value="{{$productdata['product_price']}}"
                                               @else
                                               value="{{old('product_price')}}"
                                            @endif>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_code">Product code</label>
                                        <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product code"
                                               @if(!empty($productdata['product_code']))
                                               value="{{$productdata['product_code']}}"
                                               @else
                                               value="{{old('product_code')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputFile">Product image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="main_image" name="main_image">
                                                <label class="custom-file-label" for="main_image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        @if(!empty($productdata['main_image']))
                                            <img src="{{asset('img/product_img/small_img/'.$productdata['main_image'])}}" width="100px" alt="">
                                            <a href="javascript:void(0)" class="confirmDelete" record="product-image" recordid="{{$productdata['id']}}" name="main_image" >Delete image</a> <!-- href="{{url('admin/delete-product-image/'.$productdata['id'])}}"-->
                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Product Video</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="product_video" name="product_video">
                                                <label class="custom-file-label" for="product_video">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        @if(!empty($productdata['product_video']))
                                            <div>
                                                <a href="{{url('videos/product_videos/'.$productdata['product_video'])}}" download>Download</a>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0)" class="confirmDelete" record="product-video" recordid="{{$productdata['id']}}" name="product_video" >Delete video</a>

                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label for="product_discount">Product Discount</label>
                                        <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Enter product name"
                                               @if(!empty($productdata['product_discount']))
                                               value="{{$productdata['product_discount']}}"
                                               @else
                                               value="{{old('product_discount')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_name">Product Description</label>
                                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Enter ..."
                                        >@if(!empty($productdata['description']))
                                                {{$productdata['description']}}
                                            @else
                                                {{old('description')}}
                                            @endif</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_name">Wash Care</label>
                                        <textarea class="form-control" rows="3" name="wash_care" id="wash_care" placeholder="Enter ..."
                                        >@if(!empty($productdata['wash_care']))
                                                {{$productdata['wash_care']}}
                                            @else
                                                {{old('wash_care')}}
                                            @endif</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Select fabric</label>
                                        <select name="fabric" id="fabic" class="form-select select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($fabricArray as $fabric)
                                                <option
                                                    @if(!empty($productdata['fabric']) && $productdata['fabric']==$fabric)
                                                        selected=""
                                                    @endif
                                                    value="{{$fabric}}">
                                                    {{$fabric}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Select fit</label>
                                        <select name="fit" id="fit" class="form-select select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($fitArray as $fit)
                                                <option
                                                    @if(!empty($productdata['fit']) && $productdata['fit']==$fit)
                                                    selected=""
                                                    @endif
                                                    value="{{$fit}}">
                                                    {{$fit}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->

                                    <div class="form-group">
                                        <label for="category_name">Meta Keywords</label>
                                        <textarea class="form-control" rows="3" name="meta_keywords" id="meta_keywords" placeholder="Enter ..."
                                        >@if(!empty($categorydata['meta_keywords']))
                                                {{$categorydata['meta_keywords']}}
                                            @else
                                                {{old('meta_keywords')}}
                                            @endif</textarea>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="featured_item">Featured item</label>
                                        <input
                                            @if(!empty($productdata['is_featured']) && $productdata['is_featured']=='Yes')
                                            checked=""
                                            @endif
                                            type="checkbox" name="is_featured" id="is_featured" value="Yes">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="product_weight">Product Weight</label>
                                        <input type="text" class="form-control" name="product_weight" id="product_weight" placeholder="Enter product weight"
                                               @if(!empty($productdata['product_weight']))
                                               value="{{$productdata['product_weight']}}"
                                               @else
                                               value="{{old('product_weight')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_name">Product color</label>
                                        <input type="text" class="form-control" name="product_color" id="product_color" placeholder="Enter Product color"
                                               @if(!empty($productdata['product_color']))
                                               value="{{$productdata['product_color']}}"
                                               @else
                                               value="{{old('product_color')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_name">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Enter Product name"
                                               @if(!empty($productdata['meta_title']))
                                               value="{{$productdata['meta_title']}}"
                                               @else
                                               value="{{old('meta_title')}}"
                                            @endif>
                                    </div>
                                    <!-- /.form-group -->

                                    <div class="form-group">
                                        <label>Select pattern</label>
                                        <select name="pattern" id="pattern" class="form-select select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($patternArray as $pattern)
                                                <option
                                                    @if(!empty($productdata['pattern']) && $productdata['pattern']==$pattern)
                                                    selected=""
                                                    @endif
                                                    value="{{$pattern}}">
                                                    {{$pattern}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Select Sleeve</label>
                                        <select name="sleeve" id="sleeve" class="form-select select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($sleeveArray as $sleeve)
                                                <option
                                                    @if(!empty($productdata['sleeve']) && $productdata['sleeve']==$sleeve)
                                                    selected=""
                                                    @endif
                                                    value="{{$sleeve}}">
                                                    {{$sleeve}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Select Occasion</label>
                                        <select name="occasion" id="occasion" class="form-select select2" style="width: 100%;">
                                            <option value="">Select</option>
                                            @foreach($occasionArray as $occasion)
                                                <option
                                                    @if(!empty($productdata['occasion']) && $productdata['occasion']==$occasion)
                                                    selected=""
                                                    @endif
                                                    value="{{$occasion}}">
                                                    {{$occasion}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="product_name">Meta Description</label>
                                        <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Enter ..."
                                        >@if(!empty($productdata['meta_description']))
                                                {{$productdata['meta_description']}}
                                            @else
                                                {{old('meta_description')}}
                                            @endif</textarea>
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
