<?php

namespace App\Http\Controllers\v1\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //获取Token
    public function getToken ()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken';
        $data = '?corpid=ww0328d5bc6e988741&corpsecret=kAMeYTxTG_3kSUcHz105-eQaBByTdmPai3jDdmMNMvs';
        //$h=array("Accept:application/vnd.myapp.v1+json");
        return geturl ($url . $data,'');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
