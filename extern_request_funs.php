<?php


	function($json_content, $keyword, $fromUsername, $toUsername, $msgType2)
	{
		$item_str1 = "";
        //foreach ($json_content['stories'] as $item){
        for($i = 0; $i < 10; $i++) {
            $item = $json_content['stories'][$i];
           	$item_str1 .= sprintf($itemTpl, $item['title'], "", $item['images'][0], "http://daily.zhihu.com/story/".$item['id']);
        }
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, time(), $msgType2, 10, $item_str1);
        return $resultStr;
	}






?>