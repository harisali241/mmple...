<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Voucher extends Model
{
    protected $fillable = [
        'title', 'description', 'price', 'startDate ', 'endDate', 'isPackage', 'itemName', 'itemPrice', 'itemQty', 'ticketType', 'ticketName', 'ticketPrice','ticketQty', 'status'
    ];

    public function show_times(){
        return $this->hasMany('App\Models\ShowTime','voucher_id');
    }

    public static function createVoucher(Request $request){

    	$voucher = new Voucher;

    	$voucher->title = request('title');
    	$voucher->description = request('description');
    	$voucher->price = request('price');
    	$voucher->startDate = request('startDate');
    	$voucher->endDate = request('endDate');
    	$voucher->isPackage = request('isPackage');
    	$voucher->itemName = json_encode( request('itemName') );
    	$voucher->itemPrice = json_encode( request('itemPrice') );
    	$voucher->itemQty = json_encode( request('itemQty') );
    	$voucher->ticketType = json_encode( request('ticketType') );
    	$voucher->ticketName = json_encode( request('ticketName') );
    	$voucher->ticketPrice = json_encode( request('ticketPrice') );
    	$voucher->ticketQty = json_encode( request('ticketQty') );
    	$voucher->status = request('status');

    	$voucher->save();
    }

    public static function updateVoucher(Request $request, Voucher $voucher){

    	$voucher = Voucher::findOrFail($voucher->id);

    	$voucher->title = request('title');
    	$voucher->description = request('description');
    	$voucher->price = request('price');
    	$voucher->startDate = request('startDate');
    	$voucher->endDate = request('endDate');
    	$voucher->isPackage = request('isPackage');
    	$voucher->itemName = json_encode( request('itemName') );
    	$voucher->itemPrice = json_encode( request('itemPrice') );
    	$voucher->itemQty = json_encode( request('itemQty') );
    	$voucher->ticketType = json_encode( request('ticketType') );
    	$voucher->ticketName = json_encode( request('ticketName') );
    	$voucher->ticketPrice = json_encode( request('ticketPrice') );
    	$voucher->ticketQty = json_encode( request('ticketQty') );
    	$voucher->status = request('status');

    	$voucher->save();

    }
    
}
