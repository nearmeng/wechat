<?php

    require_once("echarts.php");

    $option = array(
        "legend"=>array("邮件营销","联盟广告","视频广告","直接访问","搜索引擎"),
        "xaxis"=>array("type"=>"category","boundaryGap"=>"true","data"=>array("周一","周二","周三","周四","周五","周六","周日")),     
        "series"=>array(
                    array("name"=>"邮件营销","type"=>"bar","stack"=>"总量","data"=>array("120","132","101","134","90","230","210")),                  
                    array("name"=>"联盟广告","type"=>"bar","stack"=>"总量","data"=>array("220","182","191","234","290","330","310")),             
                    array("name"=>"视频广告","type"=>"bar","stack"=>"总量","data"=>array("150","232","201","154","190","330","410")),             
                    array("name"=>"直接访问","type"=>"bar","stack"=>"总量","data"=>array("320","332","301","334","390","330","320")),                 
                    array("name"=>"搜索引擎","type"=>"bar","stack"=>"总量","data"=>array("820","932","901","934","1290","1330","1320")),          
                ),
        );

    $ec = new Echarts();
    echo $ec->show('chartArea', $option);   // 显示在指定的dom节点上    

    // 饼形图模拟数据
    $optionPie = array(
        "legend"=>array("邮件营销","联盟广告","视频广告","直接访问","搜索引擎"),
        "series"=>array(
                array("name"=>"邮件营销","type"=>"pie","stack"=>"总量",
                        "data"=>array(
                                array("value"=>"335","name"=>"直接访问"),
                                array("value"=>"310","name"=>"邮件营销"),
                                array("value"=>"234","name"=>"联盟广告"),
                                array("value"=>"135","name"=>"视频广告"),
                                array("value"=>"1548","name"=>"搜索引擎"),
                        ),
                ),
        ),
    );
    
    $ec = new Echarts();
    echo $ec->show('pieArea', $optionPie);  // 显示在指定的dom节点上
 ?>