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

}
