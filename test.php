<?php

  	$url_request = "http://news-at.zhihu.com/api/3/news/latest"; 
  	$url_response = file_get_contents($url);
 	$json_content = json_decode($url_response, true);

    $item_str = "";
    if(is_array($json_content['stories']))
    {
    	foreach ($json_content['stories'] as $item){
    	echo "item is array".is_array($item)." ";
    	echo $item['title'].'<br />';
    	echo $item->images[0].'<br />';
    	echo "http://daily.zhihu.com/story/".$item['id'].'<br />';
    	}
    }
    else
    {
    	echo "It is not array";
    }
    


?>