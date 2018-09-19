<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Ticket extends Model
{
    protected $fillable = [
        'title', 'description', 'class', 'adultPrice ', 'childPrice', 'isChild', 'type', 'status'
    ];

    public function show_times(){
        return $this->hasMany('App\Models\ShowTime','ticket_id');
    }
    public function bookings(){
        return $this->hasMany('App\Models\Booking');
    }

    public function advance_bookings(){
        return $this->hasMany('App\Models\AdvanceBooking');
    }

    public static function createTicket(Request $request){

    	$ticket = new Ticket;
    	$ticket->title = request('title');
    	$ticket->description = request('description');
    	$ticket->class = request('class');
    	$ticket->adultPrice = request('adultPrice');
		$ticket->childPrice = request('childPrice');
    	$ticket->isChild = request('isChild');
    	$ticket->type = request('type');
    	$ticket->status = request('status');

    	$ticket->save();
    }

    public static function updateTicket(Request $request, $id){

    	$ticket = Ticket::findOrFail($id);
    	$ticket->title = request('title');
    	$ticket->description = request('description');
    	$ticket->class = request('class');
    	$ticket->adultPrice = request('adultPrice');
		$ticket->childPrice = request('childPrice');
    	$ticket->isChild = request('isChild');
    	$ticket->type = request('type');
    	$ticket->status = request('status');

    	$ticket->save();
    }
}
