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

	//删除日志
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

	//跟踪南京江宁公交车
	function trace_bus($keyword, $starwith_str, $description, $fromUsername, $toUsername)
	{
		global $textTpl;
		$time = time();
		$msgType = 'text';
		//1 取出相应的数据并检查
		$trace_info = substr($keyword, strlen($starwith_str), strlen($keyword)-strlen($starwith_str));
		$trace_info = trim($trace_info);
		$row=split(' ', $trace_info);
		//1.1 检查上下行
		if($row[0] == "进城")
		{
			$up_or_down = 1;
		}
		else if($row[0] == "下乡")
		{
			$up_or_down = 2;
		}
		else
		{
			$contentStr = "你要进城还是下乡哇，请重新输入！格式：#跟踪 上(下)行 公交名 所在站点";
			$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			return $resultStr;
		}
		//1.2 根据数据库返回line_id
		$line_id_sql_result = mysql_query("select lineId from jnbus where lineName='{$row[1]}'");
		$query_num = mysql_num_rows($line_id_sql_result);
		if($query_num == 1)
		{
			$row1=mysql_fetch_row($line_id_sql_result);
			$line_id = $row1[0];
		}
		else
		{
			$contentStr = "您输入的公交线路本系统没有收录，sorry";
			$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			return $resultStr;
		}
		if($row[2] == "")
		{
			$contentStr = "您所在的站点名为空，请重新输入！格式：#跟踪 上(下)行 公交名 所在站点";
			$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			return $resultStr;
		}

		//2 获得该条公交线的信息
		$url_request = "http://112.2.33.3:5902/BusAndroid/android.do?command=toSta&lineId=".$line_id."&inDown=".($up_or_down==1?2:1); 
        $url_response = file_get_contents($url_request);
        $json_content = json_decode($url_response, true);
        $station_num = $json_content['total'];

        foreach ($json_content['rows'] as $key => $value) 
        {
        	$station_name[$key] = $value['text']; 
        }

        $user_station_id = -1;
        foreach ($station_name as $key => $value) {
        	if($value == $row[2])
        	{
        		$user_station_id = $key;
        	}
        }
        if($user_station_id == -1)
        {
        	$contentStr = "您输入的所在站点不存在，请重新输入！格式：#跟踪 上(下)行 公交名 所在站点";
			$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			return $resultStr;
        }

		//3 获得目前距离用户最近的公交站
		$url_request = "http://112.2.33.3:5902/BusAndroid/android.do?command=toDis&lineId=".$line_id."&inDown=".$up_or_down."&stationNo=".$station_num; 
        $url_response = file_get_contents($url_request);
        $json_content = json_decode($url_response, true);

        $best_bus = -1;
        $min_distance = $station_num;

        foreach ($json_content['rows'] as $item) {
        	if(($item['stationNo']-$user_station_id) > 0 && ($item['stationNo']-$user_station_id) < $min_distance) 
        	{
        		$min_distance = ($item['stationNo']-$user_station_id);
        		$best_bus = $item['carZbh'];
        		$best_bus_station = $item['stationName'];
        	}
        }
        if($best_bus == -1)
        {
        	$contentStr = "当前线路上没有合适的公交车";
			$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			return $resultStr;
        }

		//4 形成结果反馈给用户
        $contentStr = "最近的公交车(".$best_bus.")正处于(".$best_bus_station.")\n 距离您(".$min_distance.")站,请耐心等候。";
        $resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}


?>
