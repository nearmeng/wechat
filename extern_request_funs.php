<?php

	include_once('config.php');

	function zhihu($json_content, $keyword, $fromUsername, $toUsername, $msgType2)
	{
        global $itemTpl,$newsTpl;
		$item_str1 = "";
        //foreach ($json_content['stories'] as $item){
        for($i = 0; $i < 5; $i++) {
            $item = $json_content['top_stories'][$i];
           	$item_str1 .= sprintf($itemTpl, $item['title'], "", $item['image'], "http://daily.zhihu.com/story/".$item['id']);
        }
        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, time(), $msgType2, 5, $item_str1);
        return $resultStr;
	}






?>
