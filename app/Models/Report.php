<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Report extends Model
{

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


}
