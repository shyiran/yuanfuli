<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $dateFormat = 'U';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'avatar',
        'create_ip',
        'last_login_ip',
        'nickname',
        'user_status',
        'last_login_time',
        'open_userid',
        'real_name',
        'email',
        'password',
        'rea_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //根据ID获取用户基本信息
    public static function getUserInfoByID(int $id){
        return self::find($id);
    }
    //根据OpenUseId获取用户基本信息
    public static function getUserInfoByOpenUseId(string $open_userid){
        return self::where('open_userid', $open_userid)->first();
    }


}
