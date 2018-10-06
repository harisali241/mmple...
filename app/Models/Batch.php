<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WebMovie;
use App\Models\Movie;

class Batch extends Model
{
    protected $fillable = [
        'table_name', 'col_id', 'status', 'type'
    ];

    public static function createBatch($id, $tb_name, $type){
    	$batch = new Batch;
    	$batch->table_name = $tb_name;
    	$batch->col_id = $id;
    	$batch->type = $type;
    	$batch->status = 0;
    	$batch->save();
    }

    public static function runBatch(){
    	if(is_connected()){
    		$batches = Batch::where('status', 0)->get();
    		foreach($batches as $batch){
    			if($batch->table_name == 'web_movies'){
    				if($batch->type == 'store'){
    					$movie = Movie::where('id', $batch->col_id)->first();
    					WebMovie::createMovie($batch->id, $movie);
    				}elseif($batch->type == 'update'){
    					$movie = Movie::where('id', $batch->col_id)->first();
    					WebMovie::updateMovie($batch->id, $movie);
    				}elseif($batch->type == 'delete'){
    					WebMovie::deleteMovie($batch->id, $batch->col_id);
    				}
    			}
    		}
    	}
    }

    public static function completeBatch($id){
    	$batch = Batch::findOrFail($id);
        $batch->status = 1;
        $batch->save();
    }
}
