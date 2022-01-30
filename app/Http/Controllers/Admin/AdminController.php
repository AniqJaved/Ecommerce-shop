<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Support\Facades\Session;
use Image;


class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page','dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings(){
        Session::put('page','settings');
        $adminDetails=Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings',compact('adminDetails'));
    }

    public function login(Request $request)
    {
        //echo $password = Hash::make('123456'); die;


        if ($request->isMethod('post')){
            $data = $request->all();
            //Validating the login field
            $rules=[
                'email'=>'required|email|max:255',
                'password'=>'required',
            ];
            $customMessages=[
              'email.required'=>'Email is required',
              'email.email'=>'Valid Email is required',
              'password.required'=>'Password is required'
            ];

            $this->validate($request,$rules,$customMessages);
            //End of validation
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect('admin/dashboard');
            }
            else{
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function chkCurrentPassword(Request $request){
        $data = $request->all();
        if (Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            return 'true';
        }
        else{
            return 'false';
        }
    }

    public function upCurrentPassword(Request $request){
        if ($request->isMethod('post')){
            $data=$request->all();
            if (Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
                if ($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message','Your password has been updated');
                }
                else{
                    Session::flash('error_message','Your new password does not match');
                }

            }
            else{
                Session::flash('error_message','Your current password is incorrect');
            }
            return redirect()->back();
        }

    }

    public function updateAdminDetails(Request $request){
        Session::put('page','update-admin-details');
        if ($request->isMethod('post')){
            $data = $request->all();
            //Validating the admin details
            $rules=[
                'admin_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'=>'required|numeric',
            ];
            $customMessages=[
                'admin_name.required'=>'Name is required',
                'admin_name.regex'=>'Valid name is required',
                'admin_mobile.required'=>'Mobile is required',
                'admin_mobile.numeric'=>'Valid mobile is required'
            ];

            $this->validate($request,$rules,$customMessages);
            //End of validation

            //Upload Image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'img/admin_img/admin_photos/' . $imageName;
                    //Upload the Image
                    Image::make($image_tmp)->save($imagePath);

                }
            }
            elseif (!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
            }
            else{
                    $imageName="";
            }


            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],
                'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            Session::flash('success_message','Admin Details updated');
            return redirect()->back();
        }


        $adminDetails=Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_details',compact('adminDetails'));
    }

    public function check(){
        $img = Auth::guard('admin')->user()->image;
        dd($img->response());
    }


}
