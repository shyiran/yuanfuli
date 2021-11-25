<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/11/6 16:43
 */
$api = app ('Dingo\Api\Routing\Router');
$api->version ('v1', function ($api) {
    $api->group ([ 'prefix' => 'qiniu' ], function ($api){
        // 创建一个文件（包含路径）create a file
        $api->post('createFile', '\App\Http\Controllers\v1\Qiniu\FileController@createFile');
        // 检查文件是否存在 check if a file exists
        $api->get('fileExists', '\App\Http\Controllers\v1\Qiniu\FileController@fileExists');
        // 获取文档的最后修改时间 get timestamp
        $api->get('lastModified', '\App\Http\Controllers\v1\Qiniu\FileController@lastModified');
        // 获取文档的创建时间 get timestamp
        $api->get('createTimestamp', '\App\Http\Controllers\v1\Qiniu\FileController@createTimestamp');
        // 文件复制 copy a file
        $api->post('copyFile', '\App\Http\Controllers\v1\Qiniu\FileController@copyFile');
        // 移动文件move a file
        $api->post('moveFile', '\App\Http\Controllers\v1\Qiniu\FileController@moveFile');
        // 获取文件 get file contents   ?????
        $api->get('getFileContents', '\App\Http\Controllers\v1\Qiniu\FileController@getFileContents');
        // fetch url content  ?????
        $api->get('fetchUrlContent', '\App\Http\Controllers\v1\Qiniu\FileController@fetchUrlContent');
        // get file url
        $api->get('getFileUrl', '\App\Http\Controllers\v1\Qiniu\FileController@getFileUrl');
        // get file upload token
        $api->get('getfileUpLoadToken', '\App\Http\Controllers\v1\Qiniu\FileController@getfileUpLoadToken');
        // get private url
        $api->get('getPrivateUrl', '\App\Http\Controllers\v1\Qiniu\FileController@getPrivateUrl');
        // get private url
        $api->get('getList', '\App\Http\Controllers\v1\Qiniu\FileController@getList');
    });
});
