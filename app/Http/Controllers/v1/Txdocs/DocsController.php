<?php

namespace App\Http\Controllers\v1\Txdocs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function getTl(){
        $url="https://docs.qq.com/oauth/v2/authorize";
        $data=[
            "client_id"=>"0b8e321b32084ffda3bb05afdbe6c6e8",
            "response_type"=>"code",
            "scope"=>"code",
            "state"=>"BER",
            "redirect_uri"=>urlencode ("https://api.lanxx.club"),
        ];

        //$t="0b8e321b32084ffda3bb05afdbe6c6e8";
        //$c="08b1aa4b917d440ca65ff8401a604104";
        //$h="https://api.lanxx.club";
        //$result = $url.'?client_id='.$t.'&redirect_uri='.$h.'/fcallback&response_type=code&scope=all&state=STATE';
        //$result = $url.'token?client_id='.$t.'&client_secret='.$c.'&redirect_uri='.$h.'/fcallback&grant_type=authorization_code&code=CODE';
        //return $result;

        return geturl ($url,$data);
        return geturl ($result  );

    }
    public function getToken(){
        $url="https://docs.qq.com/oauth/v2/";
        $t="0b8e321b32084ffda3bb05afdbe6c6e8";
        $c="08b1aa4b917d440ca65ff8401a604104";
        $h="http://api.lanxx.club";
        //$h= "https%3a%2f%2fapi.lanxx.club";
        $CODE="s";

        $gg= $url.'token?client_id='.$t.'&client_secret='.$c.'&redirect_uri='.$h.'/fcallback&grant_type=authorization_code&code='.$CODE;






        return geturl ($gg);
        return geturl ($result  );

    }
}
