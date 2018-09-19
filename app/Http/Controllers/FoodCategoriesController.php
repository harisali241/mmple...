<?php

namespace App\Http\Controllers;

use App\Models\FoodCategories;
use App\Models\Item;
use App\Models\Package;
use Illuminate\Http\Request;

class FoodCategoriesController extends Controller
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
        $foodCategories = FoodCategories::all();
        return view('pages.admin.foodCat.viewFoodCat', compact('foodCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.foodCat.addFoodCat');
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
            'name' => 'required'
        ]);

        FoodCategories::createFoodCategories($request);
        
        return redirect('foodCategories/create')->withMessage('Added Category Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCategories $foodCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foodCategory = FoodCategories::Where('id' , $id)->get()->first();
        return view('pages.admin.foodCat.editFoodCat', compact('foodCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        FoodCategories::updateFoodCategories($request, $id);
        
        return redirect('foodCategories')->withMessage('Update Category Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $i_id = Item::where('foodCategory_id', $id)->get();
        $p_id = Package::where('foodCategory_id', $id)->get();

        if(count($i_id)>0 || count($p_id)>0){
            return redirect('/foodCategories')->withErrors('Food Category has assigned!');
        }else{
            FoodCategories::findOrFail($id)->delete();
            return redirect('/foodCategories')->withMessage('Deleted Category Sucessfully');
        }
        
    }
}
