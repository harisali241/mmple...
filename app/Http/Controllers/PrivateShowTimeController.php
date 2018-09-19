<?php

namespace App\Http\Controllers;

use App\Models\PrivateShowTime;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Voucher;
use App\Models\Ticket;
use App\Models\ShowTime;

class PrivateShowTimeController extends Controller
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
        $showTimes =  ShowTime::fetchPrivateShowTime();
        $movies = Movie::all();
        $tickets = Ticket::all();
        $vouchers = Voucher::all();
        $screens = Screen::all(); 
        return view('pages.admin.privateShowTime.viewPShowTimes', compact('showTimes', 'movies', 'tickets', 'vouchers', 'screens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $showTimes = ShowTime::fetchPrivateShowTime();
        $movies = Movie::all();
        $tickets = Ticket::all();
        $vouchers = Voucher::all();
        $screens = Screen::all(); 
        return view('pages.admin.privateShowTime.addPShowTime', compact('showTimes','movies', 'tickets', 'vouchers', 'screens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'movie_id' => "required",
        //     'screen_id' => "required",
        //     'voucher_id' => "required",
        //     'complimentrySeat' => "required",
        //     'key' => "required",
        //     'status' => "required"
        // ]);

        // $error = PrivateShowTime::createShowTime($request);
        // if($error == null){
        //     return redirect('privateShowTime/create')->withMessage('Add Show Time Sucessfully');
        // }else{
        //     return redirect('privateShowTime/create')->withErrors($error);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrivateShowTime  $privateShowTime
     * @return \Illuminate\Http\Response
     */
    public function show(PrivateShowTime $privateShowTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrivateShowTime  $privateShowTime
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $showTime = ShowTime::fetchSingleShowTime($id);
        $showTimes = ShowTime::fetchPrivateShowTime();
        $movies = Movie::pluck('title', 'id');
        $vouchers = Voucher::pluck('title', 'id');
        $screens = Screen::pluck('name', 'id');
        return view('pages.admin.privateShowTime.editPShowTime', compact('showTimes','showTime','movies','vouchers','screens'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrivateShowTime  $privateShowTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShowTime $ShowTime)
    {
        // //dd($request);
        // $request->validate([
        //     'movie_id' => "required",
        //     'screen_id' => "required",
        //     'voucher_id' => "required",
        //     'complimentrySeat' => "required",
        //     'dateTime' => "required",
        //     'status' => "required",
        // ]);

        // $error = ShowTime::updateShowTime($request, $ShowTime);
        // if($error == null){
        //     return redirect('privateShowTime')->withMessage('Update Show Time Sucessfully');
        // }else{
        //     return redirect('privateShowTime/'.$showTime->id.'/edit')->withErrors($error);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrivateShowTime  $privateShowTime
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        ShowTime::findOrFail($id)->delete();
        return redirect('privateShowTime')->withMessage('Delete Show Time Sucessfully');
    }
}
