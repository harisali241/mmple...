<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributer;
use App\Models\PrintedTicket;
use App\Models\Movie;
use App\Models\Package;
use App\Models\Item;
use App\Models\Booking;
use App\Models\Screen;
use App\User;
use App\Models\ConcessionDetail;
use App\Models\ConcessionMaster;
use App\Models\ShowTime;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('userPermission')
        ->except('movie', 'concession', 'custom','filmsByDistributorReports','showsByTimeReports','weeklyMovieReports','itemSalesReq', 'singleItemSalesReq', 'singleItemSalesByUserReq','packageSalesReq', 'singlePackageSalesReq', 'packageSalesByUserReq','concessionCancellationByDayReq','concessionSaleByAllUserReq', 'totalSeatBookingByDayReq');
    }

    public function movie(){
    	return view('pages.admin.reports.movie');
    }
    public function concession(){
        return view('pages.admin.reports.concession');
    }
    public function custom(){
        return view('pages.admin.reports.custom');
    }


    public function filmsByDistributor(){
    	$distributers = Distributer::all();
    	return view('pages.admin.reports.movieReports.filmsByDistributor', compact('distributers'));
    }
    public function filmsByDistributorReports(Request $request){
    	$distributers = Movie::where('distributer_id', $request->id)->get();
    	return response()->json($distributers);
    }


    public function showsByTime(){
    	return view('pages.admin.reports.movieReports.showsByTime');
    }
    public function showsByTimeReports(Request $request){
    	$showTime = showTime::whereBetween('dateTime', array($request->startDate, $request->endDate) )->with('movies')->with('screens')->get();
        return response()->json($showTime);
    	//return view('pages.admin.reports.movieReports.showsByTime', compact('showTime'));
    }


    public function weeklyMovieReport(){
        $movies = Movie::all();
        return view('pages.admin.reports.movieReports.weeklyMovieReport', compact('movies'));
    }
    public function weeklyMovieReports(Request $request){
        $pts = PrintedTicket::where('movie_id', $request->id)->orderBy('created_at' , 'asce')->get();
        $weeklyRecord = [];
        $totalAmount = 0;
        $preDay = 0;
        //dd(date('l', strtotime($pts[0]->created_at)));
        if(count($pts)>0){
            for($i=0; $i<count($pts); $i++){
                $dayNum = date('N', strtotime($pts[$i]->created_at));
                $totalAmount += $pts[$i]->price;
                if($dayNum == 5){
                    $totalAmount += $pts[$i]->price;
                    array_push($weeklyRecord, [ $fri => $totalAmount]);
                    $totalAmount = 0;
                }
            }
        }
        
        dd($weeklyRecord);
        return response()->json($showTime);
        //return view('pages.admin.reports.movieReports.showsByTime', compact('showTime'));
    }


    public function itemSales(){
        return view('pages.admin.reports.concessionReports.itemSale');
    }
    public function itemSalesReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionDetail::whereDate('created_at', $date)->where('item_id','!=',null)->where('status', 1)->with('items')->get();
        return response()->json($c_detail);
    }
    

    public function singleItemSales(){
        $items = Item::all();
        return view('pages.admin.reports.concessionReports.singleItemSale', compact('items'));
    }
    public function singleItemSalesReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionDetail::whereDate('created_at', $date)->where('item_id', $request->id)->where('status', 1)->with('items')->get();
        return response()->json($c_detail);
    }


    public function singleItemSalesByUser(){
        $users = User::all();
        return view('pages.admin.reports.concessionReports.singleItemSaleByUser', compact('users'));
    }
    public function singleItemSalesByUserReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionDetail::whereDate('created_at', $date)->where('item_id','!=',null)->where('status', 1)->where('user_id', $request->id)->with('items')->get();
        return response()->json($c_detail);
    }


    public function packageSales(){
        return view('pages.admin.reports.concessionReports.packageSale');
    }
    public function packageSalesReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionDetail::whereDate('created_at', $date)->where('package_id','!=',null)->with('packages')->where('status', 1)->get();
        return response()->json($c_detail);
    }
    

    public function singlePackageSales(){
        $packages = Package::all();
        return view('pages.admin.reports.concessionReports.singlePackageSale', compact('packages'));
    }
    public function singlePackageSalesReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionDetail::whereDate('created_at', $date)->where('package_id', $request->id)->with('packages')->where('status', 1)->get();
        return response()->json($c_detail);
    }


    public function packageSalesByUser(){
        $users = User::all();
        return view('pages.admin.reports.concessionReports.packageSaleByUser', compact('users'));
    }
    public function packageSalesByUserReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionDetail::whereDate('created_at', $date)->where('package_id','!=',null)->where('user_id', $request->id)->where('status', 1)->with('packages')->get();
        return response()->json($c_detail);
    }


    public function concessionCancellationByDay(){
        return view('pages.admin.reports.concessionReports.concessionCancellationByDay');
    }
    public function concessionCancellationByDayReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionMaster::whereDate('cancelDate', $date)->where('status', 0)->with('users')->get();
        return response()->json($c_detail);
    }


    public function concessionSaleByAllUser(){
        return view('pages.admin.reports.concessionReports.concessionSaleByAllUser');
    }
    public function concessionSaleByAllUserReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $c_detail = ConcessionMaster::whereDate('created_at', $date)->where('status', 1)->with('users')->get();
        return response()->json($c_detail);
    }


    public function totalSeatBookingByDay(){
        return view('pages.admin.reports.ticketReports.totalSeatBookingByDay');
    }
    public function totalSeatBookingByDayReq(Request $request){
        //dd($request->date);
        $date = date('Y-m-d', strtotime($request->date));
        $r_detail = Booking::whereDate('created_at', $date)->where('status', 1)->where('hold', 0)->with('screens', 'show_times')->orderBy('screen_id', 'desc')->get();
        $screens = Screen::orderBy('id', 'asce')->get();
        $detail = [];

        for($i=0; $i<count($screens); $i++){
            array_push($detail, $screens);
        }

        return response()->json($screens);
    }
}
