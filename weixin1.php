<?php
/*

*/

define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
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

    public function responseMsg()
    {
        
	$conn = @ mysql_connect("localhost","root","madong") or die("die");
	mysql_select_db("data",$conn);
	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr))
	{
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
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
if($RX_TYPE=="text")
{
		if($keyword=="?" || $keyword=="？")
		{
			$contentStr="直接点击菜单可执行相关操作，";
		}		
		
		if ($keyword=="开灯" || $keyword=="3")
		{			
			$sql="update data1 set info='3' where id='1'";
			mysql_query($sql);
			$contentStr="灯已打开";						
		}
		elseif ($keyword=="关灯"  || $keyword=="2")
		{			
			$sql="update data1 set info='2' where id='1'";
			mysql_query($sql);
			$contentStr="灯已关闭";
		}    
		elseif ($keyword=="开门"  || $keyword=="4")
		{
			$sql="update data1 set info='4' where id='1'";
			mysql_query($sql);
			$contentStr="门已打开";				
		}
		elseif ($keyword=="关门"  || $keyword=="5")
		{
			$sql="update data1 set info='5' where id='1'";
			mysql_query($sql);
			$contentStr="门已关闭";
		}
		elseif ($keyword=="开窗"  || $keyword=="0")
		{
			$sql="update data1 set info='0' where id='1'";
			mysql_query($sql);
			$contentStr="窗帘已打开";				
		}
		elseif ($keyword=="关窗"  || $keyword=="1")
		{
			$sql="update data1 set info='1' where id='1'";
			mysql_query($sql);
			$contentStr="窗帘已关闭";
		}
		elseif ($keyword=="摄像头监控")
		{
			$contentStr="监控";
		}
         	elseif ($keyword=="温度")
		{
		//$sql="select * from wendu limit 0,1";
		//$query=mysql_query($sql);
		//$row=mysql_fetch_array($query)
		//$contentStr=$row[wendu].$row[time]."jakjfkljd";
		$contentStr="wendu";		
		}
            	elseif ($keyword=="联系我们")
		{
		$contentStr="联系我们";
		}
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time,$msgType, $contentStr);
                echo $resultStr;

}
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
		//$sql="select * from wendu limit 0,1";
		//$query=mysql_query($sql);
		//$row=mysql_fetch_array($query)
		//$contentStr=$row[wendu].$row[time]."jakjfkljd";
		$contentStr="wendu";		
		}
            	elseif ($event=="CLICK" and $EventKey=="联系我们")
		{
		$contentStr="联系我们";
		}
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time,$msgType, $contentStr);
                echo $resultStr;
}	
        }
	else
	{
            echo "";
            exit;
        }

    }
}
?>
