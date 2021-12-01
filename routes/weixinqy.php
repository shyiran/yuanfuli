<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/10/30 21:53
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ("v1", function ($api) {
    $api->group ([ "prefix" => "weixin" ], function ($api){
        //用户扫描登录并且获取用户身份信息
        $api->get('userLogin', 'App\Http\Controllers\v1\Weixin\UserController@userLogin');





        //获取服务商凭证 get_provider_token 2小时
        $api->post('getProviderToken', '\App\Http\Controllers\v1\Weixin\UserController@getProviderToken');

        //用户授权回调URL userAuthSuccess
        $api->get('userAuthSuccess', 'App\Http\Controllers\v1\Weixin\UserController@userAuthSuccess');
        //扫描登录
        $api->get('scanningQR', 'App\Http\Controllers\v1\Weixin\UserController@scanningQR');





        //点击登录一     构造第三方应用oauth2链接
        $api->get('clickLoginThird', 'App\Http\Controllers\v1\Weixin\UserController@clickLoginThird');
        //点击登录一     构造企业oauth2链接
        $api->get('clickLoginOauth', 'App\Http\Controllers\v1\Weixin\UserController@clickLoginOauth');



        //获取第三方应用凭证（suite_access_token） ??????
//      $api->post('getSuiteAccessToken', '\App\Http\Controllers\v1\Weixin\UserController@getSuiteAccessToken');
        //获取预授权码get_pre_auth_code
//      $api->get('getPreAuthCode', '\App\Http\Controllers\v1\Weixin\UserController@getPreAuthCode');
        //获取suite_ticket（suite_ticket）
        $api->post('getSuiteTicket', '\App\Http\Controllers\v1\Weixin\UserController@getSuiteTicket');
        //获取getSuiteTicket（suite_ticket）
        $api->get('getSuiteTicket', '\App\Http\Controllers\v1\Weixin\UserController@getSuiteTicket');

        //sssss
        $api->get('lxx', 'App\Http\Controllers\v1\Weixin\UserController@lxx');


        //获取企业永久授权码
        //
        //获取预授权码get_pre_auth_code
        $api->get('getPreAuthCode', '\App\Http\Controllers\v1\Weixin\UserController@getPreAuthCode');
        //获取企业凭证access_token
        $api->post('getAccessToken', '\App\Http\Controllers\v1\Weixin\UserController@getAccessToken');
        //获取企业授权信息
        $api->post('getAuthInfo', 'App\Http\Controllers\v1\Weixin\UserController@getAuthInfo');
        //获取企业凭证get_corp_token
//      $api->post('getCorpToken', 'App\Http\Controllers\v1\Weixin\UserController@getCorpToken');
        //获取应用的管理员列表
        $api->post('getAdminList', 'App\Http\Controllers\v1\Weixin\UserController@getAdminList');






        $api->get('fff', 'App\Http\Controllers\v1\Weixin\UserController@getUserInfo3rd');

        //获取token
        $api->get('getToken', '\App\Http\Controllers\v1\Weixin\UserController@getToken');
        //通讯录管理
        //创建成员
        $api->post('createUser', '\App\Http\Controllers\v1\Weixin\UserController@createUser');
        //读取成员
        $api->get('getUserInfo', '\App\Http\Controllers\v1\Weixin\UserController@getUserInfo');
        //更新成员
        $api->post('updataUserInfo', '\App\Http\Controllers\v1\Weixin\UserController@updataUserInfo');
        //删除成员
        $api->get('delUser', '\App\Http\Controllers\v1\Weixin\UserController@delUser');
        //批量删除成员
        $api->post('delUsers', '\App\Http\Controllers\v1\Weixin\UserController@delUsers');
        //获取部门成员
        $api->get('getDepartmentUser', '\App\Http\Controllers\v1\Weixin\UserController@getDepartmentUser');
        //获取部门成员详情
        $api->get('getDepartmentUserList', '\App\Http\Controllers\v1\Weixin\UserController@getDepartmentUserList');
        //userid转openid
        $api->post('convert_to_openid', '\App\Http\Controllers\v1\Weixin\UserController@convert_to_openid');
        //openid转userid
        $api->post('convert_to_userid', '\App\Http\Controllers\v1\Weixin\UserController@convert_to_userid');
        //二次验证???
        //邀请成员
        $api->post('inviteUser', '\App\Http\Controllers\v1\Weixin\UserController@inviteUser');
        //获取加入企业二维码
        $api->get('get_join_qrcode', '\App\Http\Controllers\v1\Weixin\UserController@get_join_qrcode');
        //获取企业活跃成员数
        $api->post('get_active_stat', '\App\Http\Controllers\v1\Weixin\UserController@get_active_stat');

        //通讯录管理
        //创建部门
        $api->post('createDepartment', '\App\Http\Controllers\v1\Weixin\DepartmentController@createDepartment');
        //更新部门
        $api->post('updateDepartment', '\App\Http\Controllers\v1\Weixin\DepartmentController@updateDepartment');
        //删除部门
        $api->get('delDepartment', '\App\Http\Controllers\v1\Weixin\DepartmentController@delDepartment');
        //获取部门列表
        $api->get('getDepartmentList', '\App\Http\Controllers\v1\Weixin\DepartmentController@getDepartmentList');

        //标签管理
        //创建标签
        //更新标签名字
        //删除标签
        //获取标签成员
        //增加标签成员
        //删除标签成员
        //获取标签列表


        //OA部分
        //打卡
        //获取员工打卡规则
        $api->get('getCheckRoute', '\App\Http\Controllers\v1\Weixin\OaController@getCheckRoute');
        //获取打卡记录数据
        //获取打卡日报数据
        //获取打卡月报数据
        //获取打卡人员排班信息
        //为打卡人员排班
        //获取设备打卡数据
    });
});
$api->version ('v2', function ($api) {
    $api->group ([ 'prefix' => 'weixin' ], function ($api){
        //获取token
        $api->get('getToken', '\App\Http\Controllers\v2\Weixin\UserController@getToken');
    });
});
