<?php
/*
	智能家居 2015-03-28  在自定义菜单上添加语音识别功能 by___xcy
*/

define("TOKEN", "weixin");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    //验证消息
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    //检查签名
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    //响应消息
    public function responseMsg()
    {
        $conn = @ mysql_connect("localhost","root","madong") or die("die");
        mysql_select_db("data",$conn);
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
			//调用代码
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $event=$postObj->Event;
            $EventKey=$postObj->EventKey;
            $keyword = trim($postObj->Content);
			$time = time();
            $RX_TYPE = trim($postObj->MsgType);
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            $msgType = "text";
if($RX_TYPE=="event")
{
                if($event=="subscribe")
                {
                        $contentStr="欢迎关注本微信公众号，回复“？”获取帮助";
                }
                if ($event=="CLICK" and $EventKey=="开灯")
                {
                        $sql="update data1 set info='3' where id='1'";
                        mysql_query($sql);
                        $contentStr="灯已打开";
                }
                elseif ($event=="CLICK" and $EventKey=="关灯")
                {
                        $sql="update data1 set info='2' where id='1'";
                        mysql_query($sql);
                        $contentStr="灯已关闭";
                }
                elseif ($event=="CLICK" and $EventKey=="开门")
                {
                        $sql="update data1 set info='4' where id='1'";
                        mysql_query($sql);
                        $contentStr="门已打开";
                }
                elseif ($event=="CLICK" and $EventKey=="关门")
                {
                        $sql="update data1 set info='5' where id='1'";
                        mysql_query($sql);
                        $contentStr="门已关闭";
                }
                elseif ($event=="CLICK" and $EventKey=="开窗")
                {
                        $sql="update data1 set info='0' where id='1'";
                        mysql_query($sql);
                        $contentStr="窗帘已打开";
                }
                elseif ($event=="CLICK" and $EventKey=="关窗")
                {
                        $sql="update data1 set info='1' where id='1'";
                        mysql_query($sql);
                        $contentStr="窗帘已关闭";
                }
 elseif ($event=="CLICK" and $EventKey=="摄像头监控")
                {
                        $contentStr="监控";
                }
                elseif ($event=="CLICK" and $EventKey=="温度")
                {
                $conn=@mysql_connect('localhost','root','madong')or die
("fail");
                mysql_select_db("data",$conn);
                $sql="select * from wendu where id='1'";
                $query=mysql_query($sql);
                while($row=mysql_fetch_array($query))
                $contentStr="persent temperture ".$row[1].$row[2];

                }
                elseif ($event=="CLICK" and $EventKey=="联系我们")
                {
                $contentStr="联系我们";
                }
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, 
$time,$msgType, $contentStr);
                echo $resultStr;
}
else{
            switch ($RX_TYPE)
            {
				case "voice":
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
            }
            $this->logger("T ".$result);
            echo $result;
        }
		}
    }

    //接收文本、语音消息
    private function receiveText($object)
    {
        if (!empty($object->Recognition)){
            $keyword = trim($object->Recognition);
            $mediaid = trim($object->MediaID);
        }else{
            $keyword = trim($object->Content);
        }
        switch ($keyword)
        {
            case "文本":
                $content = "这是个文本消息";
                break;
			case "开灯":
				{
					$sql="update data1 set info='3' where id='1'";
                    mysql_query($sql);
                    $content="灯已打开";
				}
                break;
			case "关灯":
				{
					$sql="update data1 set info='2' where id='1'";
                    mysql_query($sql);
                    $content="灯已关闭";
				}
                break;
			case "开门":
				{
					$sql="update data1 set info='4' where id='1'";
                    mysql_query($sql);
                    $content="门已打开";
				}
                break;
			case "关门":
				{
					$sql="update data1 set info='5' where id='1'";
                    mysql_query($sql);
                    $content="门已关闭";
				}
                break;
			case "开窗":
				{
					$sql="update data1 set info='0' where id='1'";
                    mysql_query($sql);
                    $content="窗帘已经打开";
				}
                break;
			case "关窗":
				{
					$sql="update data1 set info='1' where id='1'";
                    mysql_query($sql);
                    $content="窗帘已经关闭";
				}
                break;
			case "温度":
				{
					$conn=@mysql_connect('localhost','root','madong')or die
("fail");
                mysql_select_db("data",$conn);
                $sql="select * from wendu where id='1'";
                $query=mysql_query($sql);
                while($row=mysql_fetch_array($query))
                $content="persent temperture".$row[1]." ".$row[2];
				}
                break;
            default:
                $content = date("Y-m-d H:i:s",time())." 我们无法识别你的语言：".$keyword;
                break;
        }
        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }
/***********************************
		分割线
***********************************/

    //回复文本消息
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}
?>