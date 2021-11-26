<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function GuzzleHttp\Promise\issettled;

class WxqyAuthCompany extends Model
{
    use HasFactory;

    protected $table = "wxqy_auth_company";
    protected $dateFormat = 'U';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $fillable = [
        'access_token',
        'create_time',
        'update_time',
        'sort',
        'status',
        'access_token',
        'permanent_code',
        'a_userid',
        'a_open_userid',
        'a_name',
        'a_avatar',
        'c_corpid',
        'c_corp_name',
        'c_corp_type',
        'c_corp_square_logo_url',
        'c_corp_user_max',
        'c_corp_full_name',
        'c_subject_type',
        'c_verified_end_time',
        'c_corp_wxqrcode',
        'c_corp_scale',
        'c_corp_industry',
        'c_corp_sub_industry',
        'aa_agent',
        'aa_agentid',
        'aa_name',
        'aa_square_logo_url',
        'aa_round_logo_url',
        'aa_auth_mode',
        'aa_is_customized_app',
        'aap_allow_user',
        'aap_extra_party',
        'aap_extra_user',
        'aap_extra_tag',
        'aap_level',
        'aas_corpid',
        'aap_allow_party',
        'aap_allow_tag',
    ];

    //根据corpid查询企业信息
    public static function getCompanyInfoByCorpID($corpid, $field_name = '')
    {
        $data = self::where('c_corpid', $corpid)->orderby('id', 'DESC')->first();
        if ($field_name) {
            return $data[$field_name];
        }
        return $data;
    }

