<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShowTime;
use App\Models\Movie;
use App\Models\Item;
use App\Models\Home;
use View;

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
        $topSellers = Home::topSellerItem();
        $ticketSales = Home::ticketSales();
        $concessionSales = Home::concessionSales();

        return view('home', compact('showTimes', 'movies', 'topSellers', 'ticketSales', 'concessionSales'));
    }

    public function dashbordMovies(){
        $movies = Movie::with([ 'bookings','show_times' => function($que){
                $que->where('dateTime', '>=', date('Y-m-d H:i') )->orderBy('dateTime', 'asc')->get();
        }, 'show_times.screens'])->get();

        $view = View::make('pages.homeRender.moviesRender', [
            'movies' => $movies
        ]);

        return $html = $view->render();
    }

    public function dashbordTopSellers(){

        $topSellers = Home::topSellerItem();
        $view = View::make('pages.homeRender.topSellerRender', [
            'topSellers' => $topSellers
        ]);

        return $html = $view->render();
    }

    public function dashbordticketSales(){

        $ticketSales = Home::ticketSales();
        $view = View::make('pages.homeRender.ticketSaleRender', [
            'ticketSales' => $ticketSales
        ]);

        return $html = $view->render();
    }

    public function dashbordConSales(){

        $concessionSales = Home::concessionSales();
        $view = View::make('pages.homeRender.concessionSaleRender', [
            'concessionSales' => $concessionSales
        ]);

        return $html = $view->render();
    }

}
