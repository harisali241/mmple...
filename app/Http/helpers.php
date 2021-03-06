<?php
use App\Models\ShowTime;
use App\Models\Permission;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Seat;
use App\Models\Item;
use App\Models\Package;
use App\Models\PrintedTicket;
use App\Models\Timing;
use App\Models\Batch;
use Carbon\Carbon;
use App\Mail\CancelTicket;

function is_connected(){
	try{
		$connected = fopen("http://www.google.com:80/","r");
		return 1;
	}catch(Exception $e) {
		return 0;
	}	
}

function batch(){
	Batch::runBatch();
}

function sendCancellationEmail($request){
	Mail::to('harisali241@gmail.com')->send(new CancelTicket($request));
}


function dayStartDate(){
	$timing = Timing::where('id', 1)->first();
	$c_dt = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'));
	$s_hour = 24-date('H',strtotime($timing->dayStartTime));
    $s_min = date('i',strtotime($timing->dayStartTime));
    $s_sec = date('s',strtotime($timing->dayStartTime));
    $dayStartDate = $c_dt->subDay(1)->addHour($s_hour)->addMinute($s_min)->addSecond($s_sec);
    return $dayStartDate;
}

function dayEndDate(){
	$timing = Timing::where('id', 1)->first();
    $hour = date('H',strtotime($timing->dayEndTime));
    $min = date('i',strtotime($timing->dayEndTime));
    $sec = date('s',strtotime($timing->dayEndTime));
	$c_dt = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s'));
    $dayEndDate = $c_dt->addDay(1)->subHour($hour)->subMinute($min)->subSecond($sec);
    return $dayEndDate;
}

function dayStartTime($datetime){
	$timing = Timing::where('id', 1)->first();
	$c_dt = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime($datetime)));
	$s_hour = date('H',strtotime($timing->dayStartTime));
    $s_min = date('i',strtotime($timing->dayStartTime));
    $s_sec = date('s',strtotime($timing->dayStartTime));
    $dayStartDate = $c_dt->addHour($s_hour)->addMinute($s_min)->addSecond($s_sec);
    return $dayStartDate;
}

function dayEndTime($datetime){
	// $timing = Timing::where('id', 1)->first();
	// $hour = 24+date('H',strtotime($timing->dayEndTime));
	// $min = date('i',strtotime($timing->dayEndTime));
	// $sec = date('s',strtotime($timing->dayEndTime));
	$c_dt = Carbon::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s',strtotime(dayStartTime($datetime))));
    $dayEndDate = $c_dt->addDay(1);
    return $dayEndDate;
}

function unique_array($arrays){
	$newArray = [];
	foreach($arrays as $array){
        if(!in_array($array, $newArray)){
            array_push($newArray, $array);
        }
    }
    return $newArray;
}

function array_msort($array, $cols){
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}

function userFirstName($id){
	$user = User::where('id', $id)->pluck('firstName')->first();
	return $user;
}

function todayTicket($data){
	$totalTickets = $data->bookings;
	$todayTicket = 0;
	for($i=0; $i<count($totalTickets); $i++){
		if(date('Y-m-d',strtotime($totalTickets[$i]->created_at)) == date('Y-m-d') ){
			$todayTicket++;
		}
	} 
	return $todayTicket;
}
function todayConsession($data){
	$totalCons = $data->concession_details;
	$todayCon = 0;
	for($i=0; $i<count($totalCons); $i++){
		if(date('Y-m-d',strtotime($totalCons[$i]->created_at)) == date('Y-m-d') ){
			$todayCon++;
		}
	} 
	return $todayCon;
}

function checkUserPermission(){
	$routes = [];
	$userRoutes = DB::table('permissions')
		            ->join('menus', 'permissions.menu_id', '=', 'menus.id')
		            ->select('menus.route')
					->where('permissions.user_id', Auth::user()->id)
					->where('permissions.status', 1)
					->whereNotNull('menus.route')
		            ->get();
		            foreach ($userRoutes as $value) {
						array_push($routes, $value->route);
					}
	$data = in_array(Request::route()->getName(), $routes);
	return $data;
}

function getRoutes(){
	$routePath = [];
	$userRoutes = DB::table('permissions')
		            ->join('menus', 'permissions.menu_id', '=', 'menus.id')
		            ->select('menus.route')
					->where('permissions.user_id', Auth::user()->id)
					->where('permissions.status', 1)
					->whereNotNull('menus.route')
		            ->get();
		            foreach ($userRoutes as $value) {
						array_push($routePath, $value->route);
					}
	return $routePath;
}

function getRoutePath(){
	$routePath = [];
	$userRoutes = DB::table('permissions')
		            ->join('menus', 'permissions.menu_id', '=', 'menus.id')
		            ->select('menus.path')
					->where('permissions.user_id', Auth::user()->id)
					->where('permissions.status', 1)
					->whereNotNull('menus.path')
		            ->get();
		            foreach ($userRoutes as $value) {
						array_push($routePath, $value->path);
					}
	return $routePath;
}

function months(){
	$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec");
	return $months;
}

