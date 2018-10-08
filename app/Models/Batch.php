<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WebMovie;
use App\Models\WebTicket;
use App\Models\WebScreen;
use App\Models\WebShowTime;
use App\Models\Movie;
use App\Models\Ticket;
use App\Models\Screen;
use App\Models\ShowTime;

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
                if($batch->type == 'store'){
                    if($batch->table_name == 'web_movies'){
                        $movie = Movie::where('id', $batch->col_id)->first();
                        WebMovie::createMovie($batch->id, $movie);
                    }elseif($batch->table_name == 'web_screens'){
                        $screen = Screen::where('id', $batch->col_id)->first();
                        WebScreen::createScreen($batch->id, $screen);
                    }elseif($batch->table_name == 'web_tickets'){
                        $ticket = Ticket::where('id', $batch->col_id)->first();
                        WebTicket::createTicket($batch->id, $ticket);
                    }elseif($batch->table_name == 'web_show_times'){
                        $showTime = ShowTime::where('id', $batch->col_id)->first();
                        WebShowTime::createShowTime($batch->id, $showTime);
                    }
                }elseif($batch->type == 'update'){
                    if($batch->table_name == 'web_movies'){
                        $movie = Movie::where('id', $batch->col_id)->first();
                        WebMovie::updateMovie($batch->id, $movie);
                    }elseif($batch->table_name == 'web_screens'){
                        $screen = Screen::where('id', $batch->col_id)->first();
                        WebScreen::updateScreen($batch->id, $screen);
                    }elseif($batch->table_name == 'web_tickets'){
                        $ticket = Ticket::where('id', $batch->col_id)->first();
                        WebTicket::updateTicket($batch->id, $ticket);
                    }elseif($batch->table_name == 'web_show_times'){
                        $showTime = ShowTime::where('id', $batch->col_id)->first();
                        WebShowTime::updateShowTime($batch->id, $showTime);
                    }
                }elseif($batch->type == 'delete'){
                    if($batch->table_name == 'web_movies'){
                        WebMovie::deleteMovie($batch->id, $batch->col_id);
                    }elseif($batch->table_name == 'web_screens'){
                        WebScreen::deleteScreen($batch->id, $batch->col_id);
                    }elseif($batch->table_name == 'web_tickets'){
                        WebTicket::deleteTicket($batch->id, $batch->col_id);
                    }elseif($batch->table_name == 'web_show_times'){
                        WebShowTime::deleteShowTime($batch->id, $batch->col_id);
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
