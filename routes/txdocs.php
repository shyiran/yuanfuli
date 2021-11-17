<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/11/10 19:23
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ('v1', function ($api) {
    $api->group ([ 'prefix' => 'txdocs' ], function ($api){
        $api->get('getToken', '\App\Http\Controllers\v1\Txdocs\DocsController@getToken');
        $api->get('getddd', '\App\Http\Controllers\v1\Txdocs\DocsController@getTl');
    });
});
