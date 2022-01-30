<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SectionsController extends Controller
{
    public function sections(){
        Session::put('page','sections');
        $sections = Section::all();
        return view('admin.sections.sections',compact('sections'));
    }

    public function updateSectionStatus($id){
            $data = Section::findOrFail($id);

            // 1 is for Active and 0 for Inactive
            if($data['status']==1){
                $status = 0;
            }
            else{
                $status =1;
            }


            Section::where('id',$data['id'])->update(['status'=>$status]);
            return redirect()->back();

    }
}
