<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use App\Models\ConcessionDetail;

class ConcessionMaster extends Model
{
    protected $fillable = [
        'user_id', 'deal_id', 'totalAmount', 'cancelUserId', 'voucherNo', 'remarks', 'cancelDate', 'status'
    ];

    public function users(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function deals(){
        return $this->belongsTo('App\Models\Deal','deal_id');
    }

    public function bookings(){
        return $this->hasMany('App\Models\Booking','voucher_id');
    }

    public function concession_details(){
    	return $this->hasMany('App\Models\ConcessionDetail');
    }

    public static function createCon(Request $request){
    	$conM = new ConcessionMaster;
    	$conM->user_id = Auth::user()->id;
        $conM->deal_id = null;
    	$conM->totalAmount = $request->total_v;
    	$conM->status = 1;
    	$conM->save();

    	$id = ConcessionMaster::where('user_id', Auth::user()->id)
    							->orderBy('created_at', 'desc')
    							->where('totalAmount', $request->total_v)
    							->pluck('id')
    							->first();
    	return $id;
    }

    public static function cancelCon(Request $request){
        
        $conM = ConcessionMaster::findOrFail($request->id);
        $conM->cancelUserId = Auth::user()->id;
        $conM->remarks = $request->remarks;
        $conM->cancelDate = date('y-m-d h:i:s');
        $conM->status = 0;
        $conM->save();

        $id = ConcessionDetail::Where('concession_master_id', $request->id)->pluck('id');
        for($i=0; $i<count($id); $i++){
            $conD = ConcessionDetail::findOrFail($id[$i]);
            $conD->cancelUserId = Auth::user()->id;
            $conD->cancelDate = date('y-m-d h:i:s');
            $conD->status = 0;
            $conD->save();
        }
    }

    public static function createFreeItem($deal){

        $type = json_decode($deal->type);
        $voucherNo = rand(1000, 100000);
        $conM = new ConcessionMaster;
        
        $conM->user_id = Auth::user()->id;
        $conM->deal_id = $deal->id;
        $conM->voucherNo = $voucherNo;
        $conM->totalAmount = 0;
        $conM->status = 1;
        $conM->save();

        $id = ConcessionMaster::where('user_id', Auth::user()->id)
                ->where('totalAmount', 0)
                ->where('voucherNo', $voucherNo)
                ->orderBy('created_at', 'desc')
                ->pluck('id')
                ->first();
        $voucherID = $id;
        
        for($y=0; $y<count($type); $y++){
            if($type[$y] == 'item' || $type[$y] == 'package'){
                if($type[$y] == 'item'){
                    $typeN = 'item';
                }else{
                    $typeN = 'package';
                }
                $conD = new ConcessionDetail;
                $conD->concession_master_id = $id;
                $conD->user_id = Auth::user()->id;
                $conD->type = $typeN;
                if($type[$y] == 'item'){
                    $conD->item_id = json_decode($deal->typeName)[$y];
                }else{
                    $conD->package_id = json_decode($deal->typeName)[$y];
                }
                $conD->price = 0;
                $conD->qty = json_decode($deal->qty)[$y];
                $conD->amount = 0;
                $conD->status = 1;
                $conD->save();
            }
        }

        return $voucherID;
    }

    public static function voucherRecord(Request $request){
        $voucherDetail = ConcessionMaster::where('voucherNo', $request->id)->where('status', 1)->with('concession_details', 'concession_details.items', 'concession_details.packages')->first();
        return $voucherDetail;
    }

    public static function deleteCon($id){
        ConcessionMaster::findOrFail($id)->delete();
    }

}
