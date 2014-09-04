*if($form_MsgType=="text")
{
//获取用户发送内容
$form_Content=trim($postObj->Content);// trim 可以去除字符串前后的空格
if(!empty($form_Content))
{
$msgType="text";
$resultStr=sprintf($textTpl,$fromUsername,time(),$msgType,$form_Content);
echo resultStr;
exit;
}else{
$msgType="text";
$resultStr=sprintf($textTpl ,$fromUsername,time(),$msgType,"书店吧");
echo resultStr;
exit;
}

}*/