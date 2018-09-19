<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Distributer;
use Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class logo extends Model
{
    protected $fillable = [
        'logo'
    ];

    public static function updateLogo(Request $request, Logo $logo){
    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        if($request->hasFile('logo')){
        	File::delete($upload_dir .'/'. $logo->logo);
            File::delete($upload_dir .'/m_'. $logo->logo);
	        $file = $request->file('logo');
	        $filename = mt_rand(100,5000).$file->getClientOriginalName();
            $image = Image::make($file)->resize(300, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $image->save($upload_dir.'m_'.$filename);
	        $file->move($upload_dir, $filename);
   		}else{
   			$filename = $logo->logo;
   		}

    	$logo = Logo::findOrFail($logo->id);
    	$logo->logo = $filename;

    	$logo->save();
    }
}
