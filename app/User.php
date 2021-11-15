<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;


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

    public static function getRules()
    {
        $roles = array(
            "kasir" => "kasir",
            "manager" => "manager",
            'resepsionist' => 'resepsionist'
        );
        return $roles;
    }

    public static function create($data)
    {
        $created_at = Carbon::now()->format('Y-m-d H:i:s');

        $additional = array(
            'created_at' => $created_at,
            'updated_at' => $created_at,
        );
        $data = array_merge($data, $additional);

        DB::table('users')->insert($data);
    }

    public function absents()
    {
        return $this->hasMany(Absent::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function get_access_token($type)
    {
        // delete old token first token
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        // then create new token
        $user = User::find(Auth::user()->id);
        $createToken = $user->createToken($type);
        $token =  $createToken->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $access_token = $createToken->accessToken;
        return $access_token;
    }
}