function measuringUnit(){
	$measuring_units = array();

	$measuring_units['bag'] = 'Bag';
	$measuring_units['bottle'] = 'Bottle';
	$measuring_units['box'] = 'Box';
	$measuring_units['cup'] = 'Cup';
	$measuring_units['each'] = 'Each';
	$measuring_units['kilogram'] = 'Kilogram';
	$measuring_units['litre'] = 'Litre';
	$measuring_units['ounce'] = 'Ounce';
	$measuring_units['pack'] = 'Pack';
	$measuring_units['pound'] = 'Pound';
	$measuring_units['serving'] = 'Serving';
	$measuring_units['slice'] = 'Slice';

	return $measuring_units;
}

function bgColor(){
	$bg_color = array();
	$bg_color['pink'] = 'Pink';$bg_color['blue'] = 'Blue';$bg_color['yellow'] = 'Yellow';$bg_color['green'] = 'Green';$bg_color['#000000'] = '#000000';$bg_color['#FF0000'] = '#FF0000';$bg_color['#00FF00'] = '#00FF00';$bg_color['#0000FF'] = '#0000FF';$bg_color['#FFFF00'] = '#FFFF00';$bg_color['#00FFFF'] = '#00FFFF';$bg_color['#FF00FF'] = '#FF00FF';$bg_color['#C0C0C0'] = '#C0C0C0';$bg_color['#E00000 '] = '#E00000 ';$bg_color['#0000FF'] = '#0000FF';$bg_color['#330033'] = '#330033';$bg_color['#333399'] = '#333399';$bg_color['#660033'] = '#660033';$bg_color['#9933FF'] = '#9933FF';$bg_color['#99FFCC'] = '#99FFCC';$bg_color['#CCCC33'] = '#CCCC33';$bg_color['#FF0033'] = '#FF0033';$bg_color['#FF6600'] = '#FF6600';$bg_color['#FFCC00'] = '#FFCC00';$bg_color['#6600CC'] = '#6600CC';$bg_color['#003300'] = '#003300';$bg_color['#015487'] = '#015487';$bg_color['#ed1c24'] = '#ed1c24';$bg_color['#149fb0'] = '#149fb0';$bg_color['#e3752c'] = '#e3752c';$bg_color['#e55e7e'] = '#e55e7e';$bg_color['#03c9ab'] = '#03c9ab';

	return $bg_color;
}

function allMovieshelper(){
    $movies = Movie::where('status', 1)->with('distributers')->get();
    return $movies;
}

function movieStatushelper(){
    $movieStatus = Movie::where('status', 2)->pluck('id');
    return $movieStatus;
}

function ticketClass(){
	$ticket_class = array();
	$ticket_class['platinum'] 	= 'Platinum';
	$ticket_class['gold']		= 'Gold';
	$ticket_class['silver'] 	= 'Silver';

	return $ticket_class;
}

function ticketType(){
	$ticket_type = array();

	$ticket_type['standard'] 	 = 'Standard';
	$ticket_type['complimentary'] = 'Complimentary';
	$ticket_type['redemption'] = 'Redemption';

	return $ticket_type;
}

function showTimeColor(){
	$showtime_color = array();

	$showtime_color['pink'] = 'pink';
	$showtime_color['blue'] = 'blue';
	$showtime_color['yellow'] = 'yellow';
	$showtime_color['green'] = 'green';
	return $showtime_color;
}

function getMovieShowTimes($id){
	$showTime = ShowTime::where('movie_id', $id)
						->where('key', 'public')
						->where('status', 1)
						->with('screens', 'movies')
						->orderBy('created_at', 'asc')
						->get();
	return $showTime;
}

function bookedSeatsQty($id){
	$booking = Booking::where('show_time_id', $id)->where('status', 1)->get();
	return $booking;
}

function getUserSelectedSeats(){
    $bookings = Booking::where('user_id', Auth::user()->id)
                        ->where('hold' , 1)
                        ->where('status', 0)
                        ->with('movies')
                        ->get();
    return $bookings;
}

function getBooking(){
	$bookings = Booking::where('status', 1)->with('movies', 'screens', 'tickets', 'show_times')->get();
    return $bookings;
}

function getPlannedShows(){
	$shows = ShowTime::where('status', 2)->get();
	return count($shows);
}

function removeUserHoldBooking(){
	$id = Booking::where('user_id', Auth::user()->id)->where('hold', 1)->where('status', 0)->where('key', 'public')->pluck('id');
	for($i=0; $i<count($id); $i++){
        Booking::findOrFail($id[$i])->delete();
    }
}

function BackToNormalBooking(){
	$id = Booking::where('user_id', Auth::user()->id)->where('hold',1)->where('reserveBooking', 1)->pluck('id');
	for($i=0; $i<count($id); $i++){
        Booking::findOrFail($id[$i])->delete();
    }
}

function getItemById($id){
	$itemName = Item::where('id', $id)->pluck('name')->first();
	return $itemName;
}

function getPackageById($id){
	$packageName = Package::where('id', $id)->pluck('name')->first();
	return $packageName;
}


