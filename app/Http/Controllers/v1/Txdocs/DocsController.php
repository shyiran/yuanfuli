<?php

namespace App\Http\Controllers\v1\Txdocs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocsController extends Controller
{

    //申请用户授权
    public function userAuthorize ()
    {
        $url = "https://docs.qq.com/oauth/v2/authorize";
        $client_id = "0b8e321b32084ffda3bb05afdbe6c6e8";
        $client_secret = "08b1aa4b917d440ca65ff8401a604104";
        $redirect_uri = "https://api.lanxx.club/txdocs/userAuthorize/";
        $all_url = $url . "?client_id=" . $client_id . "&redirect_uri=" . urlencode ($redirect_uri) . "callback&response_type=code&scope=all&state=LANXXDOCS";
        //、、return $all_url;
        $url_info = $_GET;
        $code = $url_info['code'];
        //$state = $url_info['state'];

        $url = "https://docs.qq.com/oauth/v2/token?client_id=" . $client_id . "&client_secret=" . $client_secret . "&redirect_uri=" . urlencode ($redirect_uri) . "callback&grant_type=authorization_code&code=" . $code;

        return geturl ($url);
    }

    //获取用户信息
    public function getUserinfo ()
    {
        $access_token="AAWDRSVONMA5KCF_LZFLDA";
        $url="https://docs.qq.com/oauth/v2/userinfo?access_token=".$access_token;
        //return  $url;
        return geturl ($url);
    }

    //createFiles
    public function createFiles (Request $request)
    {
        $url = "https://docs.qq.com/openapi/drive/v2/files";
        $request->headers->set ('Access-Token', 'AAWDRSVONMA5KCF_LZFLDA');
        $request->headers->set ('Client-Id', '0b8e321b32084ffda3bb05afdbe6c6e8');
        $request->headers->set ('Open-Id', '0357132a5bb24aba8d112352803205f4');

         $data['title']="文档的标题";
         return posturl ($url,$data);
        //$type 	string 	是 	文档类型，枚举值
//$doc：在线文档，默认值
//$sheet：在线表格
//$form：在线收集表
//$slide：在线幻灯片
//$mind：在线思维导图
//$flowchart：在线流程图
//$templateID 	integer 	否 	文档模板唯一标识，默认创建空白文档
//$folderID
    }
    //添加文件夹,不是文件
    public function createFolders(Request $request)
    {
        $url = "https://docs.qq.com/openapi/drive/v2/files?title=test";
        $header = [
            "Content-Type:application/x-www-form-urlencoded",
            "Accept:application/json",
            "Access-Token:AAWDRSVONMA5KCF_LZFLDA",
            "Client-Id:0b8e321b32084ffda3bb05afdbe6c6e8",
            "Open-Id:0357132a5bb24aba8d112352803205f4",
        ];
        $data['title']="文档的标题";
        return posturl ($url,[],$header);
    }
    //获取文档列表
    public function getFolders (Request $request)
    {
        $header = [
            "Content-Type:application/x-www-form-urlencoded",
            "Accept:application/json",
            "Access-Token:AAWDRSVONMA5KCF_LZFLDA",
            "Client-Id:0b8e321b32084ffda3bb05afdbe6c6e8",
            "Open-Id:0357132a5bb24aba8d112352803205f4",
        ];
        $url = "https://docs.qq.com/openapi/drive/v2/folders";
        return geturl($url,[],$header);
    }


    public function getTl ()
    {
        $url = "https://docs.qq.com/oauth/v2/authorize";
        $data = [
            "client_id" => "0b8e321b32084ffda3bb05afdbe6c6e8",
            "response_type" => "code",
            "scope" => "code",
            "state" => "BER",
            "redirect_uri" => urlencode ("https://api.lanxx.club"),
        ];

        //$t="0b8e321b32084ffda3bb05afdbe6c6e8";
        //$c="08b1aa4b917d440ca65ff8401a604104";
        //$h="https://api.lanxx.club";
        //$result = $url.'?client_id='.$t.'&redirect_uri='.$h.'/fcallback&response_type=code&scope=all&state=STATE';
        //$result = $url.'token?client_id='.$t.'&client_secret='.$c.'&redirect_uri='.$h.'/fcallback&grant_type=authorization_code&code=CODE';
        //return $result;

        return geturl ($url, $data);
        return geturl ($result);

    }

    public function getToken ()
    {
        $url = "https://docs.qq.com/oauth/v2/";
        $t = "0b8e321b32084ffda3bb05afdbe6c6e8";
        $c = "08b1aa4b917d440ca65ff8401a604104";
        $h = "http://api.lanxx.club";
        //$h= "https%3a%2f%2fapi.lanxx.club";
        $CODE = "s";

        $gg = $url . 'token?client_id=' . $t . '&client_secret=' . $c . '&redirect_uri=' . $h . '/fcallback&grant_type=authorization_code&code=' . $CODE;

        return $gg;
        return geturl ($gg);
        return geturl ($result);

    }

    public function getddd ()
    {
        return "D";
    }
}
