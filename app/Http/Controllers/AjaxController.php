<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\ShowTime;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Timing;
use App\Models\PrintedTicket;
use App\Models\AdvanceBooking;
use App\Models\ConcessionMaster;
use App\Models\ConcessionDetail;
use App\Models\Deal;
use Auth;
use View;

class AjaxController extends Controller
{

//*******************************Booking Ticket******************************************//

	public function dummyRequest(Request $request){
		dd($request);
		return response()->json('Received');
	}

    public function itemPrice(Request $request){
        $itemPrice = Item::where('name' , $request->itemName)->pluck('defaultPrice')->first();
        return response()->json($itemPrice);
    }


    public function ticketPrice(Request $request){
    	//dd($request);
        $ticketPrice = Ticket::where('title' , $request->ticketPrice)->pluck('adultPrice')->first();
        return response()->json($ticketPrice);
    }

    public function allMovies(){
        $movies = Movie::where('status', 1)->with('distributers')->get();
        return response()->json($movies);
    }

    public function movieStatus(){
        $movieStatus = Movie::where('status', 2)->pluck('id');
        return response()->json($movieStatus);
    }

    public function getScreenSeats(Request $request){
        //dd(date('Y-m-d H:i'));
        $res = ShowTime::where('id',  $request->screen_id)
                        ->where('status', 1)
                        ->with(['bookings' => function($qua){
                                $qua->where('hold', 0)->where('status', 1);
                        },'advance_bookings'=> function($can){
                                $can->where('cancel', 0);
                        }, 'screens', 'movies', 'seats', 'tickets'])
                        ->get()->first();

        $deals = Deal::where('display', 1)->where('status', 1)->get();
        $validDeal = [];
        foreach($deals as $deal) {
            if($deal->movie_id != null){
                if($deal->movie_id == $res->movie_id){
                    if($deal->show_time_id != null){
                        if($deal->show_time_id == $res->id){
                            array_push($validDeal, $deal->id);
                        }
                    }else{
                        array_push($validDeal, $deal->id);
                    }
                }
            }else{     
                if($deal->startDateTime <= date('Y-m-d H:i') && $deal->endDateTime >= date('Y-m-d H:i')){
                    if(json_decode(count($deal->days)) != 0){
                        $day = json_decode($deal->days);
                        
                        $dayStartDate = dayStartDate();
                        $dayEndDate = dayEndDate();

                        if(in_array(date('D',strtotime($dayEndDate)), $day) || in_array(date('D',strtotime($dayStartDate)), $day)){
                            array_push($validDeal, $deal->id);
                            // if($deal->dayStartTime == null || $deal->dayEndTime == null){
                            //     array_push($validDeal, $deal->id);
                            // }else{
                            //     $dayStartTime = date('H:i',strtotime($deal->dayStartTime));
                            //     $dayEndTime = date('H:i',strtotime($deal->dayEndTime));
                            //     $curentTime = date('H:i');
                            //     //dd($dayEndTime);
                            //     if($dayStartTime <= $curentTime && $dayEndTime >= $curentTime){
                            //         dd('here');
                            //         array_push($validDeal, $deal->id);
                            //     }
                            // }
                        }
                    }else{
                        array_push($validDeal, $deal->id);
                    }
                }
            }
        }

        $de = Deal::whereIn('id', $validDeal)->get();
        $arr = [ 0 => $res, 1 => $de];
        return response()->json($arr);
    }

