<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Menu;
use App\Models\Permission;

class UserController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPermission')->except('store' , 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::all();
        return view('pages.admin.user.viewUsers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::orderBy('sort_order')->get();
        return view('pages.admin.user.addUser', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phoneNo' => 'required',
            'city' => 'required',
            'salary' => 'required',
        ]);

        $error = User::createUser($request);
        if($error != null){
             return redirect('user/create')->withErrors($error);
         }else{
            return redirect('user')->withMessage('Added User Sucessfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->with('permissions')->get()->first();
        $permissions = Permission::where('user_id', $id)->with('users', 'menus')->get();
        $menus_id = []; 
        foreach($permissions as $per){
           array_push($menus_id, $per->menus->id);
        }
        //dd($menus_id);
        $menus = Menu::orderBy('sort_order')->get();
        return view('pages.admin.user.editUser', compact('menus', 'user', 'menus_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'username' => 'required',
            'phoneNo' => 'required',
            'city' => 'required',
            'salary' => 'required',
        ]);

       User::updateUser($request, $user);
       return redirect('user')->withMessage('Added User Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect('/user')->withMessage('Deleted User Sucessfully');
    }
}
