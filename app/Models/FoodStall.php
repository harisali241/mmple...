<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FoodStall extends Model
{
   	protected $fillable = [
        'name', 'size', 'contractType', 'contractAmount ', 'date', 'description', 'status'
    ];

    public static function createFoodStall(Request $request){
    	
    	$foodStall = new FoodStall;

    	$foodStall->name = request('name');
    	$foodStall->size = request('size');
    	$foodStall->contractType = request('contractType');
    	$foodStall->contractAmount = request('contractAmount');
    	$foodStall->date = request('date');
    	$foodStall->description = request('description');
    	$foodStall->status = request('status');
    	$foodStall->save();

    }

    public static function updateFoodStall(Request $request, $id){
    	
    	$foodStall = FoodStall::findORFail($id);

    	$foodStall->name = request('name');
    	$foodStall->size = request('size');
    	$foodStall->contractType = request('contractType');
    	$foodStall->contractAmount = request('contractAmount');
    	$foodStall->date = request('date');
    	$foodStall->description = request('description');
    	$foodStall->status = request('status');
    	$foodStall->save();

    }
}
