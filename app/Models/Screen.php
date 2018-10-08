<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class Screen extends Model
{
    protected $fillable = [
        'name', 'totalSeats', 'houseSeats', 'wheelChairSeats', 'image', 'rows', 'columns'
    ];
    
    public function printed_tickets(){
        return $this->hasMany('App\Models\PrintedTicket');
    }
    public function show_times(){
        return $this->hasMany('App\Models\ShowTime','screen_id');
    }
    public function bookings(){
        return $this->hasMany('App\Models\Booking', 'screen_id');
    }

    public static function createScreen(Request $request){

    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        if($request->hasFile('image')){
            $file = $request->file('image');
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


    	$screen = new Screen;

    	$screen->name = request('name');
    	$screen->totalSeats = request('totalSeats');
    	$screen->houseSeats = request('houseSeats');
    	$screen->wheelChairSeats = request('wheelChairSeats');
    	$screen->image = $filename;
    	$screen->rows = json_encode( request('rows') );
    	$screen->columns = json_encode( request('columns') );

    	$screen->save();

        $id = Screen::where('name', request('name'))
                    ->orderBy('created_at', 'desc')
                    ->pluck('id')->first();
        return $id;

    }

    public static function updateScreen(Request $request, Screen $screen){

    	$upload_dir = base_path() . '/public/assets/images/uploads/';
        
        if($request->hasFile('image')){
        	File::delete($upload_dir .'/'. $screen->image);
            File::delete($upload_dir .'/m_'. $screen->image);
	        $file = $request->file('image');
	        $filename = mt_rand(100,5000).$file->getClientOriginalName();
            $image = Image::make($file)->resize(300, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $image->save($upload_dir.'m_'.$filename);
	        $file->move($upload_dir, $filename);
   		}else{
   			$filename = $screen->image;
   		}

    	$screen = Screen::findOrFail($screen->id);

    	$screen->name = request('name');
    	$screen->totalSeats = request('totalSeats');
    	$screen->houseSeats = request('houseSeats');
    	$screen->wheelChairSeats = request('wheelChairSeats');
    	$screen->image = $filename;
    	$screen->rows = json_encode( request('rows') );
    	$screen->columns = json_encode( request('columns') );

    	$screen->save();

        return $screen->id;
    }

}
