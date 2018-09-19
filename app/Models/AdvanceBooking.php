<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Seat;

class AdvanceBooking extends Model
{
    protected $fillable = [
        'show_time_id', 'movie_id', 'distributer_id', 'seatNumber', 'seatQty', 'price', 'date', 'key', 'status', 'customerName', 'customerPhone', 'customerEmail', 'adultPrice', 'adultQty', 'childQty', 'childPrice', 'comp', 'user_id'
    ];

    public function movies(){
    	return $this->belongsTo('App\Models\Movie','movie_id');
    }

    public function tickets(){
    	return $this->belongsTo('App\Models\Ticket','ticket_id');
    }

    public function distributers(){
    	return $this->belongsTo('App\Models\Distributer','distributer_id');
    }

    public function show_times(){
    	return $this->belongsTo('App\Models\ShowTime','show_time_id');
    }

    public function seats(){
    	return $this->hasMany('App\Models\Seat');
    }

    public static function createAdvBooking(Request $request){

        $whichIs = [];
        $seatVice = json_decode($request->seatNumbers);
        for($z=0; $z<count($seatVice); $z++){
            $seatD = Seat::where('isAdv', 'advance')
                        ->where('user_id', Auth::user()->id)
                        ->where('show_time_id', $request->showTime_id)
                        ->where('hold', 1)
                        ->where('seatNumber', $seatVice[$z])
                        ->get()->first();
            if($seatD->isComp == 1){
                array_push($whichIs, 0);
            }elseif($seatD->ticketType == 'adult price'){
                array_push($whichIs, 1);
            }else{
                array_push($whichIs, 2);
            }
        }

        $adv = new AdvanceBooking;
        $adv->show_time_id = $request->showTime_id;
        $adv->user_id = Auth::user()->id;
        $adv->movie_id = $request->movie_id;
        $adv->distributer_id = $request->dist_id;
        $adv->customerName = $request->name;
        $adv->customerEmail = $request->email;
        $adv->customerPhone = $request->phoneNo;
        $adv->adultPrice = $request->adultPrice;
        $adv->adultQty = $request->adultQty;
        $adv->childPrice = $request->childPrice;
        $adv->childQty = $request->childQty;
        $adv->comQty = $request->comp;
        $adv->whichIs = json_encode($whichIs);
        $adv->seatNumber = $request->seatNumbers;
        $adv->seatQty = $request->seatQty;
        $adv->totalAmount = $request->amount;
        $adv->date = date('Y-m-d');
        $adv->key = 'advance';
        $adv->status = 0;
        $adv->save();

        $c_id = AdvanceBooking::where('status', 0)->where('show_time_id', $request->showTime_id)->where('user_id', Auth::user()->id)->where('seatNumber', $request->seatNumbers)->pluck('id')->first();

        for($i=0; $i<count(json_decode($request->seatNumbers)); $i++){
            $id = Seat::where('user_id', Auth::user()->id)
                    ->where('show_time_id', $request->showTime_id)
                    ->where('seatNumber', json_decode($request->seatNumbers)[$i])
                    ->where('hold', 1)
                    ->where('isAdv', 'advance')
                    ->pluck('id')->first();

            $seat = Seat::findOrFail($id);
            $seat->advance_booking_id = $c_id;
            $seat->hold = 0;
            $seat->status = 1;
            $seat->save();
        }
    }

    public static function createBooking($id){

        $adv = AdvanceBooking::where('id', $id)->with('show_times.movies')->get()->first();
        $advSeat = json_decode($adv->seatNumber);
        $whichIs = json_decode($adv->whichIs);

        for($i=0; $i<count($advSeat); $i++){
            if($whichIs[$i] == 2){
                $type = 'child price';
                $price = $adv->childPrice;
            }else{
                $type = 'adult price';
                $price = $adv->adultPrice;
            }
            if($whichIs[$i] == 0){$isComp = 1;}else{$isComp = 0;}


            $booking = new Booking;
            $booking->show_time_id = $adv->show_time_id;
            $booking->user_id = Auth::user()->id;
            $booking->ticket_id = $adv->show_times->ticket_id;
            $booking->movie_id = $adv->show_times->movie_id;
            $booking->distributer_id = $adv->show_times->movies->distributer_id;
            $booking->screen_id = $adv->show_times->screen_id;
            $booking->ticketType = $type;
            $booking->isComplimentary = $isComp;
            $booking->seatNumber = $advSeat[$i];
            $booking->seatQty = 1;
            $booking->price = $price;
            $booking->date = date('Y-m-d');
            $booking->showDate = $adv->show_times->date;
            $booking->showTime = $adv->show_times->date.' '.$adv->show_times->time;
            $booking->key =  'advance';
            $booking->hold = 1;
            $booking->reserveBooking = 1;
            $booking->status = 0;
            $booking->save();

        }
        
    } 

    public static function cancelBooking($id){
        $adv = AdvanceBooking::findOrFail($id);
        $adv->cancel = 1;
        $adv->save();

        $seat_id = Seat::where('advance_booking_id', $id)->pluck('id');

        for($z=0; $z<count($seat_id); $z++){
            Seat::findOrFail($seat_id[$z])->delete();
        }
    }

}
