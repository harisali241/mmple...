<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FoodCategories;
use Illuminate\Http\Request;
use File;
use App\Models\ConcessionDetail;
use Intervention\Image\ImageManagerStatic as Image;

class Item extends Model
{
    protected $fillable = [
        'name', 'description', 'measuringUnit', 'foodCategory_id ', 'defaultPrice', 'costPrice', 'image', 'displayOrder', 'bgColor', 'status'
    ];

    public function food_categories(){
    	return $this->belongsTo('App\Models\FoodCategories','foodCategory_id');
    }    

    public function concession_details(){
        return $this->hasMany('App\Models\ConcessionDetail');
    }

    public static function fetchItems(){
    	$items = Item::with('food_categories')->get();
    	return $items;
    }

    public static function fetchSingleItems($id){
    	$items = Item::Where('id', $id)->with('food_categories')->get()->first();
    	return $items;
    }

    public static function createItem(Request $request){
    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        $file = $request->file('image');
        $filename = mt_rand(100,5000).$file->getClientOriginalName();
        $image = Image::make($file)->resize(300, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $image->save($upload_dir.'m_'.$filename);
        $file->move($upload_dir, $filename);

    	$item = new Item;

    	$item->name = request('name');
    	$item->description = request('description');
    	$item->measuringUnit = request('measuringUnit');
    	$item->foodCategory_id = request('foodCategory_id');
    	$item->defaultPrice = request('defaultPrice');
    	$item->costPrice = request('costPrice');
    	$item->image = $filename;
    	$item->displayOrder = request('displayOrder');
    	$item->bgColor = request('bgColor');
    	$item->status = request('status');

    	$item->save();
    }

    public static function updateItem(Request $request, Item $item){

    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        if($request->hasFile('image')){
        	File::delete($upload_dir .'/'. $item->image);
        	File::delete($upload_dir .'/m_'. $item->image);
	        $file = $request->file('image');
	        $filename = mt_rand(100,5000).$file->getClientOriginalName();
	        $image = Image::make($file)->resize(300, null, function ($c) {
	            $c->aspectRatio();
	            $c->upsize();
	        });
        	$image->save($upload_dir.'m_'.$filename);
	        $file->move($upload_dir, $filename);
   		}else{
   			$filename = $item->image;
   		}

    	$item = Item::findOrFail($item->id);

    	$item->name = request('name');
    	$item->description = request('description');
    	$item->measuringUnit = request('measuringUnit');
    	$item->foodCategory_id = request('foodCategory_id');
    	$item->defaultPrice = request('defaultPrice');
    	$item->costPrice = request('costPrice');
    	$item->image = $filename;
    	$item->displayOrder = request('displayOrder');
    	$item->bgColor = request('bgColor');
    	$item->status = request('status');

    	$item->save();

    }

    public static function deleteItem(Item $item){
        $upload_dir = base_path() . '/public/assets/images/uploads/';

        $c_id = ConcessionDetail::where('item_id', $item->id)->get();

        $ite = Item::where('id', $item->id)->pluck('name')->first();
        $package = Package::all();

        $find = 'no';
        foreach ($package as $pack) {
            $itemName = json_decode($pack->itemName);
            for ($i=0; $i < count($itemName); $i++) { 
                if($ite == $itemName[$i]){
                    $find = 'yes';
                }
            }
        }

        if($find == 'yes' || count($c_id) > 0){
            return $msg = 0;
        }else{
            File::delete($upload_dir .'/'. $item->image);
            File::delete($upload_dir .'/m_'. $item->image);
            Item::findOrFail($item->id)->delete();
            return $msg = 1;
        }
        
    }

}
