<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\AdvanceBooking;
use Auth;

class AdvanceBookingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission')->except('store', 'update', 'edit', 'destroy');
    }

    public function advBooking(){
        $movies = Movie::where('status', 1)->with('distributers')->get();
        $movieStatus = Movie::where('status', 2)->pluck('id');
        return view('pages.terminal.advance.advanceBooking', compact('movies','movieStatus'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advs = AdvanceBooking::where('cancel', 0)->with('movies', 'show_times')->get();
        return view('pages.terminal.advance.viewReserve', compact('advs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //dd($request->);
        AdvanceBooking::createBooking($request->adv_id);
        removeUserHoldBooking();
        return redirect('booking')->with('message', $request->adv_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adv = AdvanceBooking::where('id', $id)->with('movies', 'show_times')->get()->first();
        return view('pages.terminal.advance.viewReserveDetail', compact('adv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       AdvanceBooking::cancelBooking($id);
       return redirect()->back()->with('message', 'Successfull canceled the reservation');
    }
}