    //插入数据
    public static function InSertOne($data)
    {
        if (isset($data['access_token'])) {
            $add_data['access_token'] = $data['access_token'];                                          //授权方（企业）access_token,最长为512字节
        }
        if (isset($data['permanent_code'])) {
            $add_data['permanent_code'] = $data['permanent_code'];                                      //企业微信永久授权码,最长为512字节
        }
        if (isset($data['auth_corp_info']['corpid'])) {
            $add_data['c_corpid'] = $data['auth_corp_info']['corpid'];                                  //授权方企业微信id
        }
        if (isset($data['auth_corp_info']['corp_name'])) {
            $add_data['c_corp_name'] = $data['auth_corp_info']['corp_name'];                            //授权方企业名称，即企业简称
        }
        if (isset($data['auth_corp_info']['corp_type'])) {
            $add_data['c_corp_type'] = $data['auth_corp_info']['corp_type'];                            //授权方企业类型，认证号：verified, 注册号：unverified
        }
        if (isset($data['auth_corp_info']['corp_square_logo_url'])) {
            $add_data['c_corp_square_logo_url'] = $data['auth_corp_info']['corp_square_logo_url'];      //授权方企业方形头像
        }
        if (isset($data['auth_corp_info']['corp_user_max'])) {
            $add_data['c_corp_user_max'] = $data['auth_corp_info']['corp_user_max'];                    //授权方企业用户规模
        }
        if (isset($data['auth_corp_info']['corp_full_name'])) {
            $add_data['c_corp_full_name'] = $data['auth_corp_info']['corp_full_name'];                //授权方企业的主体名称(仅认证或验证过的企业有)，即企业全称。
        }
        if (isset($data['auth_corp_info']['subject_type'])) {
            $add_data['c_subject_type'] = $data['auth_corp_info']['subject_type'];                        //企业类型，1. 企业; 2. 政府以及事业单位; 3. 其他组织, 4.团队号
        }
        if (isset($data['auth_corp_info']['verified_end_time'])) {
            $add_data['c_verified_end_time'] = $data['auth_corp_info']['verified_end_time'];            //认证到期时间
        }
        if (isset($data['uth_corp_info']['corp_wxqrcode'])) {
            $add_data['c_corp_wxqrcode'] = $data['uth_corp_info']['corp_wxqrcode'];                     //授权企业在微工作台（原企业号）的二维码，可用于关注微工作台
        }
        if (isset($data['auth_corp_info']['corp_scale'])) {
            $add_data['c_corp_scale'] = $data['auth_corp_info']['corp_scale'];                        //企业规模。当企业未设置该属性时，值为空
        }
        if (isset($data['auth_corp_info']['corp_industry'])) {
            $add_data['c_corp_industry'] = $data['auth_corp_info']['corp_industry'];                    //企业所属行业。当企业未设置该属性时，值为空
        }
        if (isset($data['auth_corp_info']['corp_sub_industry'])) {
            $add_data['c_corp_sub_industry'] = $data['auth_corp_info']['corp_sub_industry'];            //企业所属子行业。当企业未设置该属性时，值为空
        }
        if (isset($data['auth_info']['agent'])) {
            $add_data['aa_auth_info'] = $data['auth_info']['agent'];                                  //授权的应用信息，注意是一个数组，但仅旧的多应用套件授权时会返回多个agent，对新的单应用授权，永远只返回一个agent
        }
        if (isset($data['auth_info']['agent']['agentid'])) {
            $add_data['aa_agentid'] = $data['auth_info']['agent']['agentid'];                        //授权方应用id
        }
        if (isset($data['auth_info']['agent']['name'])) {
            $add_data['aa_name'] = $data['auth_info']['agent']['name'];                                //授权方应用名字
        }
        if (isset($data['auth_info']['agent']['square_logo_url'])) {
            $add_data['aa_square_logo_url'] = $data['auth_info']['agent']['square_logo_url'];        //授权方应用方形头像
        }
        if (isset($data['auth_info']['agent']['round_logo_url'])) {
            $add_data['aa_round_logo_url'] = $data['auth_info']['agent']['round_logo_url'];            //授权方应用圆形头像
        }
        if (isset($data['auth_info']['agent']['auth_mode'])) {
            $add_data['aa_auth_mode'] = $data['auth_info']['agent']['auth_mode'];                    //授权模式，0为管理员授权；1为成员授权
        }
        if (isset($data['auth_info']['agent']['is_customized_app'])) {
            $add_data['aa_is_customized_app'] = $data['auth_info']['agent']['is_customized_app'];    //是否为代开发自建应用
        }
        if (isset($data['auth_info']['agent']['privilege']['allow_party'])) {
            $add_data['aap_allow_party'] = $data['auth_info']['agent']['privilege']['allow_party'];    //应用可见范围（部门）
        }
        if (isset($data['auth_info']['agent']['privilege']['allow_tag'])) {
            $add_data['aap_allow_tag'] = $data['auth_info']['agent']['privilege']['allow_tag'];        //应用可见范围（标签）
        }
        if (isset($data['auth_info']['agent']['privilege']['allow_user'])) {
            $add_data['aap_allow_user'] = $data['auth_info']['agent']['privilege']['allow_user'];    //应用可见范围（成员）
        }
        if (isset($data['auth_info']['agent']['privilege']['extra_party'])) {
            $add_data['aap_extra_party'] = $data['auth_info']['agent']['privilege']['extra_party'];    //额外通讯录（部门）
        }
        if (isset($data['auth_info']['agent']['privilege']['extra_user'])) {
            $add_data['aap_extra_user'] = $data['auth_info']['agent']['privilege']['extra_user'];    //额外通讯录（成员）
        }
        if (isset($data['auth_info']['agent']['privilege']['extra_tag'])) {
            $add_data['aap_extra_tag'] = $data['auth_info']['agent']['privilege']['extra_tag'];        //额外通讯录（标签）
        }
        if (isset($data['auth_info']['agent']['privilege']['level'])) {
            $add_data['aap_level'] = $data['auth_info']['agent']['privilege']['level'];                //权限等级。1:通讯录基本信息只读2:通讯录全部信息只读3:通讯录全部信息读写4:单个基本信息只读5:通讯录全部信息只写
        }
        if (isset($data['auth_info']['agent']['shared_from']['corpid'])) {
            $add_data['aas.corpid'] = $data['auth_info']['agent']['shared_from']['corpid'];            //共享了应用的互联企业信息，仅当由互联的企业共享应用触发的安装时才返回
        }
        if (isset($data['auth_user_info']['userid'])) {
            $add_data['a_userid'] = $data['auth_user_info']['userid'];
        }
        if (isset($data['auth_user_info']['open_userid'])) {
            $add_data['a_open_userid'] = $data['auth_user_info']['open_userid'];
        }
        if (isset($data['auth_user_info']['name'])) {
            $add_data['a_name'] = $data['auth_user_info']['name'];
        }
        if (isset($data['auth_user_info']['avatar'])) {
            $add_data['a_avatar'] = $data['auth_user_info']['avatar'];
        }
        if (isset($data['suite_access_token'])) {
            $add_data['suite_access_token'] = $data['suite_access_token'];
        }
        if($add_data) {
            self::create($add_data);//返回插入数据，含ID
        }
    }
}
