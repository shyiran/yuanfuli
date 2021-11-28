<?php

namespace App\Http\Controllers\v1\Weixin;

use App\Http\Controllers\BaseController;
use App\Models\WxqyAuthCompany;
use App\Models\User;
use App\Models\WxqyAuthGroup;
use App\Models\WxqyUsersCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends BaseController
{
    //用户扫描登录
    public function userLogin(Request $request)
    {
        $url_info = $_GET;
        if (!$url_info) {
            /*$hhhhhh = User::insertGetId([
                'email' => "asc@lanxx.club",
                'user_status' => '1',
                'open_userid' => '24bffbgfngn',
                'nickname' => '昵称',
                'last_login_time' => time(),
                'last_login_ip' => $request->getClientIp(),
                'create_ip' => $request->getClientIp(),
                'password' => md5(env('USER_DEF1AULT_PSW', 'LANXX123lanxx'))
            ]);

            return $hhhhhh;*/
            /*  $user = User::getUserInfoByID('2');
              //return $user;
           if(!$this_userinfo = User::getUserInfoByOpenUseId('scscsc')){

           }*/
            //return $this->response->error('你不属于任何企业，请加入一个企业后再进行操作.', 404);
            // return $this->response->json(["ss"=>"sscscsc"]);
            //$data["username"]="test001@qq.com";
            //$data["password"]="123456";
            //$res_dl= posturl('http://test.lanxx.club/api/v1/user/login',$data);
            //return $res_dl['data']['token'];
            //return $res_dl['code'];
            //检查企业信息是否存在
            //$thisAuthompany = WxqyAuthCompany::getCompanyInfoByCorpID('ww5a8c8cb36455ba7a', 'c_corp_industry');
            //$add_data['auth_corp_info']['corpid'] = "SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS";
            //return WxqyAuthCompany::InSertOne($add_data);
            //return $thisAuthompany;
            //检查权限组是否存在
            // $thisAuthGroup = WxqyAuthGroup::getAuthGroupInfoByCorpID("ww5a8c8cb36455ba7a");
            //if (!count($thisAuthGroup)) {
            // WxqyAuthGroup::InSertOne(array("corpid" => "1", "is_system" => "1", "group_name" => "scscsc", "rules" => "最少"));
            // } else {
            //     return "DDDDDDDD";
            // }
            //return $thisAuthGroup;
            $thisGroupId = WxqyUsersCompany::getUsersWithCompany('ww66372d7b5a8e2455', '37');
            return $thisGroupId;
        } else {
            $userInfo3rd = $this->getUserInfo3rd($url_info['code']);
            if (!$userInfo3rd['CorpId']) {
                return $this->response->error('你不属于任何企业，请加入一个企业后再进行操作.', 900);
            } else {
                //检查用户信息在USER表是否已经存在
                $thisUserinfo = User::getUserInfoByOpenUseId($userInfo3rd['open_userid']);
                $def_email = $userInfo3rd['open_userid'] . "@lanxx.club";
                //如果用户不存在，则添加
                if (!$thisUserinfo) {
                    //获取用户详细信息，仅多了性别，头像
                    if(isset($userInfo3rd['user_ticket'])){
                        $userdetail3rd = $this->getuserdetail3rd($userInfo3rd['user_ticket']);
                    }else{
                        $userdetail3rd=array();
                    }
                    if(count($userdetail3rd)){
                        $gender = $userdetail3rd['gender'];
                    }else{
                        $gender = 0;
                    }
                    if(count($userdetail3rd)){
                        $avatar=$userdetail3rd['avatar'];
                    }else{
                        $avatar='';
                    }
                    //默认用户邮箱
                    //返回用户ID
                    $user_id = User::insertGetId([
                        'sex' => $gender,
                        'avatar' => $avatar,
                        'email' => $def_email,
                        'user_status' => '1',
                        'open_userid' => $userInfo3rd['open_userid'],
                        'nickname' => $userInfo3rd['UserId'],
                        'last_login_time' => time(),
                        'last_login_ip' => $request->getClientIp(),
                        'create_ip' => $request->getClientIp(),
                        'password' => md5(env('USER_DEFAULT_PSW', 'LANXX123lanxx'))
                    ]);
                    //检查该企业信息是否存在
                    $thisAuthompany = WxqyAuthCompany::getCompanyInfoByCorpID($userInfo3rd['CorpId']);
                    if (!$thisAuthompany) {
                        $add_data['auth_corp_info']['corpid'] = $userInfo3rd['CorpId'];
                        WxqyAuthCompany::InSertOne($add_data);
                    }
                    //检查该企业的权限组是否存在
                    $thisAuthGroup = WxqyAuthGroup::getAuthGroupInfoByCorpID($userInfo3rd['CorpId']);
                    $groupID = '';
                    if (!count($thisAuthGroup)) {
                        //添加公关总监权限组
                        WxqyAuthGroup::InSertOne(array("corpid" => $userInfo3rd['CorpId'], "is_system" => "1", "group_name" => "管理员", "rules" => "最少"));//TODO
                        //添加普通公关组PR
                        $groupID = WxqyAuthGroup::InSertOne(array("corpid" => $userInfo3rd['CorpId'], "is_system" => "1", "group_name" => "公关", "rules" => "最少"));//TODO
                    }
                    //添加用户和权限组的关系
                    $thisGroupId = WxqyUsersCompany::getUsersWithCompany($userInfo3rd['CorpId'], $user_id);
                    if (!$thisGroupId && $groupID) {
                        WxqyUsersCompany::InSertOne(array('corpid' => $userInfo3rd['CorpId'], 'group_id' => $groupID, 'user_id' => $user_id));
                    }
                }
            }
            //模拟用户登录
            $res_dl = posturl('http://test.lanxx.club/api/v1/user/login', array('username' => $def_email, 'password' => env('USER_DEFAULT_PSW')));
            //return $res_dl;
            if ($res_dl['code'] == 1) {
            //return  redirect("http://test.lanxx.club");
            //$qq_cs=array ( "Content-type:application/json;", "Accept:application/json", "token:{$res_dl['data']['token']}");
            //geturl("http://test.lanxx.club",$qq_cs);
                header("Location: http://test.lanxx.club?token={$res_dl['data']['token']}", TRUE, 302);
            }
        }
    }


    //获取服务商凭证 get_provider_token
    public function getProviderToken()
    {
        $base_url = env('QYWX_BASEURL', '');
        $url = $base_url . "service/get_provider_token";
        $corpId = env('CORPID', '');
        $provider_secret = env('PROVIDER_SECRET', '');
        $data = ["corpid" => $corpId, "provider_secret" => $provider_secret];
        return posturl($url, $data);
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
    //获取企业凭证get_corp_token 即获取企业的access_token
    //auth_corpid  授权方corpid
    //permanent_code 永久授权码，通过get_permanent_code获取
    private function getCorpToken($suite_access_token, $auth_corpid, $permanent_code)
    {
        $base_url = env('QYWX_BASEURL', '');
        $url = $base_url . "service/get_corp_token?suite_access_token=" . $suite_access_token;
        $data = ["auth_corpid" => $auth_corpid, "permanent_code" => $permanent_code];
        return posturl($url, $data);
    }
    //获取企业永久授权码
    //$auth_lin_code 临时授权码
    private function getPermanentCode($suite_access_token, $auth_lin_code)
    {
        $base_url = env('QYWX_BASEURL', '');
        $url = $base_url . "service/get_permanent_code?suite_access_token=" . $suite_access_token;
        $data = ["auth_code" => $auth_lin_code];
        return posturl($url, $data);
    }

    //设置授权配置set_session_info
    private function setSessionInfo($suite_access_token, $per_auth_code)
    {
        $base_url = env('QYWX_BASEURL', '');
        $url = $base_url . "service/set_session_info?suite_access_token=" . $suite_access_token;
        $data = ["pre_auth_code" => $per_auth_code, "session_info" => ["auth_type" => 1]];
        return posturl($url, $data);
    }

    //管理员扫描登录
    public function scanningQR()
    {
        $s_a_t_info = $this->getSuiteAccessToken();
        $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证
        $p_a_c_info = $this->getPreAuthCode($suite_access_token);
        $per_auth_code = $p_a_c_info['pre_auth_code'];//预授权码

        $res = $this->setSessionInfo($suite_access_token, $per_auth_code);
        if ($res['errcode'] == 0) {
            $suite_id = env('SUITEID', '');
            $durl = "api.lanxx.club";
            $state = env('STATE_WORD', '');
            $url = "https://open.work.weixin.qq.com/3rdapp/install?suite_id=" . $suite_id . "&pre_auth_code=" . $per_auth_code . "&redirect_uri=" . urlencode($durl) . "&state=" . $state;
            header("Location: $url", TRUE, 302);
        } else {
            return "设置授权配置错误";
        }
    }

    //获取预授权码get_pre_auth_code
    private function getPreAuthCode($suite_access_token)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_pre_auth_code?suite_access_token=" . $suite_access_token . "&debug=1";
        return geturl($url);
    }


    //获取suite_ticket（suite_ticket）
    public function getSuiteTicket()
    {
        $encodingAesKey = env('ENCODINGAESKEY', '');                    //应用的回调消息加解密参数，是AES密钥的Base64编码，用于解密回调消息内容对应的密文。
        $token = env('APPLICATION_TOKEN', '');                          //应用的TOKEN
        $corpId = env('CORPID', '');                                    //企业corpid
        $suiteId = env('SUITEID', '');                                  //应用id


        $sVerifyMsgSig = $_GET['msg_signature'] ?? 0;                               //这是回调过来企业微信给的数据
        $sVerifyTimeStamp = $_GET['timestamp'] ?? 0;                                //这是回调过来企业微信给的数据
        $sVerifyNonce = $_GET['nonce'] ?? 0;                                        //这是回调过来企业微信给的数据
        $sVerifyEchoStr = $_GET['echostr'] ?? 0;
        //缓存数据
        $file = "909090.txt";                                                   //这是xml格式的数据
        $file1 = "909091.txt";                                                  //这是json的数据
        $file2 = "909092.txt";                                                  //这是sEchoStr
        $file3 = "909093.txt";                                                  //这是SUITEICKET
        $file4 = "909094.txt";                                                  //这是ERROR
        $file5 = "909095.txt";                                                  //这是解密后的内容
        if ($sVerifyEchoStr) {
            $sEchoStr = "";
            $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $corpId);
            $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
            if ($errCode == 0) {
                // 验证URL成功，将sEchoStr返回
                file_put_contents($file2, "返回时间:" . date('Y-m-d H:i:s') . "sEchoStr值:" . $sEchoStr . "\n", FILE_APPEND);
                Cache::put('SECHOSTR', $sEchoStr, 1200);
                echo $sEchoStr;
                exit;
            } else {
                file_put_contents($file4, "二次验证错误，时间:" . date('Y-m-d H:i:s') . "sEchoStr值:" . $sEchoStr . ",错误编码:" . $errCode . "\n", FILE_APPEND);
            }
        }
        $sReqData = file_get_contents('php://input');
        if ($sReqData) {
            file_put_contents($file, "获取验证数据（新）" . date('Y-m-d H:i:s') . "\n" . $sReqData . "\n", FILE_APPEND);
            file_put_contents($file1, json_encode($_GET), FILE_APPEND);
            Cache::put('XMLHD', $sReqData, 1200);
            Cache::put('CSHD', json_encode($_GET), 1200);
        } else {
            $sReqData = Cache::get('XMLHD');
        }
        //
        $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $suiteId);
        $sMsg = '';  // 解析之后的明文
        $err_code = $wxcpt->DecryptMsg($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sReqData, $sMsg);
        $xmls = simplexml_load_string($sMsg, 'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
        file_put_contents($file5, "时间：" . date('Y-m-d H:i:s') . ",这是解密后的内容：" . $sMsg . "\n", FILE_APPEND);
        if ($err_code == 0) {
            switch ($xmls->InfoType) {
                case 'suite_ticket'://推送suite_ticket协议每十分钟微信推送一次
                    $xmls = json_decode(json_encode($xmls), 1);
                    $suite_ticket = $xmls['SuiteTicket'];
                    if (!empty($suite_ticket)) {
                        //  保存下获取到数据
                        file_put_contents($file3, "时间" . date('Y-m-d H:i:s') . " suite_ticket值：" . $suite_ticket . "\n", FILE_APPEND);
                        Cache::put("SUITEICKET", $suite_ticket, 1200);
                        echo 'success';  // 返回企业微信消息 success
                    } else {
                        echo 200;//错误信息
                    }
                    break;
            }
        } else {
            file_put_contents($file4, "首次验证错误，时间:" . date('Y-m-d H:i:s') . ",错误编码:" . $err_code . "\n", FILE_APPEND);
        }
    }


    //点击登录一     构造第三方应用oauth2链接
    public function clickLoginThird()
    {
        $appid = env('SUITEID', '');
        $durl = "api.lanxx.club";
        $state = "LANXXlanxx";
        $uri = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . $durl . "&response_type=code&scope=snsapi_privateinfo&state=" . $state . "#wechat_redirect";
        header("Location: $uri", TRUE, 302);
    }

    //点击登录一     构造企业oauth2链接
    public function clickLoginOauth()
    {
        $corpID = env('CORPID', '');
        $durl = "api.lanxx.club";
        $state = "LANXXlanxx";
        $uri = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $corpID . "&redirect_uri=" . $durl . "&response_type=code&scope=snsapi_base&agentid=AGENTID&state=" . $state . "#wechat_redirect";
        header("Location: $uri", TRUE, 302);
    }

    //展示授权按钮
    public function showPage()
    {
        //判断是否回调
        $auth_code = $_GET['auth_code'] ?? 0;
        if ($auth_code) {
            $s_a_t_info = $this->getSuiteAccessToken();
            $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证
            //$p_a_c_info = $this->getPreAuthCode($suite_access_token);
            //$per_auth_code = $p_a_c_info['pre_auth_code'];//预授权码
            //$durl = "https://api.lanxx.club";
            //$state = "LANXXlanxx";
            // , 'per_auth_code' => $per_auth_code, 'durl' => urlencode($durl), 'state' => $state


            $url_info = $_GET;
            $auth_lin_code = $url_info['auth_code'];//临时授权码
            $data = $this->getPermanentCode($suite_access_token, $auth_lin_code);//获取企业永久授权码


            $url_d = "https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=" . $suite_access_token;
            $data_d = ["auth_corpid" => $data['auth_corp_info']['corpid'], "permanent_code" => $data['permanent_code'], 'suite_access_token' => $suite_access_token];
            $rrrr = posturl($url_d, $data_d);
            $data['suite_access_token'] = $rrrr['access_token'];
            return WxqyAuthCompany::InSertOne($data);//数据保存到本地


        } else {
            $data = ['suite_id' => env('SUITEID', ''), 'state' => env('STATE_WORD', ''), 'agentid' => env('AGENTID', '')];
            return view('welcome')->with('data', $data);
        }

    }

























    //getSuiteTicket


    //这里是入口
    //获取企业授权信息
    public function getAuthInfo()
    {
        $s_a_t_info = $this->getSuiteAccessToken();
        $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证
        //$p_a_c_info = $this->getPreAuthCode($suite_access_token);
        //$per_auth_code = $p_a_c_info['pre_auth_code'];//预授权码

        //return $per_auth_code;
        $auth_corpid = "ww5a8c8cb36455ba7a";
        $permanent_code = 'ZJoMiXVOYZtjtf1xJGHQ4fQMYRkYlf1IGhmOHB1GNxn2sDqnVztHgRofHe5qCnK0zlfM-QIuTUg-TgQZj_Z5vr_l9QwZDBtvb1IMZi7cPcxxEYkLwJtJfTMo-WksJX9zSuvpvu_pIdw4Rq4lg041ugCruVZa2YDnDFIAJRkF4aXhmPH4vNo-f0ZJgAcPk_HQ0qbAwKdSGZ09e_T63cDlIw';
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_auth_info?suite_access_token=" . $suite_access_token;
        $data = ["auth_corpid" => $auth_corpid, "permanent_code" => $permanent_code];
        return posturl($url, $data);
    }

    //获取访问用户身份
    private function getUserInfo3rd($code)
    {
        $s_a_t_info = $this->getSuiteAccessToken();
        $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/getuserinfo3rd?suite_access_token=" . $suite_access_token . "&code=" . $code;
        return geturl($url);
    }

    //获取访问用户敏感信息
    private function getuserdetail3rd($user_ticket)
    {
        $base_url = env('QYWX_BASEURL', '');
        $s_a_t_info = $this->getSuiteAccessToken();
        $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证
        $url = $base_url . "service/getuserdetail3rd?suite_access_token=" . $suite_access_token;
        $data = ["user_ticket" => $user_ticket];
        return posturl($url, $data);
    }


    //获取应用的管理员列表
    public function getAdminList()
    {
        $SUITE_ACCESS_TOKEN = "sc";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_admin_list?suite_access_token=" . $SUITE_ACCESS_TOKEN;
        $data = ["auth_corpid" => "auth_corpid_value", "agentid" => "1000046"];
        return posturl($url, $data);
    }


    //获取企业凭证access_token
    public function getAccessToken()
    {
        $s_a_t_info = $this->getSuiteAccessToken();
        $suite_access_token = $s_a_t_info['suite_access_token'];//第三方应用凭证

        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=" . $suite_access_token;

        $auth_corpid = "ww5a8c8cb36455ba7a";
        $permanent_code = "Y13ZfuEDRpNbw3Ee7dk1zwzSlbGfxIqWkHp6fNhrAOyd7ZLLJgwNQgW3HwST_i0bA8XwBCvnCGo9FbF-fp1GwP1vRiE9fC5J8rEyvwDUqE5K9yokI2jSQWW1K1KPbcwCyRH933UaeJVGV8pJOwtQ6ORumTEjbC_Gu2pRs4CqTtlFREBAQ21GkEgiXDMy_hmMfn7pPCsLD-WighpaIrEqqA";
        $data = ["auth_corpid" => $auth_corpid, "permanent_code" => $permanent_code, 'suite_access_token' => $suite_access_token];
        return posturl($url, $data);
    }

    //获取Token
    public function getToken()
    {
        // https://qyapi.weixin.qq.com/cgi-bin/service/get_provider_token

        $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken';
        //$data= [
        //     "corpid" => "ww0328d5bc6e988741",
        //    "corpsecret" => "kAMeYTxTG_3kSUcHz105-eQaBByTdmPai3jDdmMNMvs"];
        $corpid = "ww0328d5bc6e988741";
        $corpsecret = "kAMeYTxTG_3kSUcHz105-eQaBByTdmPai3jDdmMNMvs";
        $data = '?corpid=ww0328d5bc6e988741&corpsecret=kAMeYTxTG_3kSUcHz105-eQaBByTdmPai3jDdmMNMvs';
        //$h=array("Accept:application/vnd.myapp.v1+json");
        // return $url .$data;
        return geturl($url . $data);
    }

    //创建用户
    public function createUser()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=' . $this->authenticationToken;
        $data = array(
            'userid' => "123456",
            'name' => "新建用户",
            'alias' => "jackzhang",
            'mobile' => "17709214962",
            'department' => [1],
            'order' => array('1'),
            'position' => "程序员",
            'gender' => "1",
            'email' => "san.zhang@qq.com",
            'telephone' => "17709214962",
            'is_leader_in_dept' => array('1'),
            //'avatar_mediaid'=>'',
            'enable' => 1,
            //'extattr'=>'',
            //'to_invite'=>true 	否 	是否邀请该成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
        );
        return posturl($url, json_encode($data));
    }

    //读取成员
    public function getUserInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user';
        $userId = 'YiRan';
        $data = '/get?access_token=' . $this->authenticationToken . '&userid=' . $userId;
        return geturl($url, $data);
    }

    //更新成员
    public function updataUserInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=' . $this->authenticationToken;
        $data = array(
            'userid' => "YiRan",
            'name' => "宋浩浩从测试",
            'alias' => "jackzhang",
            'mobile' => "17709214962",
            'department' => [1],
            'order' => array('1'),
            'position' => "程序员",
            'gender' => "1",
            'email' => "san.zhang@qq.com",
            'telephone' => "17709214962",
            'is_leader_in_dept' => array('1'),
            //'avatar_mediaid'=>'',
            'enable' => 1,
            //'extattr'=>'',
            //'to_invite'=>true 	否 	是否邀请该成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
        );
        return posturl($url, json_encode($data));
    }

    //删除成员,批量删除成员
    public function delUser()
    {
        $userId = 'YiRan';
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=' . $this->authenticationToken . '&userid=' . $userId;
        return geturl($url);
    }

    //删除成员,批量删除成员
    public function delUsers()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/batchdelete?access_token=' . $this->authenticationToken;
        $data = array("useridlist" => ["zhangsan", "lisi"]);
        return posturl($url, $data);
    }


    //获取部门成员
    public function getDepartmentUser()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/simplelist';
        $department_id = '1';
        $data = '?access_token=' . $this->authenticationToken . '&department_id=' . $department_id;
        return geturl($url . $data);
    }

    //获取部门成员详情
    public function getDepartmentUserList()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list';
        $department_id = '1';
        $data = '?access_token=' . $this->authenticationToken . '&department_id=' . $department_id;
        return geturl($url . $data);
    }

    //userid转openid
    public function convert_to_openid()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=' . $this->authenticationToken;
        $data = array('userid' => 'YiRan');
        return posturl($url . $data);
    }

    //openid转userid
    public function convert_to_userid()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_userid?access_token=' . $this->authenticationToken;
        $data = array('openid' => 'oDjGHs-1yCnGrRovBj2yHij5JAAA');
        return posturl($url . $data);
    }

    //邀请成员
    public function inviteUser()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/invite?access_token=' . $this->authenticationToken;
        $data = array(
            "user" => array("UserID1", "UserID2", "UserID3"),
            "party" => array("PartyID1", "PartyID2"),
            "tag" => array("TagID1", "TagID2")
        );
        return posturl($url . $data);
    }

    //获取加入企业二维码
    public function get_join_qrcode()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corp/get_join_qrcode?access_token=' . $this->authenticationToken;
        return geturl($url);
    }

    //获取企业活跃成员数
    public function get_active_stat()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/get_active_stat?access_token=' . $this->authenticationToken;
        return posturl($url);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ceshi()
    {
        return "sssssss";
    }
}
