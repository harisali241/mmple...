<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Package;

class FoodCategories extends Model
{
    protected $fillable = [
        'name'
    ];

    public function items(){
        return $this->hasMany('App\Models\Item');
    }
    public function packages(){
        return $this->hasMany('App\Models\Package');
    }

    public static function createFoodCategories(Request $request){
    	
    	$foodCat = new FoodCategories;

    	$foodCat->name = request('name');
    	$foodCat->save();

    }

    public static function updateFoodCategories(Request $request, $id){
    	
    	$foodCat = FoodCategories::findORFail($id);

    	$foodCat->name = request('name');
    	$foodCat->save();

    }
}
