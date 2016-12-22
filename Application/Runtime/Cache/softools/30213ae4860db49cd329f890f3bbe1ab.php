<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.0.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript"></script>
    <script src="/Public/echarts.min.js"></script>
    <meta charset="UTF-8">
    <title></title>



</head>
<body>

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 90%;height: 500px;"></div>

<script>
    var myChart = echarts.init(document.getElementById('main'));
    myChart.showLoading();
    $(function () {
        $.get('/Sof/yichang_qushu', {keywords: '南山雨果住宅'}).done(function (result) {
            var k = [];
            var c = [];
            var b = [];
            var d = [];
            var e = [];
            var i = 0;
            result[3].forEach(function(kk) {
               k[i] = kk['date'];
                b[i] = kk['one_day_count'];
                c[i] = kk['one_day_count_1'];
                d[i] = kk['one_day_count_2'];
                e[i] = kk['three_avg_count'];
                i=i+1;
            });


            console.log(b);
            // 基于准备好的dom，初始化echarts实例

            // 指定图表的配置项和数据
            var option = {
                tooltip : {
                    trigger: 'item'
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                title: {
                    text: '异动展示'
                },
                legend: {
                    data:['关注量','异常点','三日均线']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type : 'category',
                    data: k
                },
                yAxis: {
                    type : 'value'
                },
                series: [

                    {   name: '关注量',
                        type: 'bar',
                        data: c},

                    {   name: '异常点',
                        type: 'bar',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data: d},

                    {   name: '三日均线',
                        type: 'line',
                        data: e}

                ]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.hideLoading();
            myChart.setOption(option);

        });
    })
</script>

</body>
</html>