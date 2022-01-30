<?php
use App\Banner;
$getBanners = Banner::getBanner();

?>

@if(isset($page_name) && $page_name == 'index')
    <div id="carouselBlk">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                @foreach($getBanners as $key => $getBanner)
                    <div class="item
                        @if($key==0)
                            active
                        @endif">
                    <div class="container">
                        <a
                            @if(!empty($getBanner['link']))
                                href="{{$getBanner['link']}}"
                            @else
                                href="javascript;"
                            @endif alt="{{$getBanner['alt']}}" title="{{$getBanner['title']}}" ><img style="width:100%" src="{{asset('img/banner_img/'.$getBanner['image'])}}" alt="special offers"/></a>
                        <div class="carousel-caption">
                            <h4>First Thumbnail label</h4>
                            <p>Banner text</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
    </div>
@endif
