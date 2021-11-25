<?php

namespace App\Http\Controllers\v1\Weixin;

use App\Http\Controllers\BaseController;

use App\Models\WxqyAuthCompany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;


class LoginController extends BaseController
{
    //用户登录
    public function userLogin()
    {
        $url_info = $_GET;
        $userInfo3rd = $this->getUserInfo3rd($url_info['code']);
        return $userInfo3rd;
    }


    //获取访问用户身份
    function getUserInfo3rd($code)
    {
        $s_a_t_info = $this->getSuiteAccessToken();
        $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证
        $base_url = env('QYWX_BASEURL', '');
        $url = $base_url . "service/getuserinfo3rd?suite_access_token=" . $suite_access_token . "&code=" . $code;
        return geturl($url);
    }

    //获取第三方应用凭证（suite_access_token）
    private function getSuiteAccessToken()
    {
        $base_url = env('QYWX_BASEURL', '');
        $url = $base_url . "service/get_suite_token";
        $suite_id = env('SUITEID', '');                            //应用id
        $suite_secret = env('SUITE_SECRET', '');                  //应用密码
        $suite_ticket = Cache::get('SUITEICKET');
        $data = ["suite_id" => $suite_id, "suite_secret" => $suite_secret, "suite_ticket" => $suite_ticket];
        return posturl($url, $data);
    }


}
