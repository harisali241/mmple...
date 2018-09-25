<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use File;

class PrintedTicket extends Model
{
   	protected $fillable = [
        'booking_id', 'show_time_id', 'movie_id', 'screen_id', 'seat_id', 'user_id', 'batch_id', 'user_id', 'unique_id', 'showTime', 'price', 'cancel_user_id', 'status'
    ];

    public function movies(){
        return $this->belongsTo('App\Models\Movie','movie_id');
    }

    public function screens(){
        return $this->belongsTo('App\Models\Screen','screen_id');
    }

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function tickets(){
        return $this->belongsTo('App\Models\Ticket','ticket_id');
    }

    public function bookings(){
        return $this->belongsTo('App\Models\Booking','booking_id');
    }

    public function seats(){
        return $this->belongsTo('App\Models\Seat','seat_id');
    }

    public function show_times(){
        return $this->belongsTo('App\Models\ShowTime','show_time_id');
    }


    public static function createTickets($bookings){
    	$batch_id = rand(100, 1000000);
    	foreach($bookings as $book){
    		$tic = new PrintedTicket;

    		$tic->booking_id = $book->id;
    		$tic->show_time_id = $book->show_time_id;
    		$tic->movie_id = $book->movie_id;
    		$tic->screen_id = $book->screen_id;
    		$tic->seatNumber = $book->seatNumber;
    		$tic->user_id = Auth::user()->id;
    		$tic->batch_id = $batch_id;
    		$tic->showTime = $book->showTime;
    		$tic->price = $book->price;
            $tic->key = $book->key;
    		$tic->status = 1;
    		$tic->save();
    	}
    }

}
