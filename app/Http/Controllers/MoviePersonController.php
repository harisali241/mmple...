<?php

namespace App\Http\Controllers;

use App\Models\MoviePerson;
use Illuminate\Http\Request;

class MoviePersonController extends Controller
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
        $actors = MoviePerson::all();
        return view('pages.admin.actor.viewActor', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.actor.addActor');
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

        MoviePerson::createMoviePerson($request);
        
        return redirect('moviePerson/create')->withMessage('Added Actor Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MoviePerson  $moviePerson
     * @return \Illuminate\Http\Response
     */
    public function show(MoviePerson $moviePerson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MoviePerson  $moviePerson
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actor = MoviePerson::where('id', $id)->get()->first();
        return view('pages.admin.actor.editActor', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MoviePerson  $moviePerson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        MoviePerson::updateMoviePerson($request, $id);
        
        return redirect('moviePerson')->withMessage('Update Actor Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MoviePerson  $moviePerson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MoviePerson::findOrFail($id)->delete();
        return redirect('/moviePerson')->withMessage('Deleted Actor Sucessfully');
    }
}
