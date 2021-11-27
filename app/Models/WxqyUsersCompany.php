<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\Promise\issettled;

class WxqyUsersCompany extends Model
{
    protected $table = "wxqy_users_company";
    protected $dateFormat = 'U';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $fillable = [
        'corpid',
        'group_id',
        'user_id'
    ];
    //根据user_id该用户所在的权限组ID（一位用户只能在一家企业的一个权限组）
    public static function getUsersWithCompany($corpid, $user_id)
    {
        $data = self::where(['corpid'=> $corpid,'user_id'=>$user_id])->first();
        if($data){
            return $data['group_id'];
        }
        return '';
    }
    //插入数据
    public static function InSertOne($data)
    {
        if (isset($data['corpid'])) {
            $add_data['corpid'] = $data['corpid'];
        }
        if (isset($data['group_id'])) {
            $add_data['group_id'] = $data['group_id'];
        }
        if (isset($data['user_id'])) {
            $add_data['user_id'] = $data['user_id'];
        }
        if($add_data){
            self::create($add_data);//返回插入数据，含ID
        }
    }
}
