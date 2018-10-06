<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\ShowTime;
use App\Models\Deal;
use App\Models\SlideShow;

class BookTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission')->except('customerScreen');;
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
        }elseif(in_array('voucherConcession', getRoutePath())){
            return redirect('voucherConcession');
        }else{
            return redirect()->back()->withErrors('Access Denied');
        }
    }

    public function booking(){
    	$movies = Movie::where('status', 1)->with('distributers')->get();
    	$ms = ShowTime::where('status', 2)->with('movies')->get();
        $movieStatus = [];
        for($i=0; $i<count($ms); $i++){
            if(!in_array($ms[$i]->movies->title, $movieStatus)){
                array_push($movieStatus, $ms[$i]->movies->title);
            }
        }
        $deal = Deal::where('status', 1)->get()->first();
    	return view('pages.terminal.tickets.booking', compact('movies','movieStatus', 'deal'));
    }

    public function cancelLockedSeat(){
        return view('pages.terminal.tickets.cancelLockedSeat');
    }

    public function customerScreen(){
        $sliderImg = SlideShow::all();
        return view('pages.terminal.tickets.userScreen', compact('sliderImg'));
    }
    
}
