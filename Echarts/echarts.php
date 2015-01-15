<?php
//Echarts php 封装
class Echarts{

     public static function show($id, array $data){
    
        $xaxis = "";
        $series = "";
            
        if (empty($data)) {         
            $data = array(
                'legend' => array(
                    'data' => array('-')
                ),
                'xaxis' => array(
                    'type' => 'category',
                    'boundaryGap' => 'false',
                    'data' => array('')
                ),
                'series' => array(
                    array(
                        'name' => '-',
                        'type' => 'line',
                        'itemStyle' => "{normal: {areaStyle: {type: 'default'}}}",
                        'data' => array()
                    ),
                )
            );
        }

        foreach ($data as $key => $value) {
            switch ($key) {
                case 'legend':
                    foreach ($value as $k => $v) {
                        switch ($k) {
                            case 'data':
                                $legend = $k . ':' . json_encode($v);
                                break;
                        }
                    }
                    break;
                    
                case 'xaxis':
                    foreach ($value as $k => $v) {
                        switch ($k) {
                            case 'type':
                                $xaxis[] = $k . ":'" . $v . "'";
                                break;
                            case 'boundaryGap':
                                $xaxis[] = $k . ':' . $v;
                                break;
                            case 'data':
                                $xaxis[] = $k . ':' . json_encode($v);
                                break;
                        }
                    }
                    $xaxis = '{' . implode(', ', $xaxis) . '}';
                    break;
                    
                case 'series':
                    foreach ($value as $list) {
                        $tmp = array();
                        foreach ($list as $k => $v) {
                            switch ($k) {
                                case 'name':
                                case 'type':
                                    $tmp[] = $k . ":'" . $v . "'";
                                    break;
                                case 'itemStyle':
                                    $tmp[] = $k . ':' . $v;
                                    break;
                                case 'data':
                                    $tmp[] = $k . ':' . json_encode($v);
                            }
                        }
                        $series[] = '{' . implode(', ', $tmp) . '}';
                    }
                    $series = implode(', ', $series);
                    break;
            }
        }

        $script = <<<eof
            <script type="text/javascript">
            // Step:3 conifg ECharts's path, link to echarts.js from current page.
            // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径

            // 把所需图表指向单文件
            require.config({
                paths:{
                    echarts:'./js/echarts',
                    'echarts/chart/bar' : './js/echarts',   
                    'echarts/chart/line': './js/echarts',
                    'echarts/chart/pie': './js/echarts'
                }
            });

            // Step:4 require echarts and use it in the callback.
            // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径

            // 按需加载所需图表
            require(
                [
                    'echarts',
                    'echarts/chart/bar',
                    'echarts/chart/line',
                    'echarts/chart/pie'
                ],
                function(ec) {
                    var myChart = ec.init(document.getElementById('$id'));
                    var option = {
                        title : {
                            text: '',
                            subtext: ''
                        },
                        tooltip : {
                            trigger: 'axis'
                        },
                        legend: {
                            $legend
                        },
                        toolbox: {
                            show : true,
                            feature : {
                                mark : true,
                                dataView : {readOnly: false},
                                magicType:['line', 'bar'],
                                restore : true
                            }
                        },
                        calculable : true,
                        xAxis : [$xaxis],
                        yAxis : [{type : 'value'}],
                        series : [$series]
                    };

                    myChart.setOption(option);
                }
            );
            </script>
eof;

        echo $script;
    }
} 

?>