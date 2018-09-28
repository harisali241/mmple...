<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'path', 'route', 'parent_id', 'type_id', 'sort_order', 'arrange_order', 'status'
    ];

    public function permissions(){
    	return $this->belongsTo('App\Models\Permission','menu_id');
    }
}
