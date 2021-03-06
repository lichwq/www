<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="/public/loading.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="/public/jquery-1.12.0.js"></script>
    <script src="/public/jquery-ui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/data/points-sample-data.js"></script>
    <title>三级人群波士顿地图</title>
    <style type="text/css">
        ul, li {
            list-style: none;
            margin: 0;
            padding: 0;
            float: left;
        }
        html {
            height: 100%
        }

        body {
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
            height: 100%;
        }

        #container {
            /*height: 800px;*/
            width: 100%;
        }

        #r-result {
            width: 100%;
        }
    </style>

    <script>
        function showPoints(points, e, c1, d1) {
            var king_point = new BMap.Point(c1, d1);
            map.clearOverlays();
            var heatmapOverlay = new BMapLib.HeatmapOverlay({"radius": 20});
            map.addOverlay(heatmapOverlay);
            heatmapOverlay.setDataSet({data: points, max: 100});
            map.centerAndZoom(king_point, e);
        }
    </script>

    <script>
        function showPoints2(points, e, c, d) {
            var point = new BMap.Point(c, d);
            map.centerAndZoom(point, e);
//            map.clearOverlays();
            var pitting = new BMap.PointCollection(points, {color: '#dd4444', opacity: 0.7});
            map.addOverlay(pitting);
        }


        function showPoints2_1(points, e, c, d) {
            var point = new BMap.Point(c, d);
            map.centerAndZoom(point, e);
            map.clearOverlays();
            var pitting = new BMap.PointCollection(points, {color: 'green', opacity: 0.7});
            map.addOverlay(pitting);
        }

        function showPoints3(points, e, c, d) {
            var point = new BMap.Point(c, d);
            map.centerAndZoom(point, e);
            map.clearOverlays();
            var pitting = new BMap.PointCollection(points, {color: '#dd4444', opacity: 0.7});


            var heatmapOverlay = new BMapLib.HeatmapOverlay({"radius": 20});

            map.addOverlay(heatmapOverlay);
            heatmapOverlay.setDataSet({data: points, max: 100});

            setTimeout(function () {
                map.addOverlay(pitting);
            }, 30);
        }

    </script>


    <script type="text/javascript">

        $(function () {


                    function getQueryString(name) {
                        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
                        var r = window.location.search.substr(1).match(reg);
                        if ( encodeURI(r) != null) return unescape(encodeURI(r[2])); return null;
                    }
                    var _tagname = decodeURI(getQueryString("tagname"));

                    var _typename = decodeURI(getQueryString("typename"));

                    $.get('/Subscribe/three_lev_people_bos_map_port', {tagname: _tagname, typename: _typename}).done(
                            function (points) {
                                showPoints2_1(points[1], 11, 121.519, 31.257);
                                showPoints2(points[0], 11, 121.519, 31.257);
                        }
                    );
            }
        );
    </script>


    <script type="text/javascript"
            src="http://api.map.baidu.com/geocoder/v2/?ak=3c0e5fed39c5e64f6effefa1e1f54e0a&callback=renderReverse&location=31.085,121.448&output=json&pois=1"></script>

</head>
<body id="king_body" style="height: 100%">

<div id="container" style="width: 100%;height: 100%;"></div>
<div id="r-result"></div>
</body>

<script>
    var map = new BMap.Map("container");          // 创建地图实例
    var point = new BMap.Point(121.519, 31.257);
    var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});// 左上角，添加比例尺
    var top_left_navigation = new BMap.NavigationControl();  //左上角，添加默认缩放平移控件
    var top_right_navigation = new BMap.NavigationControl({
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        type: BMAP_NAVIGATION_CONTROL_SMALL
    }); //右上角，仅包含平移和缩放按钮
    map.centerAndZoom(point, 11);             // 初始化地图，设置中心点坐标和地图级别
    map.enableScrollWheelZoom(); // 允许滚轮缩放
    map.addControl(top_left_control);
    map.addControl(top_left_navigation);
    map.addControl(top_right_navigation);
    if (!isSupportCanvas()) {
        alert('热力图目前只支持有canvas支持的浏览器,您所使用的浏览器不能使用热力图功能~')
    }
</script>



</html>