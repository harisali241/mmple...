<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\Distributer;
use App\Models\MoviePerson;
use App\Models\WebMovie;
use App\Models\Batch;
use Auth;

class MovieController extends Controller
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

        $movies =  Movie::fetchMovies();Batch::runBatch();
        return view('pages.admin.movie.viewMovies', compact('movies'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $distributers = Distributer::all();
        $actors = MoviePerson::all();
        return view('pages.admin.movie.addMovie', compact('distributers', 'actors'));
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
            'distributer_id' => 'required',
            'genre' => 'required',
            'duration' => 'required',
            'poster' => 'required'
        ]);

        $movie_id = Movie::createMovie($request);
        Batch::createBatch($movie_id, 'web_movies', 'store');
        Batch::runBatch();
        
        return redirect('movie/create')->withMessage('Added Movie Sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movie =  Movie::fetchSingleMovies($id);
        $distributers = Distributer::pluck('name','id');
        $actors = MoviePerson::all();
        //dd(json_decode($movie->actor));
        return view('pages.admin.movie.editMovie', compact('movie', 'distributers', 'actors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required',
            'distributer_id' => 'required',
            'genre' => 'required',
            'duration' => 'required',
        ]);

        $movie_id = Movie::updateMovie($request, $movie);
        Batch::createBatch($movie_id, 'web_movies', 'update');
        Batch::runBatch();
        
        return redirect('movie')->withMessage('Update Movie Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {   
        $msg = Movie::deleteMovie($movie);
        if($msg[0] == 'message'){
            Batch::createBatch($movie->id, 'web_movies', 'delete');
            Batch::runBatch();
            return redirect('movie')->with('message', $msg[1]);
        }else{
            return redirect('movie')->withErrors($msg[1]);
        }
    }
}
