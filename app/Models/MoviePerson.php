<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MoviePerson extends Model
{
    protected $fillable = [
        'name'
    ];

    public static function createMoviePerson(Request $request){
    	
    	$actor = new MoviePerson;

    	$actor->name = request('name');
    	$actor->save();

    }

    public static function updateMoviePerson(Request $request, $id){
    	
    	$actor = MoviePerson::findORFail($id);

    	$actor->name = request('name');
    	$actor->save();

    }
}
