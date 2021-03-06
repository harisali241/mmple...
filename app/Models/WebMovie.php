<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Models\Batch;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class WebMovie extends Model
{
    protected $fillable = [
        'title', 'movie_id', 'distributer_id', 'rating', 'releaseDate ', 'genre', 'duration', 'actor', 'role', 'poster', 'synopsis', 'trailor', 'status'
    ];

    public function web_show_times(){
        return $this->hasMany('App\Models\WebShowTime','movie_id');
    }

    public static function createMovie($batch_id, $movie){
        if(is_connected()){
        	$db = DB::connection('mysql2')
	    	->insert("INSERT INTO web_movies (movie_id, title, rating, releaseDate, genre, duration, actor, role, poster, synopsis, trailor, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $movie->id,
	    		$movie->title,
	    		$movie->rating,
	    		$movie->releaseDate,
	    		$movie->genre,
	    		$movie->duration,
	    		$movie->actor,
	    		$movie->role,
	    		$movie->poster,
	    		$movie->synopsis,
	    		$movie->trailor,
	    		$movie->status,
	    		date('Y-m-d H:i:s'),
	    	]);

            $sourceFilePath = public_path()."/assets/images/uploads/".$movie->poster;
            $destinationPath = "./../web_mmplex/public/uploads/".$movie->poster;
            $success = File::copy($sourceFilePath,$destinationPath);

            Batch::completeBatch($batch_id);
        }
    }

    public static function updateMovie($batch_id, $movie){
        if(is_connected()){
            $poster = DB::connection('mysql2')
            ->select("SELECT poster FROM web_movies WHERE movie_id = '".$movie->id."'");
            
            $db = DB::connection('mysql2')
            ->update("UPDATE web_movies SET title = '".$movie->title."', rating = '".$movie->rating."', releaseDate = '".$movie->releaseDate."', genre = '".$movie->genre."', duration = '".$movie->duration."', actor = '".$movie->actor."', role = '".$movie->role."', poster = '".$movie->poster."', synopsis = '".$movie->synopsis."', trailor = '".$movie->trailor."', status = '".$movie->status."', updated_at = '".date('Y-m-d H:i:s')."' WHERE movie_id = '".$movie->id."' ");
            
            if(file_exists("./../web_mmplex/public/uploads/".$poster[0]->poster)){
                File::delete("./../web_mmplex/public/uploads/".$poster[0]->poster);
            }
            $sourceFilePath = public_path()."/assets/images/uploads/".$movie->poster;
            $destinationPath = "./../web_mmplex/public/uploads/".$movie->poster;
            $success = File::copy($sourceFilePath,$destinationPath);

            Batch::completeBatch($batch_id);
        }
    }

    public static function deleteMovie($batch_id, $movie_id){
        if(is_connected()){
            $db = DB::connection('mysql2')
            ->delete("DELETE FROM web_movies WHERE movie_id = ?", [$movie_id]);
            Batch::completeBatch($batch_id);
        }
    }

}
