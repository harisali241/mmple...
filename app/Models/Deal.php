<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Booking;
use App\Models\ConcessionMaster;
use Illuminate\Http\Request;
use Auth;

class Deal extends Model
{
    protected $fillable = [
        'name', 'user_id', 'item_id', 'dealType', 'ticketBuy', 'ticketGet', 'concessionBuy', 'concessionGet', 'duration', 'day', 'startDate', 'endDate', 'status'
    ];

    public function users(){
    	return $this->belongsTo('App\User','user_id');
    }    

    public function movies(){
        return $this->belongsTo('App\Models\Movie', 'movie_id');
    }

    public static function createDeal(Request $request){

        $startDateTime = date('Y-m-d', strtotime($request->startDate)).' '.date('h:i', strtotime($request->startTime));
        $endDateTime = date('Y-m-d', strtotime($request->endDate)).' '.date('h:i', strtotime($request->endTime));
        if($request->dayStartTime!=null){
            $dayStartTime = date('H:i', strtotime($request->dayStartTime));
        }else{
            $dayStartTime = null;
        }

        if($request->dayEndTime!=null){
            $dayEndTime = date('H:i', strtotime($request->dayEndTime));
        }else{
            $dayEndTime = null;
        }
        

    	$deal = new Deal;
        $deal->name = $request->name;
        $deal->user_id = Auth::user()->id;
        $deal->movie_id = $request->moive_id;
        $deal->show_time_id = $request->showTime_id;
        $deal->startDateTime = $startDateTime;
        $deal->endDateTime = $endDateTime;
        $deal->dayStartTime = $dayStartTime;
        $deal->dayEndTime = $dayEndTime;
        $deal->buyTicket = $request->buyTicket;
        $deal->days = json_encode($request->days);
        $deal->type = json_encode($request->type);
        $deal->typeName = json_encode($request->typeName);
        $deal->qty = json_encode($request->qty);
        $deal->status = $request->status;
        $deal->save();
        
    }

    public static function updateDeal(Request $request, $deal){
        //dd($request);
        $startDateTime = date('Y-m-d', strtotime($request->startDate)).' '.date('h:i', strtotime($request->startTime));
        $endDateTime = date('Y-m-d', strtotime($request->endDate)).' '.date('h:i', strtotime($request->endTime));
       if($request->dayStartTime!=null){
            $dayStartTime = date('H:i', strtotime($request->dayStartTime));
        }else{
            $dayStartTime = null;
        }

        if($request->dayEndTime!=null){
            $dayEndTime = date('H:i', strtotime($request->dayEndTime));
        }else{
            $dayEndTime = null;
        }

        $b_id = Booking::where('deal_id', $deal->id)->pluck('id')->first();
        $c_id = ConcessionMaster::where('deal_id', $deal->id)->pluck('id')->first();
        if($b_id == null && $c_id == null){

            $dl = Deal::findOrFail($deal->id);
            $dl->name = $request->name;
            $dl->user_id = Auth::user()->id;
            $dl->movie_id = $request->moive_id;
            $dl->show_time_id = $request->showTime_id;
            $dl->startDateTime = $startDateTime;
            $dl->endDateTime = $endDateTime;
            $dl->dayStartTime = $dayStartTime;
            $dl->dayEndTime = $dayEndTime;
            $dl->buyTicket = $request->buyTicket;
            $dl->days = json_encode($request->days);
            $dl->type = json_encode($request->type);
            $dl->typeName = json_encode($request->typeName);
            $dl->qty = json_encode($request->qty);
            $dl->status = $request->status;
            $dl->save();

        }else{
            
            $dl = Deal::findOrFail($deal->id);
            $dl->status = 0;
            $dl->display = 0;
            $dl->save();

            $deal = new Deal;
            $deal->name = $request->name;
            $deal->user_id = Auth::user()->id;
            $deal->movie_id = $request->moive_id;
            $deal->show_time_id = $request->showTime_id;
            $deal->startDateTime = $startDateTime;
            $deal->endDateTime = $endDateTime;
            $deal->dayStartTime = $dayStartTime;
            $deal->dayEndTime = $dayEndTime;
            $deal->buyTicket = $request->buyTicket;
            $deal->days = json_encode($request->days);
            $deal->type = json_encode($request->type);
            $deal->typeName = json_encode($request->typeName);
            $deal->qty = json_encode($request->qty);
            $deal->status = $request->status;
            $deal->save();

        }
    }

    public static function deleteDeal($deal){

        $b_id = Booking::where('deal_id', $deal->id)->pluck('id')->first();
        $c_id = ConcessionMaster::where('deal_id', $deal->id)->pluck('id')->first();
        if($b_id == null && $c_id == null){
            Deal::findOrFail($deal->id)->delete();
        }else{
            $dl = Deal::findOrFail($deal->id);
            $dl->status = 0;
            $dl->display = 0;
            $dl->save();
        }
        
    }
 
}
