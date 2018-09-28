<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Voucher;
use App\Models\Ticket;
use Carbon\Carbon;

class ShowTime extends Model
{
    protected $fillable = [
        'movie_id', 'screen_id', 'ticket_id', 'voucher_id', 'timing_id', 'date', 'time', 'day', 'dateTime', 'complimentrySeat', 'key', 'color', 'sale', 'status'
    ];

    public function printed_tickets(){
        return $this->hasMany('App\Models\PrintedTicket');
    }

    public function movies(){
    	return $this->belongsTo('App\Models\Movie','movie_id');
    }

    public function screens(){
    	return $this->belongsTo('App\Models\Screen','screen_id');
    }

    public function vouchers(){
    	return $this->belongsTo('App\Models\Voucher','voucher_id');
    }

    public function tickets(){
    	return $this->belongsTo('App\Models\Ticket','ticket_id');
    }

    public function timings(){
    	return $this->belongsTo('App\Models\Timing','timing_id');
    }

    public function seats(){
    	return $this->hasMany('App\Models\Seat');
    }

    public function bookings(){
    	return $this->hasMany('App\Models\Booking');
    }

    public function advance_bookings(){
    	return $this->hasMany('App\Models\AdvanceBooking');
    }

    public static function fetchPublicShowTime(){
    	$showTime = ShowTime::where('key', 'public')->with('movies', 'screens', 'vouchers', 'tickets', 'timings')->orderBy('id', 'desc')->get();
    	return $showTime;
    }

    public static function fetchPublicShowTimePaginated(){
    	$showTime = ShowTime::where('key', 'public')->with('movies', 'screens', 'vouchers', 'tickets', 'timings')->orderBy('id', 'desc')->get();
    	return $showTime;
    }

    public static function fetchPrivateShowTime(){
    	$showTime = ShowTime::where('key', 'private')->with('movies', 'screens', 'vouchers', 'tickets', 'timings')->orderBy('id', 'desc')->get();
    	return $showTime;
    }

    public static function fetchSingleShowTime($id){
    	$showTime = ShowTime::where('id', $id)->with('movies', 'screens', 'vouchers', 'tickets', 'timings')->orderBy('id', 'desc')->get()->first();
    	return $showTime;
    }


    public static function createShowTime(Request $request){
    	$duration = Movie::where('id', $request->movie_id)->pluck('duration')->first();
	 	foreach ($request->show_day as $value) {
			foreach ($value['time'] as $time) {
				$dateTime = $value['day'].' '.$time;

				$dt = Carbon::createFromFormat('Y-m-d H:i:s' ,date('Y-m-d H:i:s',strtotime($dateTime) ));
				$endDateTime = $dt->addMinutes($duration);
				//dd($endDateTime);
		    	$getStartDateTime = ShowTime::where('screen_id', $request->screen_id)->whereBetween('dateTime', array($dateTime, $endDateTime))->pluck('id')->first();

		    	$getEndDateTime = ShowTime::where('screen_id', $request->screen_id)->whereBetween('endDateTime', array($dateTime, $endDateTime))->pluck('id')->first();
		    	//dd($getStartDateTime.' '.$getEndDateTime);
		    	if($getStartDateTime != null || $getEndDateTime != null){
		    		return 'DateTime May Conflict';
		    	}
		    }
		}

    	foreach ($request->show_day as $value) {
			foreach ($value['time'] as $time) {
				$dateTime = $value['day'].' '.$time;
				$date = $value['day'];
				$day =  date('l', strtotime($value['day']));

				$duration = Movie::where('id', $request->movie_id)->pluck('duration')->first();	
				$dt = Carbon::createFromFormat('Y-m-d H:i:s' ,date('Y-m-d H:i:s',strtotime($dateTime) ));
				$endDateTime = $dt->addMinutes($duration);

				$showTime = new ShowTime;
		    	$showTime->movie_id = $request->movie_id;
		    	$showTime->screen_id = $request->screen_id;
		    	$showTime->ticket_id = $request->ticket_id;
		    	$showTime->voucher_id = $request->voucher_id;
		    	$showTime->timing_id = 1;
		    	$showTime->complimentrySeat = $request->complimentrySeat;
		    	if($request->voucher_id != null)
		    	{
		    		$showTime->key = 'private';
		    	}else{
		    		$showTime->key = 'public';
		    	}
		    	$showTime->dateTime = $dateTime;
		    	$showTime->endDateTime = $endDateTime;
		    	$showTime->date = $date;
		    	$showTime->day = $day;
		    	$showTime->time = $time;
		    	$showTime->color = $request->color;
		    	$showTime->status = $request->status;
		    	$showTime->save();
			}
		}
    }

    public static function updateShowTime(Request $request, ShowTime $showTime){

    	$duration = ShowTime::where('id', $showTime->id)->with('movies')->get()->first();	 
		$dt = Carbon::createFromFormat('Y-m-d H:i:s' ,date('Y-m-d H:i:s',strtotime($request->dateTime) ));
		$endDateTime = $dt->addMinutes($duration->movies->duration);

    	$getStartDateTime = ShowTime::whereNotIn('id', [$showTime->id])->where('screen_id', $request->screen_id)->whereBetween('dateTime', array($request->dateTime, $endDateTime))->pluck('id')->first();

    	$getEndDateTime = ShowTime::whereNotIn('id', [$showTime->id])->where('screen_id', $request->screen_id)->whereBetween('endDateTime', array($request->dateTime, $endDateTime))->pluck('id')->first();

    	
    	if($getStartDateTime == null && $getEndDateTime == null){
    		//dd($getStartDateTime.'  '.$getEndDateTime);
    		$timestamp = strtotime($request->dateTime);
			$date =  date('Y-m-d', $timestamp);
			$day =   date('l', $timestamp);
			$time = date("H:i", $timestamp);

			$showTime = ShowTime::findOrFail($showTime->id);
	    	$showTime->movie_id = $request->movie_id;
	    	$showTime->screen_id = $request->screen_id;
	    	$showTime->ticket_id = $request->ticket_id;
	    	$showTime->voucher_id = $request->voucher_id;
	    	$showTime->complimentrySeat = $request->complimentrySeat;
	    	$showTime->dateTime = $request->dateTime;
	    	$showTime->date = $date;
	    	$showTime->day = $day;
	    	$showTime->time = $time;
	    	$showTime->color = $request->color;
	    	$showTime->status = $request->status;
	    	$showTime->save();
    	}else{
    		return 'DateTime May Conflict';
    	}
		
    }


}
