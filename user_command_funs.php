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
		$note_content = trim($note_content);
		mysql_query("insert into notes (uid,content) values('{$fromUsername}','{$note_content}')");
		//返回操作完成消息
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}

	//展示日记
	function list_notes($keyword, $starwith_str, $description, $fromUsername, $toUsername)
	{
		global $textTpl;
		$time = time();
		$msgType = 'text';
		$contentStr = $description."\n";
		//从数据库中拉取数据
		$note_sql_result = mysql_query("select content from notes where uid='{$fromUsername}'");
		while ($row=mysql_fetch_row($note_sql_result))
		{
			$contentStr .= $row[0]."\n";
		}
		//返回操作数据
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}

	function remove_notes($keyword, $starwith_str, $description, $fromUsername, $toUsername)
	{
		global $textTpl;
		$time = time();
		$msgType = 'text';
		$contentStr = $description;
		//删除数据库
		mysql_query("delete from notes where uid='{$fromUsername}')");
		//返回操作完成消息
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}


?>
