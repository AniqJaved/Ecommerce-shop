<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Section;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;



class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
//        $products=Product::with('category','section')->get();
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
//        $products = json_decode(json_encode($products));
//        echo '<pre>';print_r($products);die;
        return view('admin.products.products',compact('products'));

    }

    public function updateProductStatus($id){
        $data = Product::findOrFail($id);

        // 1 is for Active and 0 for Inactive
        if($data['status']==1){
            $status = 0;
        }
        else{
            $status =1;
        }


        Product::where('id',$data['id'])->update(['status'=>$status]);
        return redirect()->back();

    }


    public function addEditProduct(Request $request,$id=null){
        if ($id==""){
            $title="Add Product";
            $all = $request->all();
            $all = json_decode(json_encode($all));
            $productdata = array();
            $message = 'Product added successfully';
            //echo '<pre>'; print_r($all);die;
            $product = new Product;

        }
        else{
            $title="Edit Product";
            $productdata = Product::findOrFail($id);
//            $productdata = json_decode(json_encode($productdata));
//            echo '<pre>'; print_r($productdata);die;
            $message = 'Product updated successfully';
            $product = Product::findOrFail($id);

        }

        if ($request->isMethod('post')) {
            $data = $request->all();
//            $data = json_decode(json_encode($data));
//            echo '<pre>'; print_r($data);die;
            //Validating the category details
            $rules=[
                'category_id'=>'required',
                'brand_id'=>'required',
                'product_code'=>'required|regex:/^[\w-]*$/',
                'product_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'product_price'=>'required|numeric',
                'product_color'=>'required|regex:/^[\pL\s\-]+$/u'
            ];
            $customMessages=[
                'category_id.required'=>'Category is required',
                'brand_id.required'=>'Brand is required',
                'Product_code.regex'=>'Valid code is required',
                'Product_code.required'=>'Product code is required',
                'Product_name.regex'=>'Valid product name is required',
                'Product_name.required'=>'Product name is required',
                'Product_price.regex'=>'Valid product price is required',
                'Product_price.required'=>'Product price is required',
                'Product_color.regex'=>'Valid product color is required',
                'Product_color.required'=>'Product color is required',
            ];

            $this->validate($request,$rules,$customMessages);
            if (empty($data['is_featured'])){
                $is_featured="No";
            }
            else{
                $is_featured="Yes";
            }


            //Upload Product image
            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    $image_name=$image_tmp->getClientOriginalName();
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = $image_name.'-'.rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'img/product_img/large_img/' . $imageName;
                    $mediumImagePath = 'img/product_img/medium_img/' . $imageName;
                    $smallImagePath = 'img/product_img/small_img/' . $imageName;
                    //Upload the Category Image
                    Image::make($image_tmp)->save($largeImagePath);
                    Image::make($image_tmp)->resize(520,600)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(260,300)->save($smallImagePath);
                    //Saving image in product table
                    $product->main_image = $imageName;

                }
            }

            //Upload Product Video
            if ($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()){
                    //Upload Video
                    $video_name=$video_tmp->getClientOriginalName();
                    //Get Video Extension
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'-'.rand().'.'.$extension;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    //Saving video in product table
                    $product->product_video = $videoName;
                }
            }

            //Save Product details in product table
            $categoryDetails = Category::findOrFail($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->brand_id=$data['brand_id'];
            $product->category_id=$data['category_id'];
            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->product_price=$data['product_price'];
            $product->product_discount=$data['product_discount'];
            $product->product_weight=$data['product_weight'];
            $product->description=$data['description'];
            $product->wash_care=$data['wash_care'];
            $product->fabric=$data['fabric'];
            $product->pattern=$data['pattern'];
            $product->sleeve=$data['sleeve'];
            $product->fit=$data['fit'];
            $product->occasion=$data['occasion'];
            $product->meta_title=$data['meta_title'];
            $product->meta_description=$data['meta_description'];
            $product->meta_keywords=$data['meta_keywords'];
            $product->is_featured=$is_featured;
            $product->status=1;
            $product->save();
            Session::flash('success_message',$message);
            return redirect('/admin/products');
        }




        //Filter Arrays
        $fabricArray = array('Cotton','Polyester','Wool');
        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $patternArray = array('Checked','Plain','Printed','Self','Solid');
        $fitArray = array('Regular','Slim');
        $occasionArray = array('Casual','formal');

        //Sections with categories and sub-categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
