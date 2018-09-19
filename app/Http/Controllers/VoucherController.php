<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Item;
use App\Models\ShowTime;

class VoucherController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission')->except('store' , 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = Voucher::all();
        return view('pages.admin.voucher.viewVoucher', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $items = Item::all();
        $tickets = Ticket::all();
        return view('pages.admin.voucher.addVoucher', compact('tickets', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'status' => 'required'
        ]);

        Voucher::createVoucher($request);
        
        return redirect('voucher/create')->withMessage('Added Voucher Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = Voucher::where('id', $id)->get()->first();
        $items = Item::all();
        $tickets = Ticket::all();
        return view('pages.admin.voucher.editVoucher', compact('voucher','items','tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'status' => 'required'
        ]);

        Voucher::updateVoucher($request, $voucher);
        
        return redirect('voucher')->withMessage('Update Voucher Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        $s_id = ShowTime::where('key', 'private')->where('voucher_id', $voucher->id)->get();

        if(count($s_id) > 0){
            return redirect('/voucher')->withErrors('Voucher has assigned showtimes!');
        }else{
            Voucher::findOrFail($voucher->id)->delete();
            return redirect('/voucher')->withMessage('Deleted Voucher Sucessfully');
        }
        
    }
}
