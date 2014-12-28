<?php
  
//*************************里面的内容根据自己实际情况自行修改**************************// 	
	$_hostname	= 'localhost'; 
	$_username	= 'root';    	//你的数据库的用户名
	$_password	= 'open';		//你的数据库的密码
	$_dbname	= "wechat_db";	    //数据库的名称

	//用户关注后的欢迎词，根据自己的微信公众账号修改
	$WELCOME_MSG = "很高兴您使用本系统，我们将为您提供更好的信息服务，输入help获取更多帮助";
	//用户输入的关键词系统中还没有 ，进行信息提示
	$NO_RESPONSE = "查询的内容不存在，请输入help获取更多的内容";
//***********************************************************************************//	

	
    $textTpl 	=  "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>"; 
	$itemTpl  = "<item>
        					<Title><![CDATA[%s]]></Title>
        					<Description><![CDATA[%s]]></Description>
        					<PicUrl><![CDATA[%s]]></PicUrl>
        					<Url><![CDATA[%s]]></Url>
    						</item>";
	$newsTpl    =   "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>%s</ArticleCount>
					<Articles>%s</Articles>
					<FuncFlag>1</FuncFlag>
				    </xml>"; 
	// 连接dB
	$conn = mysql_connect($_hostname, $_username, $_password);
	mysql_select_db($_dbname, $conn);
	mysql_query("set names utf8");
 
?>
