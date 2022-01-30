<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach($productsDetails as $product)
            <li class="span3">
                <div class="thumbnail">
                    <a href="product_details.html">
                        <?php $product_image_path = "img/product_img/small_img/".$product['main_image']; ?>
                        @if(!empty($product['main_image']) && file_exists($product_image_path))
                            <img src="{{asset('img/product_img/small_img/'.$product['main_image'])}}" style="width: 100px;">
                        @else
                            <img src="{{asset('img/product_img/small_img/no_image.png')}}" style="width: 100px;">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{$product['product_name']}}</h5>
                        <p>
                            {{$product['brand']['name']}}
                        </p>
                        <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{$product['product_price']}}</a></h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>
