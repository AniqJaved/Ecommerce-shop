<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(){
        //For featured products

        $featureditemchunk = Product::where(['is_featured'=>'Yes','status'=>1])->get();
        //Featured products number
        $featuredproductscount = $featureditemchunk->count();
        $featureditemchunk = json_decode(json_encode($featureditemchunk),true);
        $featureditemchunk = array_chunk($featureditemchunk,4);
//        echo '<pre>'; print_r($featureditemchunk); die;

        //For Latest products

        $latestproducts = Product::orderBy('id','Desc')->where(['status'=>1])->limit(3)->get();
        $latestproducts = json_decode(json_encode($latestproducts),true);
//        echo '<pre>'; print_r($latestproducts); die;

        $page_name = 'index';
        return view('front.index',compact('page_name','featureditemchunk','featuredproductscount','latestproducts'));
    }
}
