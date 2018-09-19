<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $fillable = [
        'user_id', 'menu_id', 'status'
    ];

    public function users(){
        return $this->belongsTo('App\Models\Permission','user_id');
    }
}
