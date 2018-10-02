<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Timing extends Model
{
    protected $fillable = [
        'trailerDuration', 'intervalDuration', 'cleanUpDuration', 'dayStartTime', 'dayEndTime'
    ];

    public function show_times(){
        return $this->hasMany('App\Models\ShowTime','timing_id');
    }

    public static function updateTiming(Request $request, $id){
    	$timing = Timing::findORFail($id);

    	$timing->trailerDuration = request('trailerDuration');
    	$timing->intervalDuration = request('intervalDuration');
    	$timing->cleanUpDuration = request('cleanUpDuration');
        $timing->dayStartTime = request('dayStartTime');
        $timing->dayEndTime = request('dayEndTime');
    	$timing->save();
    }
}
