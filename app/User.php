<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use TCG\Voyager\Models\DataRow;
use App\Traits\LockableTrait;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable,LockableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function userTemplateColor()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function userColor()
    {
        return Auth::user()->user_color;
    }



    public function userColorList()
    {
        $drink = DataRow::where('field', 'user_color')->first();

        if($drink) {
            $drink = $drink->attributesToArray();
        }
        return $drink;
    }

    public function registration_date()
    {
        $registar_date = Auth::user()->created_at;
        $registar_date = date('M. Y', strtotime($registar_date));
        return $registar_date;
    }

    public function sendEmail($user)
    {
        event(new UserAdded($user));
    }
}
