<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/10/30 21:53
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ("v1", function ($api) {
    $api->group ([ "prefix" => "user" ], function ($api){
        //获取用户基本身份信息
        $api->get('getBaseInfo', 'App\Http\Controllers\v1\User\UserController@getBaseInfo');
        //获取用户菜单
        $api->get('getMenuInfo', 'App\Http\Controllers\v1\User\UserController@getMenuInfo');
    });
});
