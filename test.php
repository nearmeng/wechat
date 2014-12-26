<?php

  require_once('functions.php');

  $sql="select keyword,title,description,type,picurl,url from articles where keyword='help' and keyword_type='equals'";
  $result=mysql_query($sql); 
  $row			=	mysql_fetch_row($result);
  $title 			=	$row[1];
  $type 			=	$row[3];
  $description 	=	$row[2];

  echo $title.$type.$description;


?>