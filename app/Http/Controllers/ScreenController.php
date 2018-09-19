<?php

namespace App\Http\Controllers;

use App\Models\Screen;
use App\Models\ShowTime;
use Illuminate\Http\Request;

class ScreenController extends Controller
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
        $screens =  Screen::all();
        return view('pages.admin.screen.viewScreens', compact('screens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.screen.addScreen');
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
            'totalSeats' => 'required',
            'rows' => 'required',
            'columns' => 'required'
        ]);

        Screen::createScreen($request);
        
        return redirect('screen/create')->withMessage('Added Screen Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function show(Screen $screen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $screen =  Screen::where('id', $id)->get()->first();
        return view('pages.admin.screen.editScreen', compact('screen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Screen $screen)
    {
        $request->validate([
            'name' => 'required',
            'totalSeats' => 'required',
            'rows' => 'required',
            'columns' => 'required'
        ]);

        Screen::updateScreen($request, $screen);
        
        return redirect('screen')->withMessage('Update Screen Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Screen  $screen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Screen $screen)
    {
        $s_id = ShowTime::where('screen_id', $screen->id)->get();
        if(count($s_id)>0){
            return redirect('/screen')->withErrors('Screen has assigned showtimes!');
        }else{
            Screen::findOrFail($screen->id)->delete();
            return redirect('/screen')->withMessage('Deleted Screen Sucessfully');
        }
        
    }
}
