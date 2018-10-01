<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;	
use App\Models\PrintedTicket;
use App\Models\ConcessionDetail;
use App\Models\ConcessionMaster;
use App\Models\Movie;
use App\Models\Screen;
use App\User;
use Auth;

class PrintedTicketController extends Controller
{	
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('userPermission')->except('store' , 'update');
    }

    public function viewAndPrint(Request $request){
    	$print = $request->printIT;
    	if($request->reprint != null){
    		$bookings = Booking::whereIn('seatNumber', json_decode($request->seatNum))
					    	->where('show_time_id', $request->showid)
					    	->where('status', 1)->with('concession_masters')
					    	->get();
		}else{
			
			$bookings = Booking::whereIn('id', json_decode($request->booking_id))
					    	->where('status', 1)->with('concession_masters')
					    	->get();
			PrintedTicket::createTickets($bookings);

		}
        //dd($bookings);
    	return view('pages.terminal.tickets.viewBookTicket', compact('bookings', 'print'));
    }

    public function printRecentTicket(){
        $print = '';
        $batch_code = PrintedTicket::where('user_id', Auth::user()->id)
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->pluck('batch_id')->first();

        $booking_id = PrintedTicket::where('batch_id', $batch_code)->pluck('booking_id');

        $bookings = Booking::whereIn('id', $booking_id)
                            ->where('status', 1)
                            ->get();
        return view('pages.terminal.tickets.viewBookTicket', compact('bookings', 'print'));
    }

    public function cancelTicket(){
        $movies = Movie::all();
        $screens = Screen::all();
        $users = User::all();
        return view('pages.terminal.tickets.cancelTicket', compact('movies', 'screens', 'users'));
    }

    public function viewAndPrint_c(Request $request){
        $print = $request->printIT;
        $conD = ConcessionDetail::where('concession_master_id', $request->con_order_id)->with('items', 'packages')->get();
        $conTotal = ConcessionMaster::where('id', $request->con_order_id)->pluck('totalAmount')->first();
        return view('pages.terminal.concession.printConcession', compact('conD', 'print', 'conTotal'));
    }

    public function reprintConcession($id){
        $print = '';
        $conD = ConcessionDetail::where('concession_master_id', $id)->with('items', 'packages')->get();
        $conTotal = ConcessionMaster::where('id', $id)->pluck('totalAmount')->first();
        return view('pages.terminal.concession.printConcession', compact('conD', 'print', 'conTotal'));
    }
}
