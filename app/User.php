<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Models\Distributer;
use Auth;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Permission;

class User extends Authenticatable
{
    use Notifiable;

    public function permissions(){
        return $this->belongsTo('App\Models\Permission','user_id');
    }

    public function bookings(){
        return $this->hasMany('App\Models\Booking');
    }

    public function printed_tickets(){
        return $this->hasMany('App\Models\PrintedTicket');
    }

    public function concession_details(){
        return $this->hasMany('App\Models\ConcessionDetail');
    }

    public function concession_masters(){
        return $this->hasMany('App\Models\ConcessionMaster');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'username', 'email', 'password', 'phoneNo', 'city', 'salary', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function createUser(Request $request){
        $upload_dir = base_path() . '/public/assets/images/uploads/';

        $checkUser = User::where('username', $request->username)->pluck('id')->first();
        
        if($checkUser != null){
            return 'Username Already Exist';
        }
        
        $file = $request->file('image');
        $filename = mt_rand(100,5000).$file->getClientOriginalName();
        $image = Image::make($file)->resize(300, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $image->save($upload_dir.'m_'.$filename);
        $file->move($upload_dir, $filename);

        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phoneNo = $request->phoneNo;
        $user->image = $filename;
        $user->city = $request->city;
        $user->salary = $request->salary;

        $user->save();

        $id = User::where('username', $request->username)->pluck('id')->first();

        foreach ($request->permission as $permission) {
            $per = new Permission;
            $per->user_id = $id;
            $per->menu_id = $permission;
            $per->status = 1;
            $per->save();
        }

    }

    public static function updateUser(Request $request, User $user){
        $upload_dir = base_path() . '/public/assets/images/uploads/';

        if($request->hasFile('image')){
            File::delete($upload_dir .'/'. $user->image);
            File::delete($upload_dir .'/m_'. $user->image);
            $file = $request->file('image');
            $filename = mt_rand(100,5000).$file->getClientOriginalName();
            $image = Image::make($file)->resize(300, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $image->save($upload_dir.'m_'.$filename);
            $file->move($upload_dir, $filename);
        }else{
            $filename = $user->image;
        }

        $user = User::findOrFail($user->id);
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->username = $request->username;
        if($request->password != null){ $user->password = bcrypt($request->password); };
        $user->phoneNo = $request->phoneNo;
        $user->image = $filename;
        $user->city = $request->city;
        $user->salary = $request->salary;

        $user->save();

        Permission::where('user_id', $user->id)->delete();
        foreach ($request->permission as $permission) {
            $per = new Permission;
            $per->user_id = $user->id;
            $per->menu_id = $permission;
            $per->status = 1;
            $per->save();
        }

    }

    public static function deleteUser(User $user){
        $upload_dir = base_path() . '/public/assets/images/uploads/';
        
        File::delete($upload_dir .'/'. $user->image);
        File::delete($upload_dir .'/m_'. $user->image);

        User::findOrFail($user->id)->delete();
        Permission::where('user_id', $user->id)->delete();
    }

}
