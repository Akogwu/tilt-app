<?php


namespace App\Util;

use Cloudder;

class ImageUploader
{
    public static function upload($request){
        $file_url = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $cloudder = Cloudder::upload($request->file('image')->getRealPath());
            $uploadResult = $cloudder->getResult();
            $file_url = $uploadResult["url"];
        }
        return $file_url;
    }
}
