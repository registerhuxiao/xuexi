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
            $newsTpl="<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <ArticleCount>2</ArticleCount>
                            <Articles>
                            <item>
                            <Title><![CDATA[保险法]]></Title>
                            <Description><![CDATA[对我们大家都更好]]></Description>
                            <PicUrl><![CDATA[http://testofhu-weixincourse.stor.sinaapp.com/pic/1.png]]></PicUrl>
                            <Url><![CDATA[http://www.baidu.com]]></Url>
                            </item>
                            <item>
                            <Title><![CDATA[先法]]></Title>
                            <Description><![CDATA[对我们]]></Description>
                            <PicUrl><![CDATA[http://testofhu-weixincourse.stor.sinaapp.com/pic/2.png]]></PicUrl>
                            <Url><![CDATA[http://www.sohu.com]]></Url>
                            </item>
                            </Articles>
                            <FuncFlag>0</FuncFlag>
                            </xml> ";

            $newsTplXML="<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <ArticleCount>1</ArticleCount>
                            <Articles>";


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

                    //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $SentMsgType, $contentStr);
                    /********************************************************************图文回复**********************************************************/
                    $resultStr=sprintf($newsTpl,$fromUsername, $toUsername, time());
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
                /**************************************************************************************************************************************/
                echo $resultStr;
            }elseif($MsgType=="location")
            {
                $latitude=$postObj->Location_X;
                $longitude=$postObj->Location_Y;
                /*****************************************************返回经纬度************************************************************************/
                $contentStr="你的维度是{$latitude},经度是{$longitude}.";
                $SentMsgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $SentMsgType, $contentStr);
                /***************************************************************************************************************************************/
                $newsTplXML.="<item>
                            <Title><![CDATA[导航]]></Title>
                            <Description><![CDATA[点击我们后导航到公司]]></Description>
                            <PicUrl><![CDATA[http://testofhu-weixincourse.stor.sinaapp.com/pic/1.png]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
                            </Articles>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
                /***************************************************导航回复****************************************************************************/
                $url="http://mo.amap.com/navi/?start=$longitude,$latitude&dest=106.124909,38.498451&destName=%E9%AB%98%E5%BE%B7%E8%BD%AF%E4%BB%B6%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&key=76c1d8fc75b9d036b3ac72d56f651434";
                $resultStr=sprintf($newsTplXML,$fromUsername,$toUsername,time(),$url);
               /******************************************************************************************************************************************/

                echo $resultStr;

            }else
            {
                $contentStr="此项功能还未开发";
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