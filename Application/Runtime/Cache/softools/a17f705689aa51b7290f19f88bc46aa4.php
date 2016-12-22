<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <!--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!--<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
    <!--<script type="text/javascript" src="http://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js"></script>-->
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/data/points-sample-data.js"></script>
    <!--<script src="http://c.cnzz.com/core.php"></script>-->
    <title>地图工具</title>


    <script>


        $(function () {

            function publicBusi() {
                count_map();
                setTimeout(publicBusi, 60000);//这里的1000表示1秒有1000毫秒,1分钟有60秒,7表示总共7分钟
            }

            function count_map() {
                $.get('/Sof/mapapi_counts_tools', {isajax: 'hangzhou'}).done(function (result) {
                    var b;
                    $('#h2_banner').text('目前 : '+result['count'][0].count);
                    $('#h1_banner').text('总共 : '+result['total_count'][0].total_count);
                    if (result['status'][0].status == 0) {
                    $.get('/Sof/mapapi', {isajax: 'hangzhou'});
                }
                })
            }

            publicBusi();

        })



    </script>


</head>
<body>

<h1 id="h1_banner" style="position: absolute;left: 45%;top:45%"></h1>

<h2 id="h2_banner" style="position: absolute;left: 45%;top:35%"></h2>

</body>
</html>