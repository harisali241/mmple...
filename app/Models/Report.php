<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Report extends Model
{

	public static function idByWeek($id, $created_at){
		$firstDayOfWeek = date('Y-m-d',strtotime($created_at));
		$lastDayOfWeek = date('Y-m-d', strtotime( Carbon::createFromFormat('Y-m-d' ,date('Y-m-d',strtotime($firstDayOfWeek) ))->addWeek() ));
		$priceArray = PrintedTicket::where('movie_id', $id)->whereBetween('created_at',array($firstDayOfWeek, $lastDayOfWeek))->pluck('price');
		$price = 0;
		foreach ($priceArray as $p) {
			$price += $p;
		}
		$detail = ['price'=>$price, 'lastDayOfWeek'=> $lastDayOfWeek, 'firstDayOfWeek'=> $firstDayOfWeek];
		return $detail;
	}

	public static function compPrice($id){
		$compPrice = 0;
        $compPriceArray = PrintedTicket::where('movie_id', $id)->where('price', 0)->with('bookings.tickets')->get();
        if(count($compPriceArray)>0){
            foreach ($compPriceArray as $comp) {
                if($comp->bookings->ticketType == 'adult price'){
                    $compPrice += $comp->bookings->tickets->adultPrice;
                }else{
                    $compPrice += $comp->bookings->tickets->childPrice;
                }
            }
        }
        return $compPrice;
	}

	public static function getUserNameById($id){
		$userName =  User::where('id', $id)->pluck('firstName')->first();
		return $userName;
	}
   
	public static function getScreenByUserByDate($id, $date){
		$rep = PrintedTicket::whereDate('created_at', $date)->where('user_id', $id)->with('screens')->get();
		$screen = [];
		foreach($rep as $re){
			if(!in_array($re->screens->name, $screen)){
				array_push($screen, $re->screens->name);
			}
		}
		return $screen;
	}

	public static function getTicketQtyByScreenByUserByDate($id, $date, $screen){
		$screen_id = Screen::where('name', $screen)->pluck('id')->first();
		$rep = PrintedTicket::whereDate('created_at', $date)
							->where('user_id', $id)
							->where('screen_id', $screen_id)
							->get();
		return count($rep);
	}

	public static function getTicketPriceByScreenByUserByDate($id, $date, $screen){
		$screen_id = Screen::where('name', $screen)->pluck('id')->first();
		$rep = PrintedTicket::whereDate('created_at', $date)
							->where('user_id', $id)
							->where('screen_id', $screen_id)
							->pluck('price');
		$price = 0;
		foreach($rep as $re){
			$price += $re;
		}
		return $price;
	}

	public static function getDealQtyByScreenByUserByDate($id, $date, $screen){
		$screen_id = Screen::where('name', $screen)->pluck('id')->first();
		$rep = PrintedTicket::whereDate('created_at', $date)
							->where('user_id', $id)
							->where('screen_id', $screen_id)
							->with('bookings')
							->get();
		$dealQty = 0;
		foreach($rep as $re){
			if($re->bookings->deal_id != null){
				$dealQty += 1;
			}
		}
		return $dealQty;
	}

	public static function cancelUserName($date){
		$cancelUserId = PrintedTicket::where('status', 0)
                                        ->whereDate('updated_at', $date)
                                        ->orderBy('updated_at', 'asc')
                                        ->pluck('cancelUserId');
        $userFn = [];
        foreach ($cancelUserId as $k => $v) {
        	$Fn = User::where('id', $v)->pluck('firstName')->first();
        	array_push($userFn, $Fn);
        }
		return $userFn;
	}

	public static function dealNames($book){
		$deals = [];
		$deal_id = [];
		$userName = [];
		for($i=0; $i<count($book); $i++){
			if($book[$i]->deal_id != null){
				if(!in_array($book[$i]->deals->name, $deals)){
					array_push($deals, $book[$i]->deals->name);
					array_push($deal_id, $book[$i]->deal_id);
					array_push($userName, $book[$i]->users->firstName);
				}
			}
		}
		$deal = ['name'=>$deals , 'id'=>$deal_id, 'username'=>$userName];
		return $deal;
	}

	public static function dealQtyById($id){
		$qty= [];
		for($i=0; $i<count($id); $i++){
			$count = count( Booking::where('deal_id', $id[$i])->get() );
			array_push($qty, $count);
		}
		return $qty;
	}

	public static function dealPriceById($id){
		$price = [];
		for($i=0; $i<count($id); $i++){
			$book = Booking::where('deal_id', $id[$i])->with('tickets')->get();
			$priceCount = 0;
			foreach ($book as $key => $value) {
				if($value->ticketType == 'adult price'){
					$priceCount += $value->tickets->adultPrice;
				}else{
					$priceCount += $value->tickets->childPrice;
				}
				
			}
			array_push($price, $priceCount);
		}
		return $price;
	}


	public static function getMovies($book){
		$movie_name = [];
		$movie_id = [];
		for($i=0; $i<count($book); $i++){
			if(!in_array($book[$i]->movies->title, $movie_name)){
				array_push($movie_name, $book[$i]->movies->title);
				array_push($movie_id, $book[$i]->movie_id);
			}
		}
		$movie = ['movie_name'=>$movie_name , 'movie_id'=>$movie_id ];
		return $movie;
	}

	public static function getQtyMovies($id){
		$deal_qty = [];
		$comp_qty = [];
		$qty = [];
		$deal_price = [];
		$comp_price = [];
		$price = [];
		for($i=0; $i<count($id); $i++){
			$deal_count = Booking::where('movie_id', $id[$i])->where('deal_id', '!=', null)->with('tickets')->get();
			$comp_count = Booking::where('movie_id', $id[$i])->where('deal_id', null)->where('isComplimentary', 1)->with('tickets')->get();
			$count = Booking::where('movie_id', $id[$i])->get();
			$deal_price_i = 0;
			$comp_price_i = 0;
			$price_i = 0;
			array_push($deal_qty, count($deal_count));
			array_push($comp_qty, count($comp_count));
			array_push($qty, count($count));
			foreach ($deal_count as $key => $value) {
				if($value->ticketType == 'adult price'){
					$deal_price_i += $value->tickets->adultPrice;
				}else{
					$deal_price_i += $value->tickets->childPrice;
				}
			}
			foreach ($comp_count as $key => $value) {
				if($value->ticketType == 'adult price'){
					$comp_price_i += $value->tickets->adultPrice;
				}else{
					$comp_price_i += $value->tickets->childPrice;
				}
			}
			foreach ($count as $key => $value) {
				$price_i += $value->price;
			}
			array_push($deal_price, $deal_price_i);
			array_push($comp_price, $comp_price_i);
			array_push($price, $price_i);
		}
		$movie = ['deal_qty'=>$deal_qty , 'comp_qty'=>$comp_qty, 'deal_price'=>$deal_price  ,'comp_price'=>$comp_price, 'qty'=>$qty , 'price'=>$price ];
		return $movie;
	}

	public static function getMovieOfShow($screen, $date){
		$movie = [];
		for($i=0; $i<count($screen); $i++){
			$titleArray = [];
			$showTime = [];
			$movie_title = Booking::whereDate('created_at', $date)->with('screens', 'movies')->get()->where('screens.name', $screen[$i]);
			foreach($movie_title as $title){
				if(!in_array($title->showTime, $showTime)){
					array_push($showTime, $title->showTime);
					array_push($titleArray, $title->movies->title);
				}
			}
			array_push($movie, $titleArray);
		}
		return $movie;
	}

}
