<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/11/10 19:23
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ('v1', function ($api) {
    $api->group ([ 'prefix' => 'txdocs' ], function ($api){
        //申请用户授权 获取TOKEN
        $api->get('userAuthorize/{code}', '\App\Http\Controllers\v1\Txdocs\DocsController@userAuthorize',function ($code){})->where('code','.*');
        //获取用户信息
        $api->get('getUserinfo', '\App\Http\Controllers\v1\Txdocs\DocsController@getUserinfo');
        //新建文档
        $api->post('createFiles', '\App\Http\Controllers\v1\Txdocs\DocsController@createFiles');

        //添加文件夹
        $api->post('createFolders', '\App\Http\Controllers\v1\Txdocs\DocsController@createFolders');
        //获取文档列表??
        $api->get('getFolders', '\App\Http\Controllers\v1\Txdocs\DocsController@getFolders');


        $api->get('getToken', '\App\Http\Controllers\v1\Txdocs\DocsController@getToken');
        $api->get('getddd/callback?code={code}', '\App\Http\Controllers\v1\Txdocs\DocsController@getddd',function ($code,$state){})->where(['code' => '.*', 'state' => '.*']);
    });
});
