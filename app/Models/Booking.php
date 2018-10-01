<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\ShowTime;
use App\Models\AdvanceBooking;
use App\Models\ConcessionMaster;
use Auth;

class Booking extends Model
{
    protected $fillable = [
        'show_time_id', 'user_id', 'ticket_id', 'movie_id', 'distributer_id', 'voucher_id', 'deal_id', 'screen_id', 'ticketType', 'isComplimentary', 'seatNumber', 'seatQty', 'price', 'date', 'showDate', 'showTime', 'key', 'hold', 'status', 'cancelUserId', 'cancelUserId'
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

    public function distributers(){
        return $this->belongsTo('App\Models\Distributer','distributer_id');
    }

    public function tickets(){
    	return $this->belongsTo('App\Models\Ticket','ticket_id');
    }

    public function deals(){
    	return $this->belongsTo('App\Models\Deal','deal_id');
    }

    public function show_times(){
    	return $this->belongsTo('App\Models\ShowTime','show_time_id');
    }
    
    public function printed_tickets(){
        return $this->hasMany('App\Models\PrintedTicket');
    }

    public function concession_masters(){
        return $this->belongsTo('App\Models\ConcessionMaster', 'voucher_id');
    }

    protected static function deleteHoldBooking($showTime_id){
        $id = Booking::where('show_time_id', $showTime_id)
                        ->where('user_id', Auth::user()->id)
                        ->where('hold', 1)
                        ->pluck('id');

        for($x=0; $x<count($id); $x++){
            $id_c = Booking::where('id', $id[$x])->pluck('voucher_id')->first();
            Booking::findOrFail($id[$x])->delete();
            if($id_c != null){ 
                ConcessionMaster::deleteCon($id_c); 
            }
        }
    }

    protected static function getHoldSeats($showTime_id){
        $seats = Seat::where('show_time_id', $showTime_id)
                        ->where('user_id', Auth::user()->id)
                        ->where('hold', 1)
                        ->get();
        return $seats;
    }

    protected static function getShowTimeDetails($showTime_id){
        $show = ShowTime::where('id', $showTime_id)
                        ->with('movies.distributers', 'tickets')
                        ->get()->first();
        return $show;
    }

    protected static function getPrice($seat, $showTimes){
        if($seat->isComp == 1){
            $ticket_price = 0;
        }else{
            if($seat->ticketType == 'adult price'){ 
                 $ticket_price = $showTimes->tickets->adultPrice;
            }else{ 
                 $ticket_price = $showTimes->tickets->childPrice;
            }
        }
        return $ticket_price;
    }
    

    public static function holdBooking(Request $request){     
        if($request->deal_id != 0){
            $deal = Deal::where('id', $request->deal_id)->where('status', 1)->get()->first();
            $deal_type = json_decode($deal->type);
            $deal_type_name = json_decode($deal->typeName);
            $deal_qty = json_decode($deal->qty);
            $deal_ticket_qty = 0;
            $deal_item_qty = 0;
            $deal_packge_qty = 0;
            for($d=0; $d<count($deal_type); $d++){
                if($deal_type[$d] == 'ticket'){
                    $deal_ticket_qty += $deal_qty[$d];
                }
            }
            $ticketQty = $deal_ticket_qty;
        }

        $seats = Booking::getHoldSeats($request->showTime_id);
        Booking::deleteHoldBooking($request->showTime_id);
        $showTimes = Booking::getShowTimeDetails($request->showTime_id);
             

        $countDown = count($seats);
        if($request->deal_id != 0){
            $afterThis = $deal->buyTicket;
        }else{
             $afterThis = 1;
        }
        foreach ($seats as $seat){

            if($request->deal_id != 0){
                if($afterThis == 1){
                    if(in_array('item', $deal_type) || in_array('package', $deal_type)){
                        $voucherID = ConcessionMaster::createFreeItem($deal);
                        $deal_id = $deal->id;
                    }
                }
            }
            
            if($request->deal_id != 0){
                $afterThis--;
                //Checking Buy Ticket Qty Then Apply Deals
                if($afterThis<0){
                    if(in_array('ticket', $deal_type)){
                        $isComp = 1;
                        $deal_id = $deal->id;
                        $ticket_price = 0;
                        $voucherID = null;
                    }

                    // Handle The Duration Of Deal Tickets
                    if($deal_ticket_qty == 0){
                        $afterThis = $deal->buyTicket;
                        $deal_ticket_qty = $ticketQty;
                        $afterThis--;
                    }else{
                        $deal_ticket_qty--;
                    }
                }
            }

            if($afterThis>0){
                $isComp = $seat->isComp;
                $deal_id = null;
                $voucherID = null;
                $ticket_price = Booking::getPrice($seat, $showTimes);
            }

            
            $booking = new Booking;

            $booking->show_time_id = $request->showTime_id;
            $booking->user_id = Auth::user()->id;
            $booking->ticket_id = $showTimes->ticket_id;
            $booking->movie_id = $showTimes->movie_id;
            $booking->distributer_id = $showTimes->movies->distributer_id;
            $booking->screen_id = $showTimes->screen_id;         
            $booking->ticketType = $seat->ticketType;
            $booking->seatNumber = $seat->seatNumber;
            $booking->seatQty = 1;
            $booking->deal_id = $deal_id;
            $booking->price = $ticket_price;
            $booking->voucher_id = $voucherID;
            $booking->date = date('Y-m-d');
            $booking->isComplimentary = $isComp;
            $booking->showDate = $showTimes->date;
            $booking->showTime = $showTimes->date.' '.$showTimes->time;
            $booking->key =  $showTimes->key;
            $booking->hold = 1;
            $booking->status = 0;
            
            $booking->save();
        
    
            $countDown--;
        } 
    }

    

    public static function book(Request $request){

        $booking = Booking::where('user_id', Auth::user()->id)
                     ->where('hold' ,1)
                     ->where('status', 0)
                     ->get();
        $booking_id= [];

        if($booking[0]->key == 'advance'){
            
            $bookedSeatNum = [];
            for($z=0; $z<count($booking); $z++){

                $book = Booking::findOrFail($booking[$z]->id);
                $book->hold = 0;
                $book->status = 1;
                $book->save();
                array_push($booking_id, $booking[$z]->id);
                array_push($bookedSeatNum, $booking[$z]->seatNumber);
            }

            $adv = AdvanceBooking::where('id', $request->adv_id)->get()->first();

            $ad = AdvanceBooking::findOrFail($adv->id);
            $ad->bookedSeatNumber = json_encode($bookedSeatNum);
            $ad->bookedSeatQty = count($bookedSeatNum);
            $ad->status = 1;
            $ad->save();

            $seatIdToRemove = [];
            for($s=0; $s<count(json_decode($adv->seatNumber)); $s++){
                if(!in_array(json_decode($adv->seatNumber)[$s], $bookedSeatNum)){
                    $s_id = Seat::where('show_time_id', $adv->show_time_id)->where('isAdv', 'advance')->where('seatNumber', json_decode($adv->seatNumber)[$s])->pluck('id')->first();
                    array_push($seatIdToRemove, $s_id);
                }
            }
            for($si=0; $si<count($seatIdToRemove); $si++){
                Seat::findOrFail($seatIdToRemove[$si])->delete();
            }
        }else{

            $seat_id = Seat::where('user_id', Auth::user()->id)
                     ->where('isAdv', null)
                     ->where('hold' ,1)
                     ->where('status', 0)
                     ->pluck('id');

            for($i=0; $i<count($seat_id); $i++){
                $seat = Seat::findOrFail($seat_id[$i]);
                $seat->hold = 0;
                $seat->status = 1;

                $seat->save();
            }
            for($x=0; $x<count($booking); $x++){
                $book = Booking::findOrFail($booking[$x]->id);
                $book->hold = 0;
                $book->status = 1;
                $book->save();

                array_push($booking_id, $booking[$x]->id);
            }

        }

        return $booking_id;

    }
}
