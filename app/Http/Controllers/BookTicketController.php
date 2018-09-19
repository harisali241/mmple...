<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Deal;
class BookTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission');
    }

    public function terminal(){
        if(in_array('booking', getRoutePath())){
            return redirect('booking');
        }elseif(in_array('bookConcession', getRoutePath())){
            return redirect('bookConcession');
        }elseif(in_array('advBooking', getRoutePath())){
            return redirect('advBooking');
        }elseif(in_array('cancelTicket', getRoutePath())){
            return redirect('cancelTicket');
        }elseif(in_array('cancelLockedSeat', getRoutePath())){
            return redirect('cancelLockedSeat');
        }elseif(in_array('viewReserve', getRoutePath())){
            return redirect('viewReserve');
        }elseif(in_array('cancelConcession', getRoutePath())){
            return redirect('cancelConcession');
        }else{
            return redirect()->back()->withErrors('Access Denied');
        }
    }

    public function booking(){
    	$movies = Movie::where('status', 1)->with('distributers')->get();
    	$movieStatus = Movie::where('status', 2)->pluck('id');
        $deal = Deal::where('status', 1)->get()->first();
    	return view('pages.terminal.tickets.booking', compact('movies','movieStatus', 'deal'));
    }

    public function cancelLockedSeat(){
        return view('pages.terminal.tickets.cancelLockedSeat');
    }
    
}
