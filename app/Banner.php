<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public static function getBanner(){
        $getBanner = Banner::where(['status'=>1])->get();
        $getBanner = json_decode(json_encode($getBanner),true);
//        echo '<pre>'; print_r($getBanner); die;
        return $getBanner;
    }
}
