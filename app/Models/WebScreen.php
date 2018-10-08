<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Batch;
use DB;

class WebScreen extends Model
{
    
	protected $fillable = [
        'name' , 'screen_id', 'totalSeats', 'houseSeats', 'wheelChairSeats', 'image', 'rows', 'columns'
    ];

    public function web_show_times(){
        return $this->hasMany('App\Models\WebShowTime', 'web_screen_id');
    }

    public static function createScreen($batch_id, $screen){
    	if(is_connected()){
        	$db = DB::connection('mysql2')
	    	->insert("INSERT INTO web_screens (screen_id, name, totalSeats, houseSeats, wheelChairSeats, image, rows, columns, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
	    		$screen->id,
                $screen->name,
                $screen->totalSeats,
                $screen->houseSeats,
                $screen->wheelChairSeats,
                $screen->image,
                $screen->rows,
                $screen->columns,
                $screen->created_at,
	    		date('Y-m-d H:i:s'),
	    	]);
            Batch::completeBatch($batch_id);
        }
    }

    public static function updateScreen($batch_id, $screen){
        if(is_connected()){
            $db = DB::connection('mysql2')
            ->update("UPDATE web_screens SET name = '".$screen->name."' , totalSeats = '".$screen->totalSeats."' , houseSeats = '".$screen->houseSeats."' , wheelChairSeats = '".$screen->wheelChairSeats."' , image = '".$screen->image."' , rows = '".$screen->rows."' , columns = '".$screen->columns."' , updated_at = '".date('Y-m-d H:i:s')."' WHERE screen_id = '".$screen->id."' ");
            Batch::completeBatch($batch_id);
        }
    }

    public static function deleteScreen($batch_id, $screen_id){
        if(is_connected()){
            $db = DB::connection('mysql2')
            ->delete("DELETE FROM web_screens WHERE screen_id = ?", [$screen_id]);
            Batch::completeBatch($batch_id);
        }
    }
}
