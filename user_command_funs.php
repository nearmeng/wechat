<?php

	//自定义的方法都可以写到这个里面来
	function show($keyword, $startwith_str, $fromUsername, $toUsername)
	{
		
		$textTpl 	=  "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		<FuncFlag>0</FuncFlag>
		</xml>";  
		$time 		= time();
		$msgType 	= "text";
		$contentStr	= "您输入的是，这是一个自定义的方法：".$keyword;
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		mysql_query("insert into messages (uid,content) values('{$fromUsername}','{$keyword}')");
		return $resultStr;
	}
	
	function yourfunction($keyword, $key, $fromUsername, $toUsername)
	{
		//..........
	}










?>