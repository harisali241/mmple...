<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Batch;
class WebShowTime extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'web_show_times';

    protected $fillable = [
        'show_time_id', 'movie_id', 'screen_id', 'ticket_id', 'show_date', 'show_time', 'day', 'show_dateTime', 'endDateTime', 'complimentrySeat', 'key', 'sale'
    ];

    public function web_movies(){
        return $this->belongsTo('App\Models\WebMovie', 'movie_id');
    }
    public function web_screens(){
        return $this->belongsTo('App\Models\WebScreen', 'screen_id');
    }

    public static function createShowTime($batch_id, $showTime){
        if(is_connected()){

            $web_show = new WebShowTime;
            $web_show->show_time_id = $showTime->id;
            $web_show->movie_id = $showTime->movie_id;
            $web_show->screen_id = $showTime->screen_id;
            $web_show->ticket_id = $showTime->ticket_id;
            $web_show->show_date = $showTime->date;
            $web_show->show_time = $showTime->time;
            $web_show->day = $showTime->day;
            $web_show->show_dateTime = $showTime->dateTime;
            $web_show->endDateTime = $showTime->endDateTime;
            $web_show->complimentrySeat = $showTime->complimentrySeat;
            $web_show->key = $showTime->key;
            $web_show->sale = $showTime->sale;
            $web_show->save();

            Batch::completeBatch($batch_id);
        }
    }

    public static function updateShowTime($batch_id, $showTime){
        if(is_connected()){

            $id = WebShowTime::where('show_time_id', $showTime->id)->pluck('id')->first();

            $web_show = WebShowTime::findOrFail($id);
            $web_show->show_time_id = $showTime->id;
            $web_show->movie_id = $showTime->movie_id;
            $web_show->screen_id = $showTime->screen_id;
            $web_show->ticket_id = $showTime->ticket_id;
            $web_show->show_date = $showTime->date;
            $web_show->show_time = $showTime->time;
            $web_show->day = $showTime->day;
            $web_show->show_dateTime = $showTime->dateTime;
            $web_show->endDateTime = $showTime->endDateTime;
            $web_show->complimentrySeat = $showTime->complimentrySeat;
            $web_show->key = $showTime->key;
            $web_show->sale = $showTime->sale;
            $web_show->save();

            Batch::completeBatch($batch_id);
        }
    }

    public static function deleteShowTime($batch_id, $showTime_id){
        if(is_connected()){
            $id = WebShowTime::where('show_time_id', $showTime_id)->pluck('id')->first();
            $web_show = WebShowTime::findOrFail($id)->delete();
            Batch::completeBatch($batch_id);
        }
    }
}
