<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\Promise\issettled;

class WxqyAuthGroup extends Model
{
    protected $table = "wxqy_auth_group";
    protected $dateFormat = 'U';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $fillable = [
        'corpid',
        'is_system',
        'group_name',
        'rules'
    ];

    //获取默认权限组ID
    public static function getDefaultGroupID($corpid, $defaultName = '公关')
    {
        $data = self::where(['corpid'=>$corpid,'group_name'=>$defaultName])->orderby('id', 'DESC')->first();
        return $data['id'];
    }

    //根据corpid查询企业权限组信息，默认每个企业最少有2个权限组，一个是最高权限(管理员)，一个是最低权限(公关)
    public static function getAuthGroupInfoByCorpID($corpid)
    {
        $data = self::where('corpid', $corpid)->orderby('id', 'DESC')->get();
        return $data;
    }

    //插入数据
    public static function InSertOne($data)
    {
        if (isset($data['corpid'])) {
            $add_data['corpid'] = $data['corpid'];
        }
        if (isset($data['is_system'])) {
            $add_data['is_system'] = $data['is_system'];
        }
        if (isset($data['group_name'])) {
            $add_data['group_name'] = $data['group_name'];
        }
        if (isset($data['rules'])) {
            $add_data['rules'] = $data['rules'];
        }
        if ($add_data) {
            return self::insertGetId($add_data);//返回插入ID
        }
    }
}
