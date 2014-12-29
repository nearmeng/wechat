<?php

header("Content-type:text/html;charset=utf-8");

  	$url_request = "http://news-at.zhihu.com/api/3/news/latest"; 
  	$url_response = file_get_contents($url_request);
    echo "response".$url_response.'<br />';
 	$json_content = json_decode($url_response, true);

    echo "json_data:".$json_content;

    var_dump($json_content);

    $item_str = "";
    if(is_array($json_content['stories']))
    {
    	foreach ($json_content['stories'] as $item){
    	echo "item is array".is_array($item)." ";
    	echo $item['title'].'<br />';
    	echo $item['images'][0].'<br />';
    	echo "http://daily.zhihu.com/story/".$item['id'].'<br />';
    	}
    }
    else
    {
    	echo "It is not array";
    }
    
    $Cname1 = "南京南站";
    $Cname2 = "百家湖";

    echo urlencode($Cname1)." ".urlencode($Cname2);

?>
