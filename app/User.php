<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Image;

//class User extends Model implements AuthenticatableContract {
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    //use Authenticatable;

    protected $fillable = [
        'first_name',
        'last_name',
        'unit_id',
        'gate_code',
        'resident_status_id',
        'mobile_phone',
        'home_phone',
        'work_phone',
        'email',
        'password',
        'profile_picture'
    ];

    function approve_account()
    {

    }

    function deactivate_account()
    {

    }

    function make_admin()
    {

    }

    function remove_admin()
    {

    }

    function update_unit_id()
    {

    }

    public function resident_status()
    {
        return $this->belongsTo(ResidentStatus::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public static function createThumbnail(UploadedFile $profile_picture, $UserID = null)
    {
        if (is_null($UserID))
        {
            $UserID = DB::select("SHOW TABLE STATUS LIKE 'users'")[0]->Auto_increment;
        }


        $profile_path = "img/headshot_uploads/" . $UserID . "." . $profile_picture->getClientOriginalExtension();

        $image = Image::make($profile_picture);

        $image->orientate();

        $image->fit(150, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($profile_path);

        return $profile_path;
    }
}
