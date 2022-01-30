<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;
class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get();
        $banners = json_decode(json_encode($banners),true);
        //echo '<pre>'; print_r($banners); die;
        return view('admin.banners.banners',compact('banners'));
    }

    public function updateBannerStatus($id){
        $data = Banner::findOrFail($id);

        // 1 is for Active and 0 for Inactive
        if($data['status']==1){
            $status = 0;
        }
        else{
            $status =1;
        }


        Banner::where('id',$data['id'])->update(['status'=>$status]);
        return redirect()->back();

    }

    public function deleteBanner($id){
        $banner = Banner::findOrFail($id);

        //If Banner image exist then delete it
        $banner_image_path = 'img/banner_img/';

        if (file_exists($banner_image_path.$banner->image)){
            unlink($banner_image_path.$banner->image);
        }

        //Deleting banner from the database table
        $banner->delete();


        return redirect()->back()->with('success_message','Banner has been deleted successfully');

    }

    public function addEditBanner(Request $request, $id=null){
        if ($id==""){
            $title="Add Banner";
            $all = $request->all();
            $all = json_decode(json_encode($all));
            $bannerdata = array();
            $message = 'Banner added successfully';
//            echo '<pre>'; print_r($all);die;
            $banner = new Banner;

        }
        else{
            $title="Edit Banner";
            $bannerdata = Banner::findOrFail($id)->toArray();
            //$bannerdata = json_decode(json_encode($bannerdata));
//            $bannerdataobj = (object) $bannerdata;
            echo '<pre>'; print_r($bannerdata);die;
            $message = 'Banner updated successfully';
            $banner = Banner::findOrFail($id);

        }

        if ($request->isMethod('post')) {
            $data = $request->all();
//            $data = json_decode(json_encode($data));
//            echo '<pre>'; print_r($data);die;
            //Validating the category details
            $rules=[

                'banner_title'=>'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customMessages=[
                'banner_title.regex'=>'Valid banner title is required',
                'banner_title.required'=>'Banner title is required',
            ];

            $this->validate($request,$rules,$customMessages);


            if (empty($data['banner_link'])){
                $banner->link = '';
            }
            else{
                $banner->link = $data['banner_link'];
            }

            //Upload Product image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $image_name=$image_tmp->getClientOriginalName();
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = $image_name.'-'.rand(111, 99999) . '.' . $extension;
                    $bannerImagePath = 'img/banner_img/' . $imageName;
                    //Upload the Category Image
                    Image::make($image_tmp)->resize(1170,480)->save($bannerImagePath);
                    //Saving image in product table
                    $banner->image = $imageName;

                }
            }


            //Save Product details in product table
            $banner->title = $data['banner_title'];
            //$banner->link = $data['banner_link'];
            $banner->alt = $data['banner_alt'];
            $banner->status = 1;

            $banner->save();
            Session::flash('success_message',$message);
            return redirect('/admin/banners');
        }

        return view('admin.banners.add_edit_banner',compact('title','banner','message','bannerdata'));
    }
}
