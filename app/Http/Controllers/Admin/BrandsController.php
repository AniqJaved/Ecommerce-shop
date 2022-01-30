<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandsController extends Controller
{
    public function brands(){
        Session::put('page','brands');

        $brands = Brand::all();
//        echo '<pre>'; print_r($brands); die;
        return view('admin.brands.brands',compact('brands'));
    }

    public function updatebrandStatus($id){
        $data = Brand::findOrFail($id);

        // 1 is for Active and 0 for Inactive
        if($data['status']==1){
            $status = 0;
        }
        else{
            $status =1;
        }


        Brand::where('id',$data['id'])->update(['status'=>$status]);
        return redirect()->back();

    }

    public function addEditBrand(Request $request,$id=null){
        if ($id == null){
            $title="Add Category";
            $branddata = new Brand;
//            $branddata = json_decode(json_encode($branddata),true);
//            echo '<pre>'; print_r($branddata); die;
            $message = "Brand added successfully";
            //Add category functionality
        }
        else
        {
            $title="Edit Category";
            $branddata = Brand::where('id',$id)->first();               //branddata is giving us value about the the particular category
//            $branddata = json_decode(json_encode($branddata),true);
            $message = "Brand updated successfully";
            //Edit category functionality
        }

        if ($request->isMethod('post')){
            $data = $request->all();
            $rules=[
                'brand_name'=>'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customMessages=[
                'brand_name.regex'=>'Valid brand name is required',
                'brand_name.required'=>'Brand name is required',
            ];

            $this->validate($request,$rules,$customMessages);
            $branddata->name = $data['brand_name'];
            $branddata->status = 1;
            $branddata->save();
            Session::flash('success_message',$message);
            return redirect('admin/brands');
//            echo '<pre>'; print_r($data); die;
        }

        return view('admin.brands.add_edit_brand',compact('branddata','title'));
    }

    public function deleteBrand($id){
        Brand::findOrFail($id)->delete();
        return redirect()->back()->with('success_message','Brand has been deleted successfully');

    }
}
