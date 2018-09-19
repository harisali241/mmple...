<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ConcessionDetail extends Model
{
    protected $fillable = [
        'concession_master_id', 'user_id', 'type', 'package_id', 'item_id', 'price', 'qty', 'amount', 'cancelUserId', 'cancelDate', 'status'
    ];

    public function consession_masters(){
    	return $this->belongsTo('App\Models\ConessionMasters','concession_master_id');
    }

    public function items(){
    	return $this->belongsTo('App\Models\Item','item_id');
    }

    public function packages(){
    	return $this->belongsTo('App\Models\Package','package_id');
    }

    public function users(){
    	return $this->belongsTo('App\User','user_id');
    }
 	
 	public static function createCon($request, $id, $i){
 		$amount = $request->qty[$i] * $request->price[$i];

 		$conD = new ConcessionDetail;
 		$conD->concession_master_id = $id;
 		$conD->user_id = Auth::user()->id;
 		$conD->type = $request->type[$i];
 		if($request->type[$i] == 'item'){
 			$conD->item_id = $request->type_id[$i];
 		}else{
 			$conD->package_id = $request->type_id[$i];
 		}
 		$conD->price = $request->price[$i];
 		$conD->qty = $request->qty[$i];
 		$conD->amount = $amount;
 		$conD->status = 1;
 		$conD->save();
    }

}
