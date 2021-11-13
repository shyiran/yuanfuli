<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/11/10 19:23
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ('v1', function ($api) {
    $api->group ([ 'prefix' => 'txdocs' ], function ($api){
        $api->get('getToken', '\App\Http\Controllers\Txdocs\DocsController@getToken');
        $api->get('get', '\App\Http\Controllers\Txdocs\DocsController@getTl');
    });
});