<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

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
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wwc82d448ddc777dbe&redirect_uri=https%3A%2F%2Fapi.lanxx.club%2Fweixin%2Fgetlll&response_type=code&scope=snsapi_userinfo&state=LAXXlanxx#wechat_redirect"> 企业微信授权登陆 </a><br><br><br>
                    <a href="https://docs.qq.com/oauth/v2/authorize?client_id=0b8e321b32084ffda3bb05afdbe6c6e8&redirect_uri=https%3A%2F%2Fapi.lanxx.club%2Ftxdocs%2FuserAuthorize%2Fcallback&response_type=code&scope=all&state=LANXXDOCS">腾讯文档授权登陆</a><br><br><br>
                    <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wwc82d448ddc777dbe&redirect_uri=https%3A%2F%2Fapi.lanxx.club%2Fweixin%2Fgetlll&response_type=code&scope=snsapi_userinfo&state=LAXXlanxx#wechat_redirect"><img src="https://open.work.weixin.qq.com/service/img?id=ww0328d5bc6e988741&t=login&c=blue&s=small" srcset="https://open.work.weixin.qq.com/service/img?id=ww0328d5bc6e988741&t=login&c=blue&s=small@2x 2x" referrerpolicy="unsafe-url" alt="企业微信"></a>
                    <a href="https://open.work.weixin.qq.com/3rdapp/install?suite_id={{$data['suite_id']}}&pre_auth_code={{$data['per_auth_code']}}&redirect_uri={{$data['durl']}}&state={{$data['state']}}">aaaaaa</a>
                </div>
            </div>
        </div>
    </body>
</html>
