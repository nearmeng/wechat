<?php

	include_once('config.php');

	//自定义的方法都可以写到这个里面来
	function show($keyword, $startwith_str, $description, $fromUsername, $toUsername)
	{
		global $textTpl;  
		$time 		= time();
		$msgType 	= "text";
		$contentStr	= "您输入的是，这是一个自定义的方法：".$keyword;
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		mysql_query("insert into messages (uid,content) values('{$fromUsername}','{$keyword}')");
		return $resultStr;
	}
	
	//写日记
	function write_notes($keyword, $starwith_str, $description, $fromUsername, $toUsername)
	{
		global $textTpl;
		$time = time();
		$msgType = 'text';
		$contentStr = $description;
		//数据插入数据库
		$note_content = substr($keyword, strlen($starwith_str), strlen($keyword)-strlen($starwith_str));
		mysql_query("insert into notes (uid,content) values('{$fromUsername}','{$note_content}')");
		//返回操作完成消息
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}










?>