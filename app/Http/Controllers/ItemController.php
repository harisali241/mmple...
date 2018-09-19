<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\FoodCategories;

class ItemController extends Controller
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
        $items =  Item::fetchItems();
        return view('pages.admin.item.viewItems', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foodCategories = FoodCategories::all();
        return view('pages.admin.item.addItem', compact('foodCategories'));
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
            'name' => 'required',
            'measuringUnit' => 'required',
            'foodCategory_id' => 'required',
            'defaultPrice' => 'required',
            'costPrice' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        Item::createItem($request);
        
        return redirect('item/create')->withMessage('Added Item Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $item =  Item::fetchSingleItems($id);
        $foodCategories = FoodCategories::all();
        return view('pages.admin.item.editItem', compact('item', 'foodCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
       $request->validate([
            'name' => 'required',
            'measuringUnit' => 'required',
            'foodCategory_id' => 'required',
            'defaultPrice' => 'required',
            'costPrice' => 'required',
            'status' => 'required',
        ]);

        Item::updateItem($request, $item);
        
        return redirect('item')->withMessage('Update Item Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {   
        $msg = Item::deleteItem($item);
        if($msg == 0){
            return redirect('item')->withErrors('Item has sales!');
        }else{
            return redirect('item')->withMessage('Delete Item Sucessfully');
        }
        
    }
}
