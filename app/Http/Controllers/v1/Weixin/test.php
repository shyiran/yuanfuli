<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/11/15 22:34
 */
/**
 * 验证回调URL
 * 推送suite_ticket
 */
public function getSuiteTicket(){
    $encodingAesKey = "";
    $token = "";
    $corpId = "";//  企业ID
    $suiteId = '';//  应用id

    $sVerifyMsgSig = $_GET['msg_signature'];
    $sVerifyTimeStamp = $_GET['timestamp'];

    $sVerifyNonce = $_GET['nonce'];
    include_once EXTEND_PATH."Weixin/WXBizMsgCrypt.php";
    if(!empty($_GET['echostr'])){
        $sVerifyEchoStr = $_GET['echostr'];
        $sEchoStr = "";
        $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $corpId);
        $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        if ($errCode == 0) {
            // 验证URL成功，将sEchoStr返回
            echo $sEchoStr;
            exit;
        } else {
            print("ERR: " . $errCode . "\n\n");
        }
    }
    file_put_contents(RUNTIME_PATH."tmp.txt", $_SERVER['REQUEST_METHOD'], FILE_APPEND);
    file_put_contents(RUNTIME_PATH."tmp.txt", file_get_contents("php://input"), FILE_APPEND);
    //判断企业微后台是否推送suite_ticket到该url，post形式
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        //必须通过输入流方式获取post数据,，接收到的$sReqData 为xml格式，需转换成对象或其他格式
        $sReqData = file_get_contents("php://input");
        $xml =  simplexml_load_string($sReqData,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
        $ToUserName = $xml->ToUserName;
        if($suiteId == $ToUserName){ //证明是企业微信后台推送
            include_once EXTEND_PATH."Weixin/WXBizMsgCrypt.php";
            $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $ToUserName);
            $sMsg     = '';  // 解析之后的明文
            $err_code = $wxcpt->DecryptMsg($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sReqData, $sMsg);
            $xmls = simplexml_load_string($sMsg,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
            if($err_code == 0){
                switch ($xmls->InfoType) {
                    case 'suite_ticket'://推送suite_ticket协议每十分钟微信推送一次
                        $xmls = json_decode(json_encode($xmls), 1);
                        $suite_ticket = $xmls['SuiteTicket'];
                        if (!empty($suite_ticket)) {
                            //  保存下获取到数据
                            Cache::set("SuiteTicket", $suite_ticket);
                            echo 'success';  // 返回企业微信消息 success
                        }
                        else {
                            echo 200;//错误信息
                        }
                        break;
                }
            }
        }
    }
    exit;
}
function dddd(){
    //$super_id = superId(\session('admin_cate_id'),\session('admin'));
    //$enterprise_set = db("enterprise_set")->where(['super_id' => $super_id])->find();


    //$encodingAesKey = $enterprise_set['encodingAesKey'];//这是已有的值
    //$token = $enterprise_set['token'];//这是已有的值
    //$corpId = $enterprise_set['crop_id']; //  企业ID //这是已有的值
    //$suiteId = $enterprise_set['suite_id']; //  应用id //这是已有的值

    $encodingAesKey ='J3N3MbJQ9QAlrlMhFW9Tmf1PIJg9xNXQsYQhYcX3EfM';              //这是已有的值
    $token = "sRVzMAL5Nqxa";                                                    //这是已有的值
    $corpId ="ww0328d5bc6e988741";                                              //  企业ID //这是已有的值
    $suiteId = "ww89216d45463b353d";                                            //  应用id //这是已有的值



    $msg_signature = $_GET['msg_signature'] ?? 0;       //这是回调过来企业微信给的数据
    $timestamp = $_GET['timestamp'] ?? 0;               //这是回调过来企业微信给的数据
    $nonce = $_GET['nonce'] ?? 0;                       //这是回调过来企业微信给的数据
    $echostr = $_GET['echostr'] ?? 0;




    /* if(!empty( $echostr )){
          $sVerifyEchoStr =  $_GET['echostr'] ;
          $sEchoStr = "SDERFDffffff";
          $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $corpId);

          $errCode = $wxcpt->VerifyURL($msg_signature, $timestamp, $nonce, $sVerifyEchoStr, $sEchoStr);

          if ($errCode == 0) {
              //验证URL成功，将sEchoStr返回
              echo $sEchoStr;
              echo "RRR00";
             exit;
          } else {
              print("ERRffff: " . $errCode . "\n\n");
          }
      }*/





    //判断企业微后台是否推送suite_ticket到该url，post形式
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        //必须通过输入流方式获取post数据,，接收到的$sReqData 为xml格式，需转换成对象或其他格式
        $sReqData = file_get_contents("php://input");
        $xml =  simplexml_load_string($sReqData,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
        //$ToUserName = $xml->ToUserName;
        $ToUserName = "ww89216d45463b353d";
        if($suiteId == $ToUserName){ //证明是企业微信后台推送

            $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $ToUserName);
            $sMsg     = '';  // 解析之后的明文
            $err_code = $wxcpt->DecryptMsg($msg_signature, $timestamp, $nonce, $sReqData, $sMsg);
            $xmls = simplexml_load_string($sMsg,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
            if($err_code == 0){
                switch ($xmls->InfoType) {
                    case 'suite_ticket'://推送suite_ticket协议每十分钟微信推送一次
                        $xmls = json_decode(json_encode($xmls), 1);
                        $suite_ticket = $xmls['SuiteTicket'];
                        if (!empty($suite_ticket)) {
                            //  保存下获取到数据
                            Cache::set("SuiteTicket", $suite_ticket);
                            echo 'success';  // 返回企业微信消息 success
                        }
                        else {
                            echo 200;//错误信息
                        }
                        break;
                }
            }
        }
    }





    /*  $sReqData = file_get_contents('php://input');

      $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey,$suiteId);
      $sMsg     = 'SDERFDffffff';  // 解析之后的明文

      $err_code = $wxcpt->DecryptMsg($msg_signature, $timestamp, $nonce, $sReqData, $sMsg);
      //$xmls = simplexml_load_string($sMsg, 'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象


return  $err_code;*/



    // $sReqData = file_get_contents("php://input");
    //return $sReqData;
    //$xml =  simplexml_load_string($sReqData,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
    // $ToUserName = $xml->ToUserName;






    //$file = "./909090.txt";//这是xml格式的数据
    //$file1 = "./909091.txt";//这是json的数据
    //     $sReqData = file_get_contents('php://input');
    // return// $sReqData;
    // file_put_contents($file, "获取验证票据（新）" . date('Y-m-d H:i:s') . "\n" . $sReqData . "\n", FILE_APPEND);
    // file_put_contents($file1, json_encode($_GET), FILE_APPEND);
    // $a['msg_signature'] = $msg_signature;
    //  $a['timestamp'] = $timestamp;
    //  $a['nonce'] = $nonce;
    //      $xml =  simplexml_load_string($sReqData, 'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
    // 、、 dump($xml);
    //return  "SSSSSSSSSSS". json_decode(json_encode($xmls), 1);;
    //$ToUserName = $xml->ToUserName;
    //     $ToUserName = "ssssssssssss";
    //return $ToUserName;
    //if ($suiteId == $ToUserName) { //证明是企业微信后台推送
    //db("enterprise_set")->where(['suite_id' => $ToUserName])->update(['msg_signature' => $a['msg_signature'], 'timestamp' => $a['timestamp'], 'nonce' => $a['nonce'], 'createtime' => time()]);
    //$set = db("enterprise_set")->where(['suite_id' => $ToUserName])->find();
    //         $set=array('msg_signature'=>'aaa','timestamp'=>'12345678909','nonce'=>"dvdvdv");
    // print_r($ToUserName);die;
    //include_once EXTEND_PATH . "callback/WXBizMsgCrypt.php";//导入企业微信的解密文件
    //         $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $ToUserName);

    //         $sMsg     = '';  // 解析之后的明文
    //         $err_code = $wxcpt->DecryptMsg($set['msg_signature'], $set['timestamp'], $set['nonce'], $sReqData, $sMsg);
    //        $xmls = simplexml_load_string($sMsg, 'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
    //if ($err_code == 0) {
    //     if ($xmls->InfoType) {
    //         $xmls = json_decode(json_encode($xmls), 1);
    //               $suite_ticket = $xmls['SuiteTicket'];
    //               echo   $suite_ticket ;
    //         if (!empty($suite_ticket)) {
    //保存下获取到数据
    //              db("enterprise_set")->where(['suite_id' => $ToUserName])->update(['suite_ticket' => $suite_ticket]);
    //                      echo 'success';  // 返回企业微信消息 success
    //           } else {
    //             echo 200; //错误信息
    //           }
    //     }
    //   }
    //}
}
function ffgg(){
    $encodingAesKey ='J3N3MbJQ9QAlrlMhFW9Tmf1PIJg9xNXQsYQhYcX3EfM';              //这是已有的值
    $token = "sRVzMAL5Nqxa";                                                    //这是已有的值
    $corpId ="ww0328d5bc6e988741";                                              //  企业ID //这是已有的值
    $suiteId = "ww89216d45463b353d";                                            //  应用id //这是已有的值


    $msg_signature = $_GET['msg_signature'] ?? 0;       //这是回调过来企业微信给的数据
    // return $msg_signature;
    $timestamp = $_GET['timestamp'] ?? 0;               //这是回调过来企业微信给的数据
    $timestamp = time();
    //return $timestamp;
    $nonce = $_GET['nonce'] ?? 0;                       //这是回调过来企业微信给的数据
    $echostr = $_GET['echostr'] ?? 0;



    $sReqData="<xml><ToUserName>
        <![CDATA[ww89216d45463b353d]]>
    </ToUserName>
    <Encrypt>
        <![CDATA[JRIpXafJP3kroZrCLIeT3moOTXLM6zO62xZ9m83oavsYZeI/Qrh7A0HkFKzNuEvRbsBi59k+/Qk3nxcRKwGoszxnp95B42za/o3CCHY6hUlUYSj0k9ehqFJ0NsVG7Zt6dqm4GPd/67KJR2z//a2lyQMe+UC0F447oJNowQd8JTs3WQmDXQdJrjkrkxQy5yMQbQ1uQ+m6UV54+i8qsGPFBrKBCTjuQDtxPxUVvOF2JSU/b/AG4alUrbd31WY7kCQRAdvYhZT+rnSfN+zyjDZMBX9mNs1kV7536X2rwbp029/Cm1/+ExQKIHNuBEuFEIik8KmdeMQ1Z38vwoD++q+TbR4qZjYCyBh31gtBbO/XBOKGQTiSjgSebuEvITb1b9ki]]>
        </Encrypt>
    <AgentID>
        <![CDATA[]]>
    </AgentID>
</xml>";
    $xml =  simplexml_load_string($sReqData,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象
    $ToUserName = trim($xml->ToUserName);
    //、、 .. return $xml;

    $sEchoStr = "RTRTg";
    $wxcpt = new \WXBizMsgCrypt($token, $encodingAesKey, $ToUserName);
    $sMsg     = 'RTRTg';  // 解析之后的明文
    $errCode = $wxcpt->VerifyURL($msg_signature, $timestamp, $nonce, $echostr, $sEchoStr);
    $err_code = $wxcpt->DecryptMsg($msg_signature, $timestamp, $nonce, $sReqData, $sMsg);
    //return $errCode;
    return $err_code;
    return $sMsg;
    // $xmls = simplexml_load_string($sMsg,'SimpleXMLElement', LIBXML_NOCDATA); //  xml格式转成对象


    //api.lxx.cn/weixin/getSuiteTicket?msg_signature=3be864204601afa2f9b65060a3da3b33462d00a4&timestamp=1637039712&nonce=lnzd4hoh40s&echostr=
    //245%2FbAUnuLxlha665bY64H%2F5Zm2RIVxVBfh5fPe6l67HdN173hpoErgPBWcKyS%2BRSWqVOC2g%2FOez%2BqEEtEpoxw%3D%3D
}