//        echo '<pre>'; print_r($categories);die;
//        echo '<pre>'; dd(view('admin/products/add-edit-product',compact('title','fabricArray','sleeveArray',
//            'patternArray','fitArray','occasionArray','categories')));

        //For Brands
        $brands = Brand::where(['status'=>1])->get();
        $brands = json_decode(json_encode($brands),true);
//        echo '<pre>'; print_r($brands); die;


        return view('admin/products/add-edit-product',compact('title','fabricArray','sleeveArray',
            'patternArray','fitArray','occasionArray','categories','productdata','brands'));
    }
    public function deleteProductImage($id){
        $product = Product::select('main_image')->where('id',$id)->first();

        $product_small_image_path = 'img/product_img/small_img/';
        $product_medium_image_path = 'img/product_img/medium_img/';
        $product_large_image_path = 'img/product_img/large_img/';
//        $p = $product_image_path.$product->main_image;
//        $p = json_decode(json_encode($p),true);
//               echo "<pre>"; print_r($p); die;
        if (file_exists($product_small_image_path.$product->main_image)){
            unlink($product_small_image_path.$product->main_image);
        }

        if (file_exists($product_medium_image_path.$product->main_image)){
            unlink($product_medium_image_path.$product->main_image);
        }

        if (file_exists($product_large_image_path.$product->main_image)){
            unlink($product_large_image_path.$product->main_image);
        }

        Product::findOrFail($id)->update(['main_image'=>'']);
        return redirect()->back()->with('success_message','Product image has been deleted successfully');

        //        $category = json_decode(json_encode($category),true);
        //        echo "<pre>"; print_r($category); die;

    }

    public function deleteProductVideo($id){
        $product = Product::select('product_video')->where('id',$id)->first();

        $product_video_path = 'videos/product_videos/';
//        $p = $product_video_path.$product->product_video;
//        $p = json_decode(json_encode($p),true);
//               echo "<pre>"; print_r($p); die;
        if (file_exists($product_video_path.$product->product_video)){
            unlink($product_video_path.$product->product_video);
        }

        Product::where('id',$id)->update(['product_video'=>'']);
        return redirect()->back()->with('success_message','Product video has been deleted successfully');

        //        $category = json_decode(json_encode($category),true);
        //        echo "<pre>"; print_r($category); die;

    }

    public function deleteProduct($id){
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success_message','Product has been deleted successfully');

    }

    // --------!!!!!!!!Attributes Section!!!!!!!!--------------



    public function addAttributes(Request $request,$id){

        if ($request->isMethod('post')){
            $data = $request->all();
//            echo '<pre>'; print_r($data); die;
            foreach($data['sku'] as $key => $value){
                if (!empty($value)){

                    //SKU already exist check
                    $attrCountSKU = ProductsAttribute::where('sku',$value)->count();
                    if ($attrCountSKU>0){
                        $message = 'SKU already exists.Please add another SKU';
                        Session::flash('error_message',$message);
                        return redirect()->back();
                    }

                    //Size already exist check
                    $attrCountSize = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if ($attrCountSize>0){
                        $message = 'Size already exist.Please add another size';
                        Session::flash('error_message',$message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();

                }
            }
            $success_message = 'Products attribute added successfully';
            Session::flash('success_message',$success_message);
            return redirect()->back();
        }

        $productdata = Product::select('id','product_name','product_color','product_code','main_image')->with('attributes')->findOrFail($id);
        $productdata = json_decode(json_encode($productdata),true);
//        echo '<pre>'; print_r($productdata); die;
        $title = 'Add Attributes';
//        echo '<pre>'; print_r($productAttributes); die;
        return view('admin.products.add-attributes',compact('productdata','title'));

    }

    public function editAttributes(Request $request,$id){
        $data = $request->all();
//        echo '<pre>'; print_r(); die;
        foreach ($data['attrId'] as $key =>$attr){
            if (!empty($attr)){
            ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],
                    'stock'=>$data['stock'][$key]]);
            }
        }

        $success_message = 'Products attribute updated successfully';
        Session::flash('success_message',$success_message);
        return redirect()->back();

    }

    public function updateAttributeStatus($id){
        $data = ProductsAttribute::findOrFail($id);

        // 1 is for Active and 0 for Inactive
        if($data['status']==1){
            $status = 0;
        }
        else{
            $status =1;
        }


        ProductsAttribute::where('id',$data['id'])->update(['status'=>$status]);
        return redirect()->back();

    }

    public function deleteAttribute($id){
        ProductsAttribute::findOrFail($id)->delete();
        return redirect()->back()->with('success_message','Attribute has been deleted successfully');

    }



    // --------!!!!!!!!Images Section!!!!!!!!--------------

    public function addImages(Request $request,$id){

        if ($request->isMethod('post')){
//            $data = $request->all();
//            $data = json_decode(json_encode($data));
//            echo '<pre>'; print_r($data); die;
            if ($request->hasFile('images')) {
                $images= $request->file('images');
                foreach ($images as $key => $image){
                    //Creating a new object in the ProductsImage
                    $productImage = new ProductsImage;

//                    $image_tmp = Image::make($image);

//                    $image_name=$image_tmp->getClientOriginalName();
                    //Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111, 99999) . time() . '.' . $extension;
                    $largeImagePath = 'img/product_img/large_img/' . $imageName;
                    $mediumImagePath = 'img/product_img/medium_img/' . $imageName;
                    $smallImagePath = 'img/product_img/small_img/' . $imageName;
                    //Upload the Category Image
                    Image::make($image)->save($largeImagePath);
                    Image::make($image)->resize(520,600)->save($mediumImagePath);
                    Image::make($image)->resize(260,300)->save($smallImagePath);
                    //Saving image in product table
                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
                }
                return redirect()->back();
            }
//            $data = json_decode(json_encode($data));
//            echo '<pre>'; print_r($data); die;
        }

        $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->findOrFail($id);
        $productdata = json_decode(json_encode($productdata),true);
        $title = 'Added Product Images';
//        echo '<pre>'; print_r($productImages); die;
        return view('admin.products.add-images',compact('productdata','title'));
    }

    public function deleteImage($id){
        $product = ProductsImage::select('image')->where('id',$id)->first();

        $product_small_image_path = 'img/product_img/small_img/';
        $product_medium_image_path = 'img/product_img/medium_img/';
        $product_large_image_path = 'img/product_img/large_img/';
//        $p = $product_image_path.$product->main_image;
//        $p = json_decode(json_encode($p),true);
//               echo "<pre>"; print_r($p); die;
        if (file_exists($product_small_image_path.$product->image)){
            unlink($product_small_image_path.$product->image);
        }

        if (file_exists($product_medium_image_path.$product->image)){
            unlink($product_medium_image_path.$product->image);
        }

        if (file_exists($product_large_image_path.$product->image)){
            unlink($product_large_image_path.$product->image);
        }

        ProductsImage::findOrFail($id)->update(['image'=>'']);
        return redirect()->back()->with('success_message','Product image has been deleted successfully');

        //        $category = json_decode(json_encode($category),true);
        //        echo "<pre>"; print_r($category); die;

    }

    public function updateImageStatus($id){
        $data = ProductsImage::findOrFail($id);

        // 1 is for Active and 0 for Inactive
        if($data['status']==1){
            $status = 0;
        }
        else{
            $status =1;
        }


        ProductsImage::where('id',$data['id'])->update(['status'=>$status]);
        return redirect()->back();

    }

}
