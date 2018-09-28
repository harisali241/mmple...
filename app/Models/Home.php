<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ConcessionDetail;
use App\Models\Package;
use App\Models\ShowTime;
use App\Models\Movie;
use App\Models\Item;
use App\Models\Home;
use App\User;

class Home extends Model
{
    public static function itemQty($id, $name){
    	$t_item = 0;
    	$products = Package::all();
    	foreach($products as $pro){
    		$itemName = json_decode($pro->itemName);
    		$itemQty = json_decode($pro->itemQty);
    		for($i=0; $i<count($itemName); $i++){
    			if($itemName[$i] == $name){
    				$t_item += Home::packageQty($pro->id)*$itemQty[$i];
    			}
    		}
    	}
    	$item = ConcessionDetail::where('item_id', $id)->get();
    	$i_item = 0;
    	foreach ($item as $con) {
    		$i_item += $con->qty;
    	}
    	$t_item += $i_item;
    	return $t_item;
    }

    public static function packageQty($id){
    	$pack = ConcessionDetail::where('package_id', $id)->get();
    	$i_item = 0;
    	foreach ($pack as $con) {
    		$i_item += $con->qty;
    	}
    	return $i_item;
    }

    public static function topSellerItem(){
    	$conM = Item::with('concession_details')->get();
        $items = [];
        foreach ($conM as $con) {
            array_push($items, ['name' => $con->name, 
                                'qty' => Home::itemQty($con->id, $con->name), 
                                'price' => Home::itemQty($con->id, $con->name)*$con->defaultPrice]);
        }
        $topSellers = array_msort($items, array('price'=>SORT_DESC));
        return $topSellers;
    }

    public static function ticketSales(){
    	$user = User::with('bookings')->get();
    	return $user;
    }

    public static function concessionSales(){
    	$user = User::with('concession_details')->get();
    	return $user;
    }
}
