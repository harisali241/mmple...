<?php

namespace App\Http\Controllers;

use App\Models\ShowTime;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Voucher;
use App\Models\Ticket;
use App\Models\Seat;
use App\Models\Batch;

class ShowTimeController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission')->except('store' , 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $showTimes =  ShowTime::fetchPublicShowTime();
        $showTimesPag = ShowTime::fetchPublicShowTimePaginated();
        $movies = Movie::all();
        $tickets = Ticket::all();
        $vouchers = Voucher::all();
        $screens = Screen::all(); 
        return view('pages.admin.showTime.viewShowTimes', compact('showTimes', 'movies', 'tickets', 'vouchers', 'screens', 'showTimesPag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $showTimes = ShowTime::fetchPublicShowTime();
        $movies = Movie::all();
        $tickets = Ticket::all();
        $vouchers = Voucher::all();
        $screens = Screen::all(); 
        return view('pages.admin.showTime.addShowTime', compact('showTimes','movies', 'tickets', 'vouchers', 'screens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if($request->voucher_id != null){
            $request->validate([
                'voucher_id' => "required",
            ]);
        }else{
            $request->validate([
                'ticket_id' => "required",
            ]);
        }
        $request->validate([
            'movie_id' => "required",
            'screen_id' => "required",
            'complimentrySeat' => "required",
            'key' => "required",
            'status' => "required"
        ]);

        $error = ShowTime::createShowTime($request);
        if($request->voucher_id != null){
            if($error == null){
                return redirect('privateShowTime/create')->withMessage('Add Show Time Sucessfully');
            }else{
                return redirect('privateShowTime/create')->withErrors($error);
            }
        }else{
            if($error == null){
                return redirect('showTime/create')->withMessage('Add Show Time Sucessfully');
            }else{
                return redirect('showTime/create')->withErrors($error);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShowTime  $showTime
     * @return \Illuminate\Http\Response
     */
    public function show(ShowTime $showTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShowTime  $showTime
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $showTime = ShowTime::fetchSingleShowTime($id);
        $showTimes = ShowTime::fetchPublicShowTime();
        $movies = Movie::pluck('title', 'id');
        $tickets = Ticket::pluck('title', 'id');
        $screens = Screen::pluck('name', 'id');
        return view('pages.admin.showTime.editShowTime', compact('showTimes','showTime','movies','tickets','screens'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShowTime  $showTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShowTime $showTime)
    {   
        if($request->voucher_id != null){
            $request->validate([
                'voucher_id' => "required",
            ]);
        }else{
            $request->validate([
                'ticket_id' => "required",
            ]);
        }
        $request->validate([
            'movie_id' => "required",
            'screen_id' => "required",
            'complimentrySeat' => "required",
            'dateTime' => "required",
            'status' => "required",
        ]);

        $error = ShowTime::updateShowTime($request, $showTime);

        if($request->voucher_id != null){
            if($error == null){
                return redirect('privateShowTime')->withMessage('Update Show Time Sucessfully');
            }else{
                return redirect('privateShowTime/'.$showTime->id.'/edit')->withErrors($error);
            }
        }else{
            if($error == null){
                return redirect('showTime')->withMessage('Update Show Time Sucessfully');
            }else{
                return redirect('showTime/'.$showTime->id.'/edit')->withErrors($error);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShowTime  $showTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShowTime $showTime)
    {   
        $s_id = Seat::where('show_time_id', $showTime->id)->get();

        if(count($s_id) <= 0){
            ShowTime::findOrFail($showTime->id)->delete();
            Batch::createBatch($showTime->id, 'web_show_times', 'delete');
            Batch::runBatch();
            return redirect('showTime')->withMessage('Delete Show Time Sucessfully');
        }else{
            return redirect('showTime')->withErrors('Sorry Showtime has tickets booked!');
        }
        
    }
}
