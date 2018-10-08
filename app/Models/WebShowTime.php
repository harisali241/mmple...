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
        'show_time_id', 'movie_id', 'screen_id', 'ticket_id', 'date', 'time', 'day', 'dateTime', 'endDateTime', 'complimentrySeat', 'key', 'sale'
    ];

    public function web_movies(){
        return $this->belongsTo('App\Models\WebMovie','web_movie_id');
    }
    public function web_screens(){
        return $this->belongsTo('App\Models\WebScreen', 'web_screen_id');
    }

    public static function createShowTime($batch_id, $showTime){
        if(is_connected()){
      //   	$db = DB::connection('mysql2')
	    	// ->insert("INSERT INTO web_show_times (show_time_id , web_movie_id, web_screen_id, web_ticket_id, date, time, day, dateTime, endDateTime, complimentrySeat, `key`, sale, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
	    	// 	$showTime->id,
      //           $showTime->movie_id,
      //           $showTime->screen_id,
      //           $showTime->ticket_id,
      //           $showTime->date,
      //           $showTime->time,
      //           $showTime->day,
      //           $showTime->dateTime,
      //           $showTime->endDateTime,
      //           $showTime->complimentrySeat,
      //           $showTime->key,
      //           $showTime->sale,
	    	// 	date('Y-m-d H:i:s'),
	    	// ]);

            $web_show = new WebShowTime;
            $web_show->show_time_id = $showTime->id;
            $web_show->web_movie_id = $showTime->movie_id;
            $web_show->web_screen_id = $showTime->screen_id;
            $web_show->web_ticket_id = $showTime->ticket_id;
            $web_show->date = $showTime->date;
            $web_show->time = $showTime->time;
            $web_show->day = $showTime->day;
            $web_show->dateTime = $showTime->dateTime;
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
            $db = DB::connection('mysql2')
            ->update("UPDATE web_show_times SET web_movie_id = '".$showTime->movie_id."' , web_screen_id = '".$showTime->screen_id."' , web_ticket_id = '".$showTime->ticket_id."' , date = '".$showTime->date."' , time = '".$showTime->time."' , day = '".$showTime->day."' , dateTime = '".$showTime->dateTime."' , endDateTime = '".$showTime->endDateTime."' , complimentrySeat = '".$showTime->complimentrySeat."' , `key` = '".$showTime->key."' , sale = '".$showTime->sale."' , updated_at = '".date('Y-m-d H:i:s')."' WHERE show_time_id = '".$showTime->id."' ");
            Batch::completeBatch($batch_id);
        }
    }

    public static function deleteShowTime($batch_id, $showTime_id){
        if(is_connected()){
            $db = DB::connection('mysql2')
            ->delete("DELETE FROM web_show_times WHERE show_time_id = ?", [$showTime_id]);
            Batch::completeBatch($batch_id);
        }
    }
}
