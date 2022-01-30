<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function listings($url , Request $request){
        if ($request->ajax()){
            $data = $request->all();
            $url = $data['url'];
//            echo '<pre>'; print_r($data); die;
            $category = Category::where(['url'=>$url,'status'=>1])->count();
//        echo '<pre>'; print_r($category); die;
            if ($category>0){
                $categorydetails = Category::catdetails($url);
//            echo '<pre>'; print_r($categorydetails); die;
                $productsDetails = Product::with('brand')->whereIn('category_id',$categorydetails['catIds'])
                    ->where(['status'=>1]);

//            echo '<pre>'; print_r($_GET['sort']); die;

                // If sort option is selected by user
                if (isset($data['sort']) && !empty($data['sort'])){
                    if ($data['sort']=="product_latest"){
                        $productsDetails->orderBy('id','Desc');
                    }
                    else if ($data['sort']=="product_name_a_z"){
                        $productsDetails->orderBy('product_name','Asc');
                    }
                    else if ($data['sort']=="product_name_z_a"){
                        $productsDetails->orderBy('product_name','Desc');
                        dd($productsDetails);
                    }
                    else if ($data['sort']=="price_lowest"){
                        $productsDetails->orderBy('product_price','Asc');
                    }
                    else if ($data['sort']=="price_highest"){
                        $productsDetails->orderBy('product_price','Desc');
                    }
                }
                else{
                    $productsDetails->orderBy('id','Desc');
                }

                $productsDetails = $productsDetails->paginate(30);

//            $productsDetails = json_decode(json_encode($productsDetails),true);
//            echo '<pre>'; print_r($categorydetails);
//            echo '<pre>'; print_r($productsDetails); die;

                return view('front.products.ajax_listings',compact('categorydetails','productsDetails','url'));
            }
            else{
                return 'No';
            }
        }
        else{
            $category = Category::where(['url'=>$url,'status'=>1])->count();
//        echo '<pre>'; print_r($category); die;
            if ($category>0){
                $categorydetails = Category::catdetails($url);
//            echo '<pre>'; print_r($categorydetails); die;
                $productsDetails = Product::with('brand')->whereIn('category_id',$categorydetails['catIds'])
                    ->where(['status'=>1]);

                $productsDetails = $productsDetails->paginate(30);


//            $productsDetails = json_decode(json_encode($productsDetails),true);
//            echo '<pre>'; print_r($categorydetails);
//            echo '<pre>'; print_r($productsDetails); die;

                return view('front.products.listings',compact('categorydetails','productsDetails','url'));
            }
            else{
                return 'No';
            }
        }


    }
}
