<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Distributer;
use Auth;
use File;
use App\Models\ShowTime;
use Intervention\Image\ImageManagerStatic as Image;

class Movie extends Model
{
    protected $fillable = [
        'title', 'distributer_id', 'rating', 'releaseDate ', 'genre', 'duration', 'nationalCode', 'format', 'contractType', 'rentalCharges', 'distributerSeats', 'contractStartDate', 'actor', 'role', 'poster', 'synopsis', 'trailor', 'status', 'user_id'
    ];
    
    public function printed_tickets(){
        return $this->hasMany('App\Models\PrintedTicket');
    }

    public function deals(){
        return $this->hasMany('App\Models\Deal');
    }

    public function distributers(){
    	return $this->belongsTo('App\Models\Distributer','distributer_id');
    }

    public function show_times(){
        return $this->hasMany('App\Models\ShowTime','movie_id');
    }

    public function bookings(){
        return $this->hasMany('App\Models\Booking','movie_id');
    }

    public function advance_bookings(){
        return $this->hasMany('App\Models\AdvanceBooking');
    }

    public static function fetchMovies(){
    	$movies = Movie::with('distributers')->get();
    	return $movies;
    }

    public static function fetchSingleMovies($id){
    	$movies = Movie::where('id', $id)->with('distributers')->get()->first();
    	return $movies;
    }

    public static function createMovie(Request $request){

    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        if($request->hasFile('poster')){
            $file = $request->file('poster');
            $filename = mt_rand(100,5000).$file->getClientOriginalName();
            $image = Image::make($file)->resize(300, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $image->save($upload_dir.'m_'.$filename);
            $file->move($upload_dir, $filename);
        }else{
            $filename = '';
        }

    	$movie = new Movie;

    	$movie->title = request('title');
    	$movie->distributer_id = request('distributer_id');
    	$movie->rating = request('rating');
    	$movie->releaseDate = request('releaseDate');
    	$movie->genre = request('genre');
    	$movie->duration = request('duration');
    	$movie->nationalCode = request('nationalCode');
    	$movie->format = request('format');
    	$movie->contractType = request('contractType');
    	$movie->rentalCharges = request('rentalCharges');
    	$movie->distributerSeats = request('distributerSeats');
    	$movie->contractStartDate = request('contractStartDate');
    	$movie->actor = json_encode( request('actor') );
    	$movie->role = json_encode( request('role') );
    	$movie->poster = $filename;
    	$movie->synopsis = request('synopsis');
    	$movie->trailor = request('trailor');
    	$movie->status = request('status');
    	$movie->user_id = Auth::user()->id;

    	$movie->save();

    }

    public static function updateMovie(Request $request, Movie $movie){


    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        if($request->hasFile('poster')){
        	File::delete($upload_dir .'/'. $movie->poster);
            File::delete($upload_dir .'/m_'. $movie->poster);
	        $file = $request->file('poster');
	        $filename = mt_rand(100,5000).$file->getClientOriginalName();
            $image = Image::make($file)->resize(300, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $image->save($upload_dir.'m_'.$filename);
	        $file->move($upload_dir, $filename);
   		}else{
   			$filename = $movie->poster;
   		}

    	$movie = Movie::findOrFail($movie->id);

    	$movie->title = request('title');
    	$movie->distributer_id = request('distributer_id');
    	$movie->rating = request('rating');
    	$movie->releaseDate = request('releaseDate');
    	$movie->genre = request('genre');
    	$movie->duration = request('duration');
    	$movie->nationalCode = request('nationalCode');
    	$movie->format = request('format');
    	$movie->contractType = request('contractType');
    	$movie->rentalCharges = request('rentalCharges');
    	$movie->distributerSeats = request('distributerSeats');
    	$movie->contractStartDate = request('contractStartDate');
    	$movie->actor = json_encode( request('actor') );
    	$movie->role = json_encode( request('role') );
    	$movie->poster = $filename;
    	$movie->synopsis = request('synopsis');
    	$movie->trailor = request('trailor');
    	$movie->status = request('status');
    	$movie->user_id = Auth::user()->id;

    	$movie->save();

    }

    public static function deleteMovie(Movie $movie){

        $m_id = ShowTime::where('movie_id', $movie->id)->get();

        if(count($m_id) <= 0){
            $upload_dir = base_path() . '/public/assets/images/uploads/';
        
            File::delete($upload_dir .'/'. $movie->poster);
            File::delete($upload_dir .'/m_'. $movie->poster);

            Movie::findOrFail($movie->id)->delete();
            return $msg = [ '0' => 'message', '1' => 'Delete Movie Sucessfully'];
        }else{
            return $msg = [ '0' => 'error', '1' => 'Movie has ShowTime'];
        }
        
    }

}
