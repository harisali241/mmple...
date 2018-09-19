<?php

namespace App\Http\Controllers;

use App\Models\FoodStall;
use Illuminate\Http\Request;

class FoodStallController extends Controller
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
        $foodStalls = FoodStall::all();
        return view('pages.admin.foodStall.viewFoodStall', compact('foodStalls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.foodStall.addFoodStall');
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
            'size' => 'required',
            'contractType' => 'required',
            'contractAmount' => 'required',
            'date' => 'required',
            'status' => 'required'
        ]);

        FoodStall::createFoodStall($request);
        
        return redirect('foodStall/create')->withMessage('Added Food Stall Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodStall  $foodStall
     * @return \Illuminate\Http\Response
     */
    public function show(FoodStall $foodStall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodStall  $foodStall
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foodStall = FoodStall::where('id', $id)->get()->first();
        return view('pages.admin.foodStall.editFoodStall', compact('foodStall'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodStall  $foodStall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required'
        ]);

        FoodStall::updateFoodStall($request, $id);
        
        return redirect('foodStall')->withMessage('Update Food Stall Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodStall  $foodStall
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodStall $foodStall)
    {
        FoodStall::findOrFail($foodStall->id)->delete();
        return redirect('/foodStall')->withMessage('Deleted Food Stall Sucessfully');
    }
}
