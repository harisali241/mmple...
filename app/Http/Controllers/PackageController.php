<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\FoodCategories;
use App\Models\Item;

class PackageController extends Controller
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
        $packages =  Package::fetchPackages();
        return view('pages.admin.package.viewPackages', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foodCategories = FoodCategories::all();
        $items = Item::all();
        return view('pages.admin.package.addPackage', compact('foodCategories', 'items'));
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
        $request->validate([
            'name' => 'required',
            'measuringUnit' => 'required',
            'foodCategory_id' => 'required',
            'defaultPrice' => 'required',
            'costPrice' => 'required',
            'image' => 'required',
            'itemName' => 'required',
            'itemQty' => 'required',
            'itemPrice' => 'required',
            'status' => 'required',
        ]);

        Package::createPackage($request);
        
        return redirect('package/create')->withMessage('Added Package Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package =  Package::fetchSinglePackage($id);
        $foodCategories = FoodCategories::pluck('name', 'id');
        $items = Item::all();
        return view('pages.admin.package.editPackage', compact('package', 'foodCategories', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //dd($request);
        $request->validate([
            'name' => 'required',
            'measuringUnit' => 'required',
            'foodCategory_id' => 'required',
            'defaultPrice' => 'required',
            'costPrice' => 'required',
            'itemName' => 'required',
            'itemQty' => 'required',
            'itemPrice' => 'required',
            'status' => 'required',
        ]);

        Package::checkThenUpdatePackage($request, $package);
        
        return redirect('package')->withMessage('Update Package Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $msg = Package::deletePackage($package);
        if($msg == 0){
            return redirect('package')->withErrors('Package has Sales!');
        }else{
            return redirect('package')->withMessage('Delete Package Sucessfully');
        }
        
    }
}
