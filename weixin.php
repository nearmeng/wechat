<?php
  require_once('config.php');
  require_once('weixin_auth.php');
  require_once('user_command_funs.php');
  
  $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
  $file = 'debug.txt';
  $ip = fopen($file,'w');

  //首次进行认证处理
  if (isset($_GET['echostr']))
  {
  		$wechatObj = new wechatCallbackapiTest();
  		$wechatObj->valid();
  }
 
  //进行消息处理
  if (!empty($postStr)){
  	$postObj 	= simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
	$mType 		= $postObj->MsgType;


		if($mType =='text')
		{
			$fromUsername 	= $postObj->FromUserName;
			$toUsername 	= $postObj->ToUserName;
			$keyword 		= trim($postObj->Content);
			$time 			= time();
   			if(!empty( $keyword ))
            {  
				    $sql="select keyword,title,description,type,picurl,url from articles where keyword='{$keyword}' and keyword_type='equals'";
				    $result=mysql_query($sql); 
					$num = mysql_num_rows($result);
					//如果整体没有找到对应的关键词 查看是否是自定义的命令
					if($num<1){
								//找出数据库中自定义命令集合
						  		$sql="select keyword,title from articles where keyword_type='startwith'";
				             	$result=mysql_query($sql); 
				 
				             	$starwith		=	false;
				             	$starwith_str	=	"";
				             	$starwith_func	= 	"";
				             	//在自定义命令中查找
				             	while ($row=mysql_fetch_row($result))
								{
				 					$_keyword		= 	$row[0];
									$len 			= 	strlen($_keyword);
									if( substr($keyword,0,$len) == $_keyword )
									{
										$starwith_str 	= $_keyword;
										$starwith_func	= $row[1];
										$starwith		= true;
										break;
									}
								}
								//如果找到自定义命令，则调用自定义处理函数进行处理
								if( $starwith )
								{
									 $starwith_func($keyword, $starwith_str, $fromUsername, $toUsername);
								}
								//否则返回404
								else
								{
									$contentStr	=	$NO_RESPONSE;
									
									$msgType 	= "text";
									$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
									echo $resultStr;	
								}
				 
					}
					//如果找到了相同的关键词
					else{
						//有匹配的数据
						$row			=	mysql_fetch_row($result);
						$title 			=	$row[1];
						$type 			=	$row[3];
						$description 	=	$row[2];
						$time 			=  time();
						$picurl 		=	$row[4];
						$url 			=	$row[5];
						//将url中的[[wxid]]换成$fromUserName
						$url = str_replace("[[wxid]]", $fromUsername, $url);		// 替换微信的ID
						//根据消息类型进行xml组装和发送
                        fwrite($ip, $type);
						if( "text" == $type )
						{
							$contentStr	=	$description;
							$contentStr = str_replace("[[wxid]]", $fromUsername, $contentStr);		// 替换微信的ID
							$msgType 	= "text";
							$resultStr 	= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $resultStr;
						}
						else if( "news" == $type )
						{
							$msgType1  = "news";
							$resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType1, $title,$description,$picurl,$url);
							echo $resultStr;
						}
						else if( $type == "extern_request")
						{
							$msgType2 = "news";
        					$url_request = "http://news-at.zhihu.com/api/3/news/latest"; 
        					$url_response = file_get_contents($url_request);
        					$json_content = json_decode($url_response, true);
                            
        					$item_str = "";
        					foreach ($json_content['stories'] as $item){
           				 		$item_str .= sprintf($itemTpl, $item['title'], "", $item['images'][0], "http://daily.zhihu.com/story/".$item['id']);
        					}
        					$resultStr = sprintf($newsTpl, $FromUserName, $ToUserName, $time, $msgType2, $item_str, count($json_content['stories']));
        					echo $resultStr;
						}
						mysql_query("insert into messages (uid,content) values('{$fromUsername}','{$keyword}')");
					}
            }
	              	 
		                
	    }elseif($mType =='event')
	    {
	    	$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$location_x = $postObj->Location_X;
			$location_y = $postObj->Location_Y;
			$scale = $postObj->Scale;
			$label = $postObj->Label;
			$time = time();

			 $contentStr =$WELCOME_MSG;   
			 $msgType = "text";
			 //首次将用户插入数据库
			 $sql1="select * from sj where wxid='{$fromUsername}'";
             $result1=mysql_query($sql1);
             $num1 = mysql_num_rows($result1);
			 if($num1<1)
			 mysql_query("insert into sj (wxid) values('{$fromUsername}')");
			//发送给用户欢迎消息
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
   			echo $resultStr;
	    }
	    elseif($mType =='location')
	    {
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$location_x = $postObj->Location_X;
			$location_y = $postObj->Location_Y;
			$scale = $postObj->Scale;
			$label = $postObj->Label;
			$time = time();
			$contentStr = "您更新了您的位置信息";              
			$msgType = "text";
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			//将用户位置信息放入数据库
			mysql_query("update sj set x='{$location_x}',y='{$location_y}',dz='{$label}',last_update='{$time}' where wxid='{$fromUsername}'");
			echo $resultStr;
	     }
       
	}else {
		echo "";
		exit;
	}

	fclose($ip);


?>
