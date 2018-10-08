<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Batch;

class WebTicket extends Model
{
   	protected $fillable = [
        'ticket_id', 'title', 'description', 'class', 'adultPrice ', 'childPrice', 'isChild', 'type'
    ];

    protected $connection = 'mysql2';


    public static function createTicket($batch_id, $ticket){
        if(is_connected()){
        	$db = DB::connection('mysql2')
	    	->insert("INSERT INTO web_tickets (ticket_id, title, description, class, adultPrice , childPrice, isChild, type, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $ticket->id,
                $ticket->title,
                $ticket->description,
                $ticket->class,
                $ticket->adultPrice ,
                $ticket->childPrice,
                $ticket->isChild,
                $ticket->type,
	    		date('Y-m-d H:i:s'),
	    	]);
            Batch::completeBatch($batch_id);
        }
    }

    public static function updateTicket($batch_id, $ticket){
        if(is_connected()){
            $db = DB::connection('mysql2')
            ->update("UPDATE web_tickets SET title = '".$ticket->title."' , description = '".$ticket->description."' , class = '".$ticket->class."' , adultPrice  = '".$ticket->adultPrice."' , childPrice = '".$ticket->childPrice."' , isChild = '".$ticket->isChild."' , type = '".$ticket->type."' , updated_at = '".date('Y-m-d H:i:s')."' WHERE ticket_id = '".$ticket->id."' ");
            Batch::completeBatch($batch_id);
        }
    }

    public static function deleteTicket($batch_id, $ticket_id){
        if(is_connected()){
            $db = DB::connection('mysql2')
            ->delete("DELETE FROM web_tickets WHERE ticket_id = ?", [$ticket_id]);
            Batch::completeBatch($batch_id);
        }
    }
}
