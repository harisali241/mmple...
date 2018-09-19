<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Setting extends Model
{
   	protected $fillable = [
        'name', 'value',
    ];

    public static function updateSetting(Request $request){
    	$set = Setting::findOrFail(1);
    	$set->value = request('value');
    	$set->save();
    }
}
