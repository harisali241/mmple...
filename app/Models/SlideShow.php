<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Distributer;
use Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class SlideShow extends Model
{
    protected $fillable = [
        'image'
    ];

    public static function createSlideShow(Request $request){
    	
    	$upload_dir = base_path() . '/public/assets/images/uploads/';

        $file = $request->file('image');
        $filename = mt_rand(100,5000).$file->getClientOriginalName();
        $image = Image::make($file)->resize(300, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $image->save($upload_dir.'m_'.$filename);
        $file->move($upload_dir, $filename);

    	$SlideShow = new SlideShow;
    	$SlideShow->image = $filename;

    	$SlideShow->save();
    }
}
