<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShowTime;
use App\Models\Movie;
use App\Models\Item;
use App\Models\Home;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $showTimes = ShowTime::where('status', 1)->get();
        $movies = Movie::with([ 'bookings','show_times' => function($que){
                $que->where('dateTime', '>=', date('Y-m-d H:i') )->orderBy('dateTime', 'asc')->get();
        }, 'show_times.screens'])->get();
        $conM = Item::with('concession_details')->get();
        $items = [];
        foreach ($conM as $con) {
            array_push($items, ['name' => $con->name, 
                                'qty' => Home::itemQty($con->id, $con->name), 
                                'price' => Home::itemQty($con->id, $con->name)*$con->defaultPrice]);
        }

        $topSellers = array_msort($items, array('price'=>SORT_DESC));
        
        return view('home', compact('showTimes', 'movies', 'topSellers'));
    }
}
