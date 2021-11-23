<?php

namespace App\Http\Controllers\v1\Weixin;

use App\Http\Controllers\BaseController;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;


class TestController extends BaseController
{
    public function rr(){
        Cache::put('"SUITEICKET','val1',10);
    }
    public function dd(){
        $val =  Cache::get('SUITEICKET');
        return $val;
    }
    public function ddd(){
        $val = \App\Models\User::getUserInfoByID(2);
        return $val;
    }
    public function a(){
        $file = "909090.txt";//这是xml格式的数据
        $sReqData='ss';
        $f=file_put_contents($file, "获取验证票据（新）" . date('Y-m-d H:i:s') . "\n" . $sReqData . "\n", FILE_APPEND);
        echo file_put_contents("test.txt","Hello World. Testing!");
   return "dv";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        //
        return "dvsvsbr";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    {
        //
    }
}
function zq(){




    $encodingAesKey = "jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C";
    $token = "QDG6eK";
    $corpId = "wx5823bf96d3bd56c7";


    $sVerifyMsgSig = "5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3";
    $sVerifyTimeStamp = "1409659589";
    $sVerifyNonce = "263014780";
    $sVerifyEchoStr = "P9nAzCzyDtyTWESHep1vC5X9xho/qYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp+4RPcs8TgAE7OaBO+FZXvnaqQ==";









// 需要返回的明文
    $sEchoStr = "";




    $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $corpId);
    $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
    if ($errCode == 0) {
        return $sEchoStr;
        //
        // 验证URL成功，将sEchoStr返回
        // HttpUtils.SetResponce($sEchoStr);
    } else {
        print("ERR: " . $errCode . "\n\n");
    }
}
