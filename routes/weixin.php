<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/10/30 21:53
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ('v1', function ($api) {
    $api->group ([ 'prefix' => 'weixin' ], function ($api){
        //获取token
        $api->get('getToken', '\App\Http\Controllers\Weixin\UserController@getToken');
        //通讯录管理
        //创建成员
        $api->post('createUser', '\App\Http\Controllers\Weixin\UserController@createUser');
        //读取成员
        $api->get('getUserInfo', '\App\Http\Controllers\Weixin\UserController@getUserInfo');
        //更新成员
        $api->post('updataUserInfo', '\App\Http\Controllers\Weixin\UserController@updataUserInfo');
        //删除成员
        $api->get('delUser', '\App\Http\Controllers\Weixin\UserController@delUser');
        //批量删除成员
        $api->post('delUsers', '\App\Http\Controllers\Weixin\UserController@delUsers');
        //获取部门成员
        $api->get('getDepartmentUser', '\App\Http\Controllers\Weixin\UserController@getDepartmentUser');
        //获取部门成员详情
        $api->get('getDepartmentUserList', '\App\Http\Controllers\Weixin\UserController@getDepartmentUserList');
        //userid转openid
        $api->post('convert_to_openid', '\App\Http\Controllers\Weixin\UserController@convert_to_openid');
        //openid转userid
        $api->post('convert_to_userid', '\App\Http\Controllers\Weixin\UserController@convert_to_userid');
        //二次验证???
        //邀请成员
        $api->post('inviteUser', '\App\Http\Controllers\Weixin\UserController@inviteUser');
        //获取加入企业二维码
        $api->get('get_join_qrcode', '\App\Http\Controllers\Weixin\UserController@get_join_qrcode');
        //获取企业活跃成员数
        $api->post('get_active_stat', '\App\Http\Controllers\Weixin\UserController@get_active_stat');

        //通讯录管理
        //创建部门
        $api->post('createDepartment', '\App\Http\Controllers\Weixin\DepartmentController@createDepartment');
        //更新部门
        $api->post('updateDepartment', '\App\Http\Controllers\Weixin\DepartmentController@updateDepartment');
        //删除部门
        $api->get('delDepartment', '\App\Http\Controllers\Weixin\DepartmentController@delDepartment');
        //获取部门列表
        $api->get('getDepartmentList', '\App\Http\Controllers\Weixin\DepartmentController@getDepartmentList');

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
        //$api->get('getCheckRoute', '\App\Http\Controllers\v1\Weixin\OaController@getCheckRoute');
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

    });
});
/*$api->version ('v1', function ($api) {
    $api->group ([ 'prefix' => 'user' ], function ($api) {
        $api->resource ('show', \App\Http\Controllers\User\UserController::class);



$api->version('v1', function ($api) {

});*/
