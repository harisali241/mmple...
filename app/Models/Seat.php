<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'show_time_id', 'advance_booking_id','user_id', 'isAdv', 'ticketType', 'isComp', 'seatNumber', 'hold', 'status'
    ];

    public function advance_bookings(){
    	return $this->belongsTo('App\Models\AdvanceBooking', 'advance_booking_id');
    }

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function show_times(){
    	return $this->belongsTo('App\Models\ShowTime', 'show_time_id');
    }

    public function printed_tickets(){
        return $this->hasMany('App\Models\PrintedTicket');
    }
}
