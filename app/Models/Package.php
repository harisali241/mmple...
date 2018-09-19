<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Package;
use Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\ConcessionDetail;

class Package extends Model
{
    protected $fillable = [
        'name', 'description', 'measuringUnit', 'foodCategory_id ', 'defaultPrice', 'costPrice', 'image', 'displayOrder', 'bgColor', 'itemPrice', 'itemName', 'itemQty', 'status'
    ];

    public function food_categories(){
    	return $this->belongsTo('App\Models\FoodCategories','foodCategory_id');
    }

    public function concession_details(){
        return $this->hasMany('App\Models\ConcessionDetails');
    }

    public static function fetchPackages(){
    	$pack = Package::where('display', 1)->with('food_categories')->get();
    	return $pack;
    }

    public static function fetchSinglePackage($id){
    	$pack = Package::Where('id', $id)->with('food_categories')->get()->first();
    	return $pack;
    }

    public static function createPackage(Request $request){
    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        $file = $request->file('image');
        $filename = mt_rand(100,5000).$file->getClientOriginalName();
        $image = Image::make($file)->resize(300, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $image->save($upload_dir.'m_'.$filename);
        $file->move($upload_dir, $filename);

    	$package = new Package;

    	$package->name = request('name');
    	$package->description = request('description');
    	$package->measuringUnit = request('measuringUnit');
    	$package->foodCategory_id = request('foodCategory_id');
    	$package->defaultPrice = request('defaultPrice');
    	$package->costPrice = request('costPrice');
    	$package->image = $filename;
    	$package->displayOrder = request('displayOrder');
    	$package->bgColor = request('bgColor');
    	$package->itemName = json_encode( request('itemName') );
    	$package->itemPrice = json_encode( request('itemPrice') );
    	$package->itemQty = json_encode( request('itemQty') );
    	$package->status = request('status');

    	$package->save();
    }


    public static function checkThenUpdatePackage(Request $request, Package $package){

        $conD = ConcessionDetail::where('package_id', $package->id)->get();
        $itemN = json_encode( request('itemName') );
        $itemQ = json_encode( request('itemQty') );

        if(count($conD)>0){
            if($package->itemName != $itemN || $package->itemQty != $itemQ){
                $packag = Package::findOrFail($package->id);
                $packag->display = 0;
                $packag->save();
                Package::createPackage($request);
            }else{
                Package::updatePackage($request, $package);
            }

        }else{
            Package::updatePackage($request, $package);
        }
    }

    public static function updatePackage(Request $request, Package $package){

    	$upload_dir = base_path() . '/public/assets/images/uploads/'; 
        if($request->hasFile('image')){
        	File::delete($upload_dir .'/'. $package->image);
        	File::delete($upload_dir .'/m_'. $package->image);
	        $file = $request->file('image');
	        $filename = mt_rand(100,5000).$file->getClientOriginalName();
	        $image = Image::make($file)->resize(300, null, function ($c) {
	            $c->aspectRatio();
	            $c->upsize();
	        });
        	$image->save($upload_dir.'m_'.$filename);
	        $file->move($upload_dir, $filename);
   		}else{
   			$filename = $package->image;
   		}
    	$package = Package::findOrFail($package->id);
    	$package->name = request('name');
    	$package->description = request('description');
    	$package->measuringUnit = request('measuringUnit');
    	$package->foodCategory_id = request('foodCategory_id');
    	$package->defaultPrice = request('defaultPrice');
    	$package->costPrice = request('costPrice');
    	$package->image = $filename;
    	$package->displayOrder = request('displayOrder');
    	$package->bgColor = request('bgColor');
    	$package->itemName = json_encode( request('itemName') );
    	$package->itemPrice = json_encode( request('itemPrice') );
    	$package->itemQty = json_encode( request('itemQty') );
    	$package->status = request('status');
    	$package->save();      
    }

    public static function deletePackage(Package $package){
        $upload_dir = base_path() . '/public/assets/images/uploads/';
        
        $pack = ConcessionDetail::where('package_id', $package->id)->get();
        if(count($pack)>0){
            return $msg=0;
        }else{
            File::delete($upload_dir .'/'. $package->image);
            File::delete($upload_dir .'/m_'. $package->image);
            package::findOrFail($package->id)->delete();
            return $msg=1;
        }

    }
}
