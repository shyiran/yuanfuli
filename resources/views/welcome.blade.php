<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>蓝猩猩PR接口</title>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid={{$data['suite_id']}}&redirect_uri=https%3A%2F%2Fapi.lanxx.club%2Fweixin%2FuserLogin&response_type=code&scope=snsapi_privateinfo&state={{$data['state']}}#wechat_redirect"> 企业微信授权登陆(构造第三方应用oauth2链接) </a><br><br><br>
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid={{$data['suite_id']}}&redirect_uri=https%3A%2F%2Fapi.lanxx.club%2Fweixin%2FuserLogin&response_type=code&scope=snsapi_privateinfo&agentid={{$data['agentid']}}&state={{$data['state']}}#wechat_redirect"> 企业微信授权登陆(构造企业oauth2链接) </a><br><br><br>
                    <a href="https://api.lanxx.club/weixin/scanningQR">企业微信管理安装营业</a>
                </div>
            </div>
        </div>
    </body>
</html>
