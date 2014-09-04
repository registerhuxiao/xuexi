<?php
————————————————————————回复文字--------------------------------------------------------------------------------------------
    if($form_MsgType=="text")                                                                                          //判断是否是文字
    {
            $form_Content=trim($postObj->Content);                                                                     //去掉头尾的空格
            if(!empty($form_Content))                                                                                  //内容是否为空
            {
                $msgType="text";                                                                                       //回复信息的种类为text
                $resultStr=sprintf($textTpl, $fromUsername, $toUsername,time(),$msgType, $form_Content);                //封装
                echo $resultStr;
                exit;
            }else
            {
                $msgType="text";
                $resultStr=sprintf($textTpl, $fromUsername, $toUsername,time(),$msgType, "input something");
                echo $resultStr;
                exit;
            }

    }


 ---------------------------------------------------------------------------------------------------------------------------------------------------


 -----------------------------------------------------回复多图文-----------------------------------------------------------------------------------
    $resultStr="<xml>\n
     <ToUserName><![CDATA[".fromUsername"]></ToUserName>\n
     <FromUserName><![CDATA[".toUsername:]]></FromUserName>\n
     <CreateTime>".time()"</CreateTime>\n
     <MsgType><![CDATA[news]]></MsgType>\n
     <ArticleCount>3</ArticleCount>\n
     <Articles>\n";
         $return_arr=array(
            array(
                "1"
                "http://testofhu-weixincourse.stor.sinaapp.com/pic/1.png"
                "http://www.baidu.com"
            ),
            array(
                "2"
                "http://testofhu-weixincourse.stor.sinaapp.com/pic/2.png"
                "http://www.sina.com.cn"
            )
         );

         foreach($return_arr as $value)
         {
             $resultStr.="
             <item>\n
             <Title><![CDATA[".value[0]"]></Title>\n
             <Description><![CDATA[]]></Description>\n
             <PicUrl><![CDATA[".value[1]"]></PicUrl>\n
             <Url><![CDATA[".value[2]"]></Url>\n

         </item>\n";
         }

        $resultStr.="</Articles>\n
        <FuncFlag>0</FuncFlag>\n
        </xml>";