    public function holdBookingAndGetSeats(Request $request){
        Booking::holdBooking($request);
        $bookings = Booking::where('show_time_id', $request->showTime_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('hold' , 1)
                            ->where('status', 0)
                            ->get();
        return response()->json($bookings);
    }


    public function getAllSeat(Request $request){
        $res = Seat::where('show_time_id',  $request->showTime_id)
                    ->where('hold', 1)
                    ->where('user_id', '!=' ,Auth::user()->id)
                    ->where('seatNumber', $request->currentSeatNumber)
                    ->where('status', 0)
                    ->pluck('id')
                    ->first();
        //dd($res);
        if($res != null){   
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function holdSeats(Request $request){
        if($request->ticket_adult == 'yes'){
            $ticket = 'adult price';
        }else{
            $ticket = 'child price';
        }

        $id = Seat::where('show_time_id', $request->showTime_id)
                    ->where('seatNumber', $request->currentSeatNumber)
                    ->where('hold', 1)
                    ->pluck('id')->first();
        if($id == null){
            $seat = new Seat;
            $seat->show_time_id = $request->showTime_id;
            $seat->seatNumber = $request->currentSeatNumber;
            $seat->user_id = Auth::user()->id;
            $seat->isComp = $request->allow_comp;
            $seat->ticketType = $ticket;
            $seat->hold = 1;
            $seat->status = 0;

            $seat->save();
        }
        
        return response()->json(true);
    }

    public function deleteSeat(Request $request){
        $id = Seat::where('show_time_id', $request->showTime_id)->where('seatNumber', $request->currentSeatNumber)->where('hold', 1)->pluck('id')->first();
        
        $booking_id = Booking::where('show_time_id', $request->showTime_id)
                ->where('seatNumber', $request->currentSeatNumber)
                ->where('hold', 1)->pluck('id')->first();
        if($booking_id != null){
            $id_c = Booking::where('id', $booking_id)->pluck('voucher_id')->first();
            Booking::findOrFail($booking_id)->delete();
            if($id_c != null){ ConcessionMaster::deleteCon($id_c); }
        }

        Seat::findOrFail($id)->delete();
        return response()->json(true);
    }

    public function cancelAllSelectedSeats(Request $request){
        $id = Seat::where('user_id', Auth::user()->id)
                ->where('hold', 1)
                ->where('status', 0)
                ->pluck('id');


        $booking_id = Booking::where('user_id', Auth::user()->id)
                ->where('hold',1)
                ->where('status', 0)
                ->pluck('id');

        for($i=0; $i<count($id); $i++){
            Seat::findOrFail($id[$i])->delete();
        }

        if(count($booking_id) > 0){
            for($i=0; $i<count($booking_id); $i++){
                $id_c = Booking::where('id', $booking_id[$i])->pluck('voucher_id')->first();
                Booking::findOrFail($booking_id[$i])->delete();
                if($id_c != null){ ConcessionMaster::deleteCon($id_c); }
            }
        }
        

        return response()->json(true);
    }

    public function ticketDelete(Request $request){
        $id = Seat::where('user_id', Auth::user()->id)
                    ->where('show_time_id', $request->showTime_id)
                    ->where('seatNumber', $request->seatNum)
                    ->where('hold',1)
                    ->where('status', 0)
                    ->pluck('id');
        $booking_id = Booking::where('user_id', Auth::user()->id)
                    ->where('show_time_id', $request->showTime_id)
                    ->where('seatNumber', $request->seatNum)
                    ->where('hold',1)
                    ->where('status', 0)
                    ->pluck('id'); 
        
        for($i=0; $i<count($id); $i++){
            Seat::findOrFail($id[$i])->delete();
        }
        for($i=0; $i<count($booking_id); $i++){
            $id_c = Booking::where('id', $booking_id[$i])->pluck('voucher_id')->first();
            Booking::findOrFail($booking_id[$i])->delete();
            if($id_c != null){ ConcessionMaster::deleteCon($id_c);  }
        }

        return response()->json(true);
    }

    public function bookTickets(Request $request){
        $id = Booking::book($request);
        return response()->json($id);
    }

    public function removeAdvHoldBooking(){
        BackToNormalBooking();
    }

    public function searchCancelSeat(Request $request){
        if($request->columToSearch == 'count_asc'){
            $seats = Seat::where('status', 0)->where('user_id', Auth::user()->id)->where('hold', 1)->with('show_times.screens')->orderBy('id', 'asc')->limit($request->wordToSearch)->get();
        }elseif($request->columToSearch == 'count_desc'){
            $seats = Seat::where('status', 0)->where('user_id', Auth::user()->id)->where('hold', 1)->with('show_times.screens')->orderBy('id', 'desc')->limit($request->wordToSearch)->get();
        }else{
            $seats = Seat::where('status', 0)->where('user_id', Auth::user()->id)->where('hold', 1)->where($request->columToSearch ,'like', '%'.$request->wordToSearch.'%')->with('show_times.screens')->get();
        }

        $view = View::make('pages.terminal.tickets.cancelSeatsRenderView', [
            'seats' => $seats
        ]);
        return $html = $view->render();
    }

    public function deleteLockedSeat(Request $request){
        if(is_array($request->id)){
            for($i=0; $i<count($request->id); $i++){
                Seat::findOrFail($request->id[$i])->delete();
            }
        }else{
             Seat::findOrFail($request->id)->delete();
        } 

        return response()->json($request->id);
    }

//*******************************Booking Ticket******************************************//


//*******************************Cancel Ticket******************************************//
  
    public function searchCancelTicket(Request $request){

        if($request->sqlQuery == null){
            $p_tickets = PrintedTicket::where('status', 1)->where('showTime' ,'>', date('Y-m-d H:i:s'))->where($request->columToSearch ,'like', '%'.$request->wordToSearch.'%')->with('movies', 'screens', 'users')->get();
        }else{
            if($request->c_date == null){
                $p_tickets = PrintedTicket::where('showTime' ,'>', date('Y-m-d H:i:s'))
                                ->whereRaw($request->sqlQuery)
                                ->with('movies', 'screens', 'users')
                                ->get();
            }else{
                $p_tickets = PrintedTicket::where('showTime' ,'>', date('Y-m-d H:i:s'))
                                ->whereRaw($request->sqlQuery)
                                ->whereDate('created_at','=', date('Y-m-d', strtotime($request->c_date)))
                                ->with('movies', 'screens', 'users')
                                ->get();
            }
        }

        $view = View::make('pages.terminal.tickets.cancelRenderView', [
            'tickets' => $p_tickets
        ]);

        return $html = $view->render();
    }
    
    public function deleteTickets(Request $request){
        if(is_array($request->id)){
            $ticket = PrintedTicket::whereIn('id', $request->id)->get();
            $arr = [];
            for($s=0; $s<count($ticket); $s++){
                $seat_id = Seat::where('show_time_id', $ticket[$s]->show_time_id)->where('seatNumber', $ticket[$s]->seatNumber)->pluck('id')->first();
                Seat::findOrFail($seat_id)->delete();

                $tic = PrintedTicket::findOrFail($request->id[$s]);
                $tic->status = 0;
                $tic->cancelUserId = Auth::user()->id;
                $tic->save();

                $book = Booking::findOrFail($ticket[$s]->booking_id);
                $book->status = 0;
                $book->remarks = $request->remarks[$s];
                $book->cancelUserId = Auth::user()->id;
                $book->save();

                if($request->voucherNo[$s] != null){
                    $conM = ConcessionMaster::findOrFail($request->voucherNo[$s]);
                    $conM->status = 0;
                    $conM->remarks = $request->remarks[$s];
                    $conM->cancelUserId = Auth::user()->id;
                    $conM->cancelDate = date('Y-m-d');
                    $conM->save();
                }
                
            }
            return response()->json($request->id);
        }else{
            $ticket = PrintedTicket::where('id', $request->id)->get()->first();
            $seat_id = Seat::where('show_time_id', $ticket->show_time_id)
                        ->where('seatNumber', $ticket->seatNumber)
                        ->pluck('id')->first();
            Seat::findOrFail($seat_id)->delete();

            $tic = PrintedTicket::findOrFail($request->id);
            $tic->status = 0;
            $tic->cancelUserId = Auth::user()->id;
            $tic->save();

            $book = Booking::findOrFail($ticket->booking_id);
            $book->status = 0;
            $book->remarks = $request->remarks;
            $book->cancelUserId = Auth::user()->id;
            $book->save();

            return response()->json($request->id);
        }      
    }

//*******************************Cancel Ticket******************************************//


//*******************************Advance Ticket******************************************//
    

    public function holdAdvSeats(Request $request){
        if($request->ticket_adult == 'yes'){
            $ticket = 'adult price';
        }else{
            $ticket = 'child price';
        }

        $seat = new Seat;

        $seat->show_time_id = $request->showTime_id;
        $seat->seatNumber = $request->currentSeatNumber;
        $seat->isAdv  = 'advance';
        $seat->user_id = Auth::user()->id;
        $seat->isComp = $request->allow_comp;
        $seat->ticketType = $ticket;
        $seat->hold = 1;
        $seat->status = 0;

        $seat->save();
        return response()->json(true);
    }

    public function deleteAdvSeat(Request $request){
        $id = Seat::where('show_time_id', $request->showTime_id)->where('isAdv', 'advance')->where('seatNumber', $request->currentSeatNumber)->where('hold', 1)->pluck('id')->first();

        Seat::findOrFail($id)->delete();
        return response()->json(true);
    }

    public function holdAdvBookingAndGetSeats(Request $request){
        $seats = Seat::where('user_id' , Auth::user()->id)
                        ->where('show_time_id', $request->showTime_id)
                        ->where('isAdv', 'advance')
                        ->where('hold', 1)
                        ->where('status', 0)
                        ->with('show_times.movies', 'show_times.tickets')
                        ->get();
        return response()->json($seats);
    }

    public function bookAdvTickets(Request $request){
        $adv = AdvanceBooking::createAdvBooking($request);
        return response()->json($adv);
    }

//*******************************Advance Ticket******************************************//


//******************************* Concesstion Booking ******************************************//

    public function bookCon(Request $request){
        $id = ConcessionMaster::createCon($request);
        for($i=0; $i<count($request->type); $i++){
            ConcessionDetail::createCon($request, $id, $i);
        }
        return response()->json($id);
    }

    public function cancelCon(Request $request){
        ConcessionMaster::cancelCon($request);
        return response()->json(true);
    }

    public function voucherRecord(Request $request){
        $res = ConcessionMaster::voucherRecord($request);
        return response()->json($res);
    }

    public function printConcession(Request $request){
        $con = ConcessionMaster::findOrFail($request->id);
        $con->status = 0;
        $con->save();
        return response()->json($request->id);
    }

//******************************* Concesstion Booking ******************************************//


//******************************* Deals ******************************************//
    public function getShowTimeByMovie(Request $request){
        $sh = ShowTime::where('movie_id', $request->id)->where('dateTime' ,'>', date('Y-m-d h:i'))->where('status', 1)->get();
        return response()->json($sh);
    }
//******************************* Deals ******************************************//

}
