<?php

	include_once('config.php');
	
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
		//如果输入的笔记为空 
		if($note_content == '')
		{
			$contentStr = "您输入的笔记内容为空，请重新输入";
		}
		else
		{
			mysql_query("insert into notes (uid,content) values('{$fromUsername}','{$note_content}')");
		}
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
		$note_num = mysql_num_rows($note_sql_result);
		if($note_num == 0)
		{
			$contentStr = "您当前没有笔记数据";
		}
		else
		{
			while ($row=mysql_fetch_row($note_sql_result))
			{
				$contentStr .= $row[0]."\n";
			}
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
		mysql_query("delete from notes where uid='{$fromUsername}'");
		//返回操作完成消息
		$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}


?>
