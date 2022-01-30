<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=[
        'category_image'
    ];

    public function subcategories(){
        return $this->hasMany('App\Category','parent_id')->where('status',1);
    }

    public function section(){
        return $this->belongsTo('App\Section','section_id')->select('id','name');
    }

    public function parentcategory(){
        return $this->belongsTo('App\Category','parent_id')->select('id','category_name');
    }

    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }


    //For Listings
    public static function catdetails($url){
        $catdetails = Category::select('id','url','parent_id','category_name','description')->with(['subcategories'=>
            function($query){
            $query->select('id','parent_id','category_name','url','description')->where(['status'=>1]);
            }])->where('url',$url)->first()->toArray();
//        $catdetails = json_decode(json_encode($catdetails),true);
//        echo '<pre>'; print_r($catdetails); die;

        if ($catdetails['parent_id']==0){
            $breadcrumbs = '<a href="'.url($catdetails['url']).'">'.$catdetails['category_name'].'</a>';
//            $breadcrumbs = json_decode(json_encode($breadcrumbs),true);
//            echo '<pre>'; print_r($breadcrumbs); die;
        }
        else{
            $parentCategory = Category::select('category_name','url')->where(['id'=>$catdetails['parent_id']])->first()->toArray();
            $breadcrumbs = '<a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>&nbsp;&nbsp;<a href="'.url($catdetails['url']).'">'.$catdetails['category_name'].'</a>';
//            $parentCategory = json_decode(json_encode($parentCategory),true);
//            echo '<pre>'; print_r($parentCategory); die;
        }

        $catIds = array();
        $catIds[] = $catdetails['id'];

        foreach ($catdetails['subcategories'] as $key => $subcat){
            $catIds[] = $subcat['id'];
        }

        $catIds = json_decode(json_encode($catIds),true);
//        echo '<pre>'; print_r($catIds); die;

        return array('catIds'=>$catIds,'catDetails'=>$catdetails,'breadcrumbs'=>$breadcrumbs);

//        $categorydetails = json_decode(json_encode($categorydetails),true);
//        echo '<pre>'; print_r($categorydetails); die;
    }
}
