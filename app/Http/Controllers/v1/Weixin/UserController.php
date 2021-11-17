<?php

namespace App\Http\Controllers\v1\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    //获取服务商凭证 get_provider_token
    public function getProviderToken ()
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_provider_token";
        $data = [ "corpid" => "ww0328d5bc6e988741", "provider_secret" => "oITvxYhiA6Q5y6FQ5yyDYceLrvosUK2nUX0Wa1sgCHxRewufpOphCk0r_qlpO2z0" ];
        return posturl ($url, $data);
    }

    //获取第三方应用凭证（suite_access_token）
    public function getSuiteAccessToken ()
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_suite_token";
        $suite_id = "ww89216d45463b353d";
        $suite_secret = "ueiq-2WhDiZrMV1Al6YhNa8tktICPzKi6vSoSNUYTm0";
        $suite_ticket = Cache::get('SUITEICKET');
        $data = [ "suite_id" => $suite_id, "suite_secret" => $suite_secret, "suite_ticket" => $suite_ticket ];
        return posturl ($url, $data);
    }
    //获取预授权码get_pre_auth_code
    public function getPreAuthCode(){
        $s="qgfZQfKeDI3GMvjIXquh5mEgFokUSNZJ0V6bCqiCs7zQ8DTJfgVVeV9yGC7xY8UF7fA55OMDq9-cRVrbsRNDpqVPyG_1YAQKxmfdr8mEkQOWd11K3_byFVcYg9ThMTU7";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_pre_auth_code?suite_access_token=".$s;
        return geturl ($url);
    }

    //getSuiteTicket
    //获取suite_ticket（suite_ticket）
    public function getSuiteTicket ()
    {
        $encodingAesKey = "J3N3MbJQ9QAlrlMhFW9Tmf1PIJg9xNXQsYQhYcX3EfM";              //这是已有的值
        $token = "sRVzMAL5Nqxa";                                                     //这是已有的值
        $corpId = "ww0328d5bc6e988741";                                               //企业ID //这是已有的值
        $suiteId = "ww89216d45463b353d";                                             //应用id //这是已有的值


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
            $errCode = $wxcpt->VerifyURL ($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
            if ($errCode == 0) {
                // 验证URL成功，将sEchoStr返回
                file_put_contents ($file2, $sEchoStr . "\n\n", FILE_APPEND);
                Cache::put ('SECHOSTR', $sEchoStr, 1200);
                exit;
            } else {
                file_put_contents ($file4, "二次错误" . $sEchoStr . "\n\n", FILE_APPEND);
                print("ERR: " . $errCode . "\n\n");
            }
        }
        $sReqData = file_get_contents ('php://input');
        if ($sReqData) {
            file_put_contents ($file, "获取验证数据（新）" . date ('Y-m-d H:i:s') . "\n" . $sReqData . "\n", FILE_APPEND);
            file_put_contents ($file1, json_encode ($_GET), FILE_APPEND);
            Cache::put ('XMLHD', $sReqData, 1200);
            Cache::put ('CSHD', json_encode ($_GET), 1200);
        } else {
            $sReqData = Cache::get ('XMLHD');
        }
        //
        $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $suiteId);
        $sMsg = '';  // 解析之后的明文
        $err_code = $wxcpt->DecryptMsg ($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sReqData, $sMsg);
        $xmls = simplexml_load_string ($sMsg, 'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
        file_put_contents ($file5, "这是解密后的内容" . $sMsg . "\n" . $xmls->InfoType . "\n" . "ERROECODE:" . $err_code . "\n", FILE_APPEND);
        if ($err_code == 0) {
            switch ($xmls->InfoType) {
                case 'suite_ticket'://推送suite_ticket协议每十分钟微信推送一次
                    $xmls = json_decode (json_encode ($xmls), 1);
                    $suite_ticket = $xmls['SuiteTicket'];
                    if (!empty($suite_ticket)) {
                        //  保存下获取到数据
                        file_put_contents ($file3, "时间" . date ('Y-m-d H:i:s') . "suite_ticket值：" . $suite_ticket . "\n", FILE_APPEND);
                        Cache::put ("SUITEICKET", $suite_ticket,1200);
                        echo 'success';  // 返回企业微信消息 success
                    } else {
                        echo 200;//错误信息
                    }
                    break;
            }
        } else {
            file_put_contents ($file4, $err_code . "\n", FILE_APPEND);
        }
    }



    //获取企业凭证access_token
    public function getAccessToken ()
    {
        $suiteAccessToken = "ssssssss";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=" . $suiteAccessToken;
        $auth_corpid = "scs";
        $permanent_code = "ssssssssssss";
        $data = [ "auth_corpid" => $auth_corpid, "permanent_code" => $permanent_code ];

    }

    //获取Token
    public function getToken ()
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
        return geturl ($url . $data);
    }

    //创建用户
    public function createUser ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=' . $this->authenticationToken;
        $data = array (
            'userid' => "123456",
            'name' => "新建用户",
            'alias' => "jackzhang",
            'mobile' => "17709214962",
            'department' => [ 1 ],
            'order' => array ( '1' ),
            'position' => "程序员",
            'gender' => "1",
            'email' => "san.zhang@qq.com",
            'telephone' => "17709214962",
            'is_leader_in_dept' => array ( '1' ),
            //'avatar_mediaid'=>'',
            'enable' => 1,
            //'extattr'=>'',
            //'to_invite'=>true 	否 	是否邀请该成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
        );
        return posturl ($url, json_encode ($data));
    }

    //读取成员
    public function getUserInfo ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user';
        $userId = 'YiRan';
        $data = '/get?access_token=' . $this->authenticationToken . '&userid=' . $userId;
        return geturl ($url, $data);
    }

    //更新成员
    public function updataUserInfo ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=' . $this->authenticationToken;
        $data = array (
            'userid' => "YiRan",
            'name' => "宋浩浩从测试",
            'alias' => "jackzhang",
            'mobile' => "17709214962",
            'department' => [ 1 ],
            'order' => array ( '1' ),
            'position' => "程序员",
            'gender' => "1",
            'email' => "san.zhang@qq.com",
            'telephone' => "17709214962",
            'is_leader_in_dept' => array ( '1' ),
            //'avatar_mediaid'=>'',
            'enable' => 1,
            //'extattr'=>'',
            //'to_invite'=>true 	否 	是否邀请该成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
        );
        return posturl ($url, json_encode ($data));
    }

    //删除成员,批量删除成员
    public function delUser ()
    {
        $userId = 'YiRan';
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=' . $this->authenticationToken . '&userid=' . $userId;
        return geturl ($url);
    }

    //删除成员,批量删除成员
    public function delUsers ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/batchdelete?access_token=' . $this->authenticationToken;
        $data = array ( "useridlist" => [ "zhangsan", "lisi" ] );
        return posturl ($url, $data);
    }


    //获取部门成员
    public function getDepartmentUser ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/simplelist';
        $department_id = '1';
        $data = '?access_token=' . $this->authenticationToken . '&department_id=' . $department_id;
        return geturl ($url . $data);
    }

    //获取部门成员详情
    public function getDepartmentUserList ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list';
        $department_id = '1';
        $data = '?access_token=' . $this->authenticationToken . '&department_id=' . $department_id;
        return geturl ($url . $data);
    }

    //userid转openid
    public function convert_to_openid ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=' . $this->authenticationToken;
        $data = array ( 'userid' => 'YiRan' );
        return posturl ($url . $data);
    }

    //openid转userid
    public function convert_to_userid ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_userid?access_token=' . $this->authenticationToken;
        $data = array ( 'openid' => 'oDjGHs-1yCnGrRovBj2yHij5JAAA' );
        return posturl ($url . $data);
    }

    //邀请成员
    public function inviteUser ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/invite?access_token=' . $this->authenticationToken;
        $data = array (
            "user" => array ( "UserID1", "UserID2", "UserID3" ),
            "party" => array ( "PartyID1", "PartyID2" ),
            "tag" => array ( "TagID1", "TagID2" )
        );
        return posturl ($url . $data);
    }

    //获取加入企业二维码
    public function get_join_qrcode ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corp/get_join_qrcode?access_token=' . $this->authenticationToken;
        return geturl ($url);
    }

    //获取企业活跃成员数
    public function get_active_stat ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/get_active_stat?access_token=' . $this->authenticationToken;
        return posturl ($url);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
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
    public function update (Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
        //
    }

    public function ceshi ()
    {
        return "sssssss";
    }
}
