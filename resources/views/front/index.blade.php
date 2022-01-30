@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
    <div class="well well-small">
        <h4>Featured Products <small class="pull-right">{{$featuredproductscount}} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured"
                 @if($featuredproductscount>4)
                  class="carousel slide"
                 @endif>
                <div class="carousel-inner">
                    @foreach($featureditemchunk as $key => $featureditem)
                        <div class="item
                        @if($key==0)
                            active
                        @endif">
                        <ul class="thumbnails">
                            @foreach($featureditem as $item)
                                <li class="span3">
                                <div class="thumbnail">
                                    <i class="tag"></i>
                                    <?php
                                     $main_image_path = 'img/product_img/small_img/'.$item['main_image'];
                                    ?>
                                    <a href="product_details.html">
                                        @if(!empty($item['main_image']) && file_exists($main_image_path))
                                            <img src="{{asset($main_image_path)}}" alt="">
                                        @else
                                            <img src="{{'img/product_img/small_img/'.'no_image.png'}}" alt="">
                                        @endif
                                    </a>
                                    <div class="caption">
                                        <h5>{{$item['product_name']}}</h5>
                                        <h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.{{$item['product_price']}}</span></h4>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach($latestproducts as $latestproduct)
            <li class="span3">
                <div class="thumbnail">
                    <?php
                    $main_image_path = 'img/product_img/small_img/'.$latestproduct['main_image'];
                    ?>
                    <a href="product_details.html">
                        @if(!empty($latestproduct['main_image']) && file_exists($main_image_path))
                            <img style="width: 200px" src="{{asset($main_image_path)}}" alt="">
                        @else
                            <img style="width: 200px"  src="{{'img/product_img/small_img/'.'no_image.png'}}" alt="">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{$latestproduct['product_name']}}</h5>
                        <p>
                            {{$latestproduct['product_code']}}
                        </p>

                        <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{$latestproduct['product_price']}}</a></h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
