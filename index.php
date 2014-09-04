<?php
/**
 * wechat php test
 */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $MsgType=$postObj->MsgType;
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";


/***************************************************关键词回复******************************************************************/
            if($MsgType=="text")
            {
                if(!empty( $keyword ))
                {
                    $SentMsgType = "text";

                    switch($keyword)
                    {
                        case "1":
                            $contentStr="1";
                            break;
                        case "2":
                            $contentStr="2";
                            break;
                        case "3":
                            $contentStr="3";
                            break;
                        default:
                            $contentStr="bybe";
                    }

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $SentMsgType, $contentStr);
                    echo $resultStr;
                }else{
                    $contentStr="Input something...";
                    $SentMsgType = "text";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $SentMsgType, $contentStr);
                    echo $resultStr;
                }

            }elseif($MsgType=="image")
/*******************************************************图片回复*********************************************************************/
            {
                $contentStr="你的图片真棒";
                $SentMsgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $SentMsgType, $contentStr);
                echo $resultStr;
            }

        }else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

?>