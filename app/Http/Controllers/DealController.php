<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Item;
use App\Models\Movie;
use App\Models\ShowTime;
use App\Models\Package;
use Illuminate\Http\Request;

class DealController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('userPermission')->except('store', 'update', 'edit', 'destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $deals = Deal::where('display', 1)->with('movies')->get();        
        return view('pages.admin.deal.viewDeal', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $items = Item::where('status', 1)->get();
        $movies = Movie::where('status', 1)->get();
        $packages = Package::where('status', 1)->get();
        return view('pages.admin.deal.addDeal', compact('items', 'movies', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        Deal::createDeal($request);
        return redirect('deal')->with('message', 'Added Deal Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function show(Deal $deal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function edit(Deal $deal)
    {   
        $deal = Deal::where('id', $deal->id)->get()->first();
        $items = Item::where('status', 1)->get();
        $movies = Movie::where('status', 1)->get();
        $packages = Package::where('status', 1)->where('display', 1)->get();
        return view('pages.admin.deal.editDeal', compact('deal', 'items', 'movies', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deal $deal)
    {   
        //dd($request);
        Deal::updateDeal($request, $deal);
        return redirect('deal')->with('message', 'Update Deal Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {   
        Deal::deleteDeal($deal);
        return redirect('deal')->with('message', 'Delete Deal Sucessfully');
    }
}
