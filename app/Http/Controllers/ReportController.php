<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributer;
use App\Models\PrintedTicket;
use App\Models\Movie;
use App\Models\Package;
use App\Models\Item;
use App\Models\Booking;
use App\Models\AdvanceBooking;
use App\Models\Screen;
use App\User;
use App\Models\ConcessionDetail;
use App\Models\ConcessionMaster;
use App\Models\ShowTime;
use App\Models\Report;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('userPermission')
        ->except('movie', 'concession', 'custom','filmsByDistributorReports','showsByTimeReports','weeklyMovieReports','itemSalesReq', 'singleItemSalesReq', 'singleItemSalesByUserReq','packageSalesReq', 'singlePackageSalesReq', 'packageSalesByUserReq','concessionCancellationByDayReq','concessionSaleByAllUserReq', 'totalSeatBookingByDayReq','advanceBookingByDayReq', 'ticketSalesByMovieReq', 'advanceTicketSalesByMovieReq', 'cashInHandByDayReq', 'cashInHandByUserReq', 'ticketCancellationByDayReq', 'ticketSalesByUserReq');
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
        $pts = PrintedTicket::where('movie_id', $request->id)->orderBy('created_at' , 'asc')->pluck('created_at');
        $ptsDesc = PrintedTicket::where('movie_id', $request->id)->orderBy('created_at' , 'desc')->pluck('created_at')->first();

        $weeklyRecord = [];
        $created_at = '';
        $fcreated_at = '';
        if(count($pts)>0){
            for ($i=0; $i<1000; $i++) {
                if($created_at == null){
                    $created_at = $pts[0];
                }else{
                    $fcreated_at = last($weeklyRecord)['firstDayOfWeek'];
                    $created_at = last($weeklyRecord)['lastDayOfWeek'];
                }

                if($fcreated_at >= date('Y-m-d', strtotime($ptsDesc)) ){ break; }
                array_push($weeklyRecord, Report::idByWeek($request->id, $created_at));
                if($created_at >= date('Y-m-d', strtotime($ptsDesc)) ){ break; }
            }
        }

        $compPrice = Report::compPrice($request->id);
        $movie = Movie::where('id', $request->id)->pluck('title')->first();
        $detail = ['weeklyRecord'=> $weeklyRecord, 'compPrice'=> $compPrice, 'movie'=> $movie];
        return response()->json($detail);
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
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');
        $screens = Screen::pluck('id');
        $screenArray = [];
        $time = [];
        $perSeat = [];
        $seatQty = [];
        for($i=0; $i<count($screens); $i++){
            $oneScreen = Booking::whereDate('created_at', $date)->where('status', 1)->where('hold', 0)->where('screen_id', $screens[$i])->with('screens', 'show_times')->get();
            if( count($oneScreen) > 0){
                array_push($screenArray, $oneScreen[$i]->screens->name);
            }
        }
        for($x=0; $x<count($screenArray); $x++){
            $id = Screen::where('name', $screenArray[$x])->pluck('id')->first();
            $show_time_id = Booking::whereDate('created_at', $date)->where('status', 1)->where('hold', 0)->where('screen_id', $id)->with('screens', 'show_times')->get();
            $ti = [];
            $per = [];
            $perCount = -1;
            for($i=0; $i<count($show_time_id); $i++){
                if(!in_array(date('h:i a',strtotime($show_time_id[$i]->show_times->time)), $ti)){
                    array_push($ti, date('h:i a',strtotime($show_time_id[$i]->show_times->time)) );
                    $perCount++;
                    $per[$perCount] = 1; 
                }else{
                    $per[$perCount] += 1; 
                }
            }
            $time[$x] = $ti;
            $perSeat[$x] = $per;
            $qty = [];
            array_push($qty, count($show_time_id));
            $seatQty[$x] = $qty;
        }

        $detail = ['screen'=>$screenArray, 'time'=>$time, 'qty'=>$seatQty, 'seatPerShow'=>$perSeat ,'created_at'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function currentSeatBookingByDay(){
        return view('pages.admin.reports.ticketReports.currentSeatBookingByDay');
    }

    
    public function advanceBookingByDay(){
        $screens = Screen::all();
        return view('pages.admin.reports.ticketReports.advanceBookingByDay', compact('screens'));
    }
    public function advanceBookingByDayReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a'); 
        $adv = AdvanceBooking::whereDate('created_at', $date)->where('cancel', 0)->with('show_times')->get();
        $show = [];
        $qty = [];
        $show_id = [];
        $screen_id = [];
        for($i=0; $i<count($adv); $i++){
            $c_date = date('M-d-Y D h:i a', strtotime($adv[$i]->show_times->dateTime));
            if(!in_array($c_date, $show)){
                array_push($show, $c_date);
                array_push($qty, $adv[$i]->seatQty);
                array_push($screen_id, $adv[$i]->show_times->screen_id);
                array_push($show_id, $adv[$i]->show_times->id);
            }
        }

        $screens = Screen::all();
        $detail = ['screens'=>$screens, 'show'=>$show, 'qty'=>$qty, 'id'=>$screen_id, 'created_at'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function ticketSalesByMovie(){
        $movies = Movie::all();
        return view('pages.admin.reports.ticketReports.ticketSalesByMovie', compact('movies'));
    }
    public function ticketSalesByMovieReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');
        $show = PrintedTicket::where('key', 'public')
                                ->where('movie_id', $request->id)
                                ->where('status', 1)
                                ->whereDate('created_at', $date)
                                ->with('show_times', 'screens','movies', 'bookings')
                                ->orderBy('show_time_id', 'asc')
                                ->get();

        $movie = Movie::where('id', $request->id)->pluck('title');
        $time = [];
        $qty = []; 
        $screens = [];
        $price = [];
        $deal = [];
        $isComp = [];
        for($i=0; $i<count($show); $i++){
            $c_date = date('M-d-Y D h:i a', strtotime($show[$i]->show_times->dateTime));
            if(!in_array($c_date, $time)){
                array_push($time, $c_date);
                array_push($screens, $show[$i]->screens->name);
                $index = count($qty);
                array_push($qty, 1);
                if($show[$i]->bookings->deal_id == null){
                    array_push($deal, 0);
                }else{
                    array_push($deal, 1);
                }
                if($show[$i]->bookings->isComplimentary == 1){
                    array_push($isComp, 1);
                }else{
                    array_push($isComp, 0);
                }
                array_push($price, $show[$i]->price);
            }else{
                $qty[$index] += 1;
                if($show[$i]->bookings->deal_id == null){
                    $deal[$index] += 0;
                }else{
                    $deal[$index] += 1;
                }
                if($show[$i]->bookings->isComplimentary == 1){
                    $isComp[$index] += 1;
                }else{
                    $isComp[$index] += 0;
                }
                $price[$index] += $show[$i]->price;
            }
        }



        $detail = ['screens'=>$screens, 'time'=>$time, 'qty'=>$qty, 'deal'=>$deal, 'isComp'=>$isComp, 'price'=>$price, 'movie'=>$movie , 'created_at'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function numberOfTicketSalesByMovie(){
        $movies = Movie::all();
        return view('pages.admin.reports.ticketReports.numberOfTicketSalesByMovie', compact('movies'));
    }


    public function advanceTicketSalesByMovie(){
        $movies = Movie::all();
        return view('pages.admin.reports.ticketReports.advanceTicketSalesByMovie', compact('movies'));
    }
    public function advanceTicketSalesByMovieReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');
        $show = PrintedTicket::where('key', 'advance')
                                ->where('movie_id', $request->id)
                                ->where('status', 1)
                                ->whereDate('created_at', $date)
                                ->with('show_times', 'screens','movies')
                                ->orderBy('show_time_id', 'asc')
                                ->get();

        $movie = Movie::where('id', $request->id)->pluck('title');
        $time = [];
        $qty = []; 
        $screens = [];
        $price = [];
        for($i=0; $i<count($show); $i++){
            $c_date = date('M-d-Y D h:i a', strtotime($show[$i]->show_times->dateTime));
            if(!in_array($c_date, $time)){
                array_push($time, $c_date);
                array_push($screens, $show[$i]->screens->name);
                $index = count($qty);
                array_push($qty, 1);
                array_push($price, $show[$i]->price);
            }else{
                $qty[$index] += 1;
                $price[$index] += $show[$i]->price;
            }
        }

        $detail = ['screens'=>$screens, 'time'=>$time, 'qty'=>$qty, 'price'=>$price, 'movie'=>$movie , 'created_at'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function numberOfAdvanceTicketSalesByMovie(){
        $movies = Movie::all();
        return view('pages.admin.reports.ticketReports.numberOfAdvanceTicketSalesByMovie', compact('movies'));
    }
    

    public function cashInHandByDay(){

        return view('pages.admin.reports.ticketReports.cashInHandByDay');
    }
    public function cashInHandByDayReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');
        $record = [];

        $allUser = PrintedTicket::where('status', 1)->whereDate('created_at', $date)->pluck('user_id')->toArray();
        $users_id = unique_array($allUser);
        foreach ($users_id as $id) {
            array_push($record, ['screen'=> Report::getScreenByUserByDate($id , $date)]);
        }
        for ($x=0; $x<count($users_id); $x++) {
            $ticketQtyArray = [];
            $ticketPriceArray = [];
            $dealQtyArray = [];
            $name = [];
            array_push($name, Report::getUserNameById($users_id[$x]) );

            for($i=0; $i<count($record[$x]['screen']); $i++){
                $ticketQty = Report::getTicketQtyByScreenByUserByDate($users_id[$x] , $date, $record[$x]['screen'][$i]);
                $ticketPrice = Report::getTicketPriceByScreenByUserByDate($users_id[$x] , $date, $record[$x]['screen'][$i]);
                $dealQty = Report::getDealQtyByScreenByUserByDate($users_id[$x] , $date, $record[$x]['screen'][$i]);
                array_push($ticketQtyArray, $ticketQty);
                array_push($ticketPriceArray, $ticketPrice);
                array_push($dealQtyArray, $dealQty);
            }
            $record[$x]['qty'] = $ticketQtyArray;
            $record[$x]['price'] = $ticketPriceArray;
            $record[$x]['dealQty'] = $dealQtyArray;
            $record[$x]['name'] = $name;
            $ticketQtyArray = [];
            $ticketPriceArray = [];
            $dealQtyArray = [];
            $name = [];
        }

        $detail = ['record'=>$record, 'date'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function cashInHandByUser(){
        $users = User::all();
        return view('pages.admin.reports.ticketReports.cashInHandByUser', compact('users'));
    }
    public function cashInHandByUserReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');
        $record = [];

        array_push($record, ['screen'=> Report::getScreenByUserByDate($request->id , $date)]);
    
        $ticketQtyArray = [];
        $ticketPriceArray = [];
        $dealQtyArray = [];
        $name = [];
        array_push($name, Report::getUserNameById($request->id) );

        for($i=0; $i<count($record[0]['screen']); $i++){
            $ticketQty = Report::getTicketQtyByScreenByUserByDate($request->id , $date, $record[0]['screen'][$i]);
            $ticketPrice = Report::getTicketPriceByScreenByUserByDate($request->id , $date, $record[0]['screen'][$i]);
            $dealQty = Report::getDealQtyByScreenByUserByDate($request->id , $date, $record[0]['screen'][$i]);
            array_push($ticketQtyArray, $ticketQty);
            array_push($ticketPriceArray, $ticketPrice);
            array_push($dealQtyArray, $dealQty);
        }
        $record[0]['qty'] = $ticketQtyArray;
        $record[0]['price'] = $ticketPriceArray;
        $record[0]['dealQty'] = $dealQtyArray;
        $record[0]['name'] = $name;
        $ticketQtyArray = [];
        $ticketPriceArray = [];
        $dealQtyArray = [];
        $name = [];
        

        $detail = ['record'=>$record, 'date'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function ticketCancellationByDay(){

        return view('pages.admin.reports.ticketReports.ticketCancellationByDay');
    }
    public function ticketCancellationByDayReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');

        $printedTicket = PrintedTicket::where('status', 0)
                                        ->whereDate('updated_at', $date)
                                        ->with('movies', 'screens', 'show_times', 'users', 'bookings')
                                        ->orderBy('updated_at', 'asc')
                                        ->get();
        $cancelUserName = Report::cancelUserName($date);

        $detail = ['record'=>$printedTicket, 'cancelUserName'=>$cancelUserName , 'date'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


    public function ticketSalesByUser(){

        return view('pages.admin.reports.ticketReports.ticketSalesByUser');
    }
    public function ticketSalesByUserReq(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $now = date('Y-m-d h:i a');

        
        $detail = ['date'=>$date, 'now'=>$now];
        return response()->json($detail);
    }


}
