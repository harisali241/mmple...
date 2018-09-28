<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Package;
use App\Models\ConcessionMaster;

class BookConcessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission');
    }

    public function bookConcession(){
    	$items = Item::where('status', 1)->get();
    	$packages = Package::where('status', 1)->where('display', 1)->get();
    	return view('pages.terminal.concession.bookConcession', compact('items', 'packages'));
    }

    public function cancelConcession(){
    	$conM = ConcessionMaster::where('status', 1)
                ->where('deal_id', null)
		    	->with('concession_details','users', 'concession_details.items', 'concession_details.packages')
                ->orderBy('id', 'desc')
		    	->get();
    	return view('pages.terminal.concession.cancelConcession', compact('conM'));
    }

    public function voucherConcession(){
        return view('pages.terminal.concession.voucherConcession');
    }
}
