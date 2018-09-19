<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Movie;

class Distributer extends Model
{
    protected $fillable = [
        'name', 'description', 'establishedYear'
    ];

    public function movies(){
        return $this->hasMany('App\Models\Movie');
    }
    public function bookings(){
        return $this->hasMany('App\Models\Booking');
    }

    public function advance_bookings(){
        return $this->hasMany('App\Models\AdvanceBooking');
    }

    public static function createDistributer(Request $request){
    	
    	$dist = new Distributer;

    	$dist->name = request('name');
    	$dist->establishedYear = request('establishedYear');
    	$dist->description = request('description');
    	$dist->save();

    }

    public static function updateDistributer(Request $request, $id){
    	
    	$dist = Distributer::findORFail($id);

    	$dist->name = request('name');
    	$dist->establishedYear = request('establishedYear');
    	$dist->description = request('description');
    	$dist->save();

    }

}
