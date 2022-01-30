<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class CategoryController extends Controller
{
    public function category(){
        Session::put('page','categories');
        $categories = Category::with('section','parentcategory')->get();
        $categories = json_decode(json_encode($categories));
//        echo "<pre>"; print_r($categories); die;
        return view('admin.categories.categories',compact('categories'));
    }

    public function updateCategoryStatus($id){
        $data = Category::findOrFail($id);

        // 1 is for Active and 0 for Inactive
        if($data['status']==1){
            $status = 0;
        }
        else{
            $status =1;
        }


        Category::where('id',$data['id'])->update(['status'=>$status]);
        return redirect()->back();

    }

    public function addEditCategory(Request $request, $id = null){
        if ($id == null){
            $title="Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "Category added successfully";
            //Add category functionality
        }
        else
        {
            $title="Edit Category";
            $categorydata = Category::where('id',$id)->first();               //categorydata is giving us value about the the particular category
            $categorydata = json_decode(json_encode($categorydata),true);
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            $message = "Category updated successfully";
            $category = Category::findOrFail($id);
//            echo "<pre>"; print_r($categorydata['parent_id']); die;
//            return view('admin.categories.add_edit_category',compact('categorydata','title'));
            //Edit category functionality
        }

        if($request->isMethod('post')){
            $data = $request->all();


            //Validating the category details
            $rules=[
                'category_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'section_id'=>'required',
                'url'=>'required',
                'category_image'=>'image'
            ];
            $customMessages=[
                'category_name.required'=>'Name is required',
                'category_name.regex'=>'Valid name is required',
                'section_id.required'=>'Section is required',
                'url.required'=>'Url is required',
                'category_image.image'=>'Valid image is required'
            ];

            $this->validate($request,$rules,$customMessages);
            //End of validation


            //Upload Category Image
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'img/category_img/' . $imageName;
                    //Upload the Category Image
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;

                }
            }

            //If we do not enter anything in the fields

            if (empty($data['category_discount'])){
                $data['category_discount']=0;
            }
            if (empty($data['description'])){
                $data['description']="";
            }
            if (empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if (empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }
            if (empty($data['meta_description'])){
                $data['meta_description']="";
            }




            $category->parent_id = $data['parent_id'];
            $category->section_id=$data['section_id'];
            $category->category_name=$data['category_name'];
            $category->category_discount=$data['category_discount'];
            $category->description=$data['description'];
            $category->url=$data['url'];
            $category->meta_title=$data['meta_title'];
            $category->meta_keywords=$data['meta_keywords'];
            $category->meta_description=$data['meta_description'];
            $category->status=1;
            $category->save();
            Session::flash('success_message',$message);
            return redirect('admin/categories');
        }
        $getSection = Section::get();

        return view('admin.categories.add_edit_category',compact('title','getSection','categorydata','getCategories'));
    }


    public function appendCategoryLevel(Request $request){
        if ($request->ajax()){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,
                'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            //echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categories_level',compact('getCategories'));

        }
    }

    public function deleteCategoryImage($id){
        $category = Category::select('category_image')->where('id',$id)->first();
        $category_image_path = 'img/category_img/';
        if (file_exists($category_image_path.$category->category_image)){
            unlink($category_image_path.$category->category_image);
        }

        Category::findOrFail($id)->update(['category_image'=>'']);
        return redirect()->back()->with('success_message','Category image has been deleted successfully');

        //        $category = json_decode(json_encode($category),true);
        //        echo "<pre>"; print_r($category); die;

    }

    public function deleteCategory($id){
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success_message','Category has been deleted successfully');

    }
}
