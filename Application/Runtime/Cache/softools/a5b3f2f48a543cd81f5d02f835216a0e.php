<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>上富楼盘数据异常状态处理系统</title>
    <link rel="stylesheet" href="/public/jquery-ui.css">
    <script src="/public/jquery-1.12.0.js"></script>
    <script src="/public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/public/dataTables.jqueryui.js"></script>
    <script src="/Public/echarts.min.js"></script>

    <style>
        .list {
            padding: 0;
        }

        .list li {
            line-height: 24px;
            text-indent: 1em;
        }

        .list li:nth-child(2n+1) {
            background-color: #eee;
        }
    </style>

    <script>
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
    </script>


    <script>
        $(function () {

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();


            $("#isofficeornot_button").click(function () {
                var king = $('#keywords_search').val();
            $.get('/Subscribe/test_picture', {keyword: king}).done(function (result) {


                var k = [];
                var c = [];
                var b = [];
                var d = [];
                var e = [];
                var f = [];
                var g = [];
                var i = 0;

                result.forEach(function(kk) {
                    k[i] = kk['dick'];
                    b[i] = kk['date'];
                    c[i] = kk['know_userid_count'];
                    d[i] = kk['analysis_userid_count'];
                    e[i] = kk['self_userid_count'];
                    f[i] = kk['trade_count'];
                    g[i] = kk['avg'];
                    i=i+1;
                });

                var title = result[0]['dick'];


          var  option = {
                title: {
                    top:'3%',
                    text : title
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    top:'3%',
                    data:['了解','分析','决策','交易','加权平均值']
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    axisLabel: {
                        rotate : 45,
                        interval: 0
                    },
                    type: 'category',
                    boundaryGap: false,
                    data: b
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name:'了解',
                        type:'line',
                        data:c
                    },
                    {
                        name:'分析',
                        type:'line',
                        data:d
                    },
                    {
                        name:'决策',
                        type:'line',
                        data:e
                    },
                    {
                        name:'交易',
                        type:'line',
                        data:f
                    },
                    {
                        name:'加权平均值',
                        type:'line',
                        data:g
                    }
                ]


            };

                myChart.hideLoading();
                myChart.setOption(option);


            });

            });


        });

        alert(fdsfsdfs);
        alert(GetQueryString("keywords"));

    </script>



</head>
<body>

<div align="center" >


</div>

<div id="main_1" style="width: 100%;height:600px;"></div>
</body>
</html>