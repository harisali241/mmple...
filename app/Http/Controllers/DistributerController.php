<?php

namespace App\Http\Controllers;

use App\Models\Distributer;
use App\Models\Movie;
use Illuminate\Http\Request;

class DistributerController extends Controller
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
        $distributers = Distributer::all();
        return view('pages.admin.distributer.viewDist', compact('distributers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.distributer.addDist');
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

        Distributer::createDistributer($request);
        
        return redirect('distributer/create')->withMessage('Added Distributer Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Distributer  $distributer
     * @return \Illuminate\Http\Response
     */
    public function show(Distributer $distributer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Distributer  $distributer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $distributer = Distributer::where('id', $id)->get()->first();
        //dd($distributer);   
        return view('pages.admin.distributer.editDist', compact('distributer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Distributer  $distributer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        //dd($request);
       $this->validate(request(),[
            'name' => 'required'
        ]);

        Distributer::updateDistributer($request, $id);
        
        return redirect('distributer')->withMessage('Update Distributer Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Distributer  $distributer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $check = Movie::where('distributer_id', $id)->get();
        if(count($check)<=0){
            Distributer::findOrFail($id)->delete();
            return redirect('/distributer')->withMessage('Deleted Distributer Sucessfully');
        }else{
            return redirect('/distributer')->withErrors('Distributers has movies assigned!');
        }
        
    }
}
