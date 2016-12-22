<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <style type="text/css">
        body, html, #allmap {
            width: 100%;
            height:100%;
            overflow: hidden;
            margin: 0;
            font-family: "微软雅黑";
        }
    </style>
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/data/points-sample-data.js"></script>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <title>杭州测试工具demo</title>

</head>
<body>
<div id="allmap"></div>
<div id="dashboard"  style=" display: none;
position: absolute;
font-size: 20px;
padding-left:100px;
left: 80%;
top:58%;
width: 300px;
height:300px;
background-color: white;
border: solid 1px #ccff00;
filter: Chroma(Color=#FFFFFF);
opacity:0.8; "></div>
<!--<input type="button" id="allmap_button" style="width: 50px;" class="" value="关闭">-->
</body>
</html>


<script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    map.enableScrollWheelZoom();
    var point = new BMap.Point(120.158243, 30.210808);
    map.centerAndZoom(point, 11);
    var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});// 左上角，添加比例尺
    var top_left_navigation = new BMap.NavigationControl();  //左上角，添加默认缩放平移控件
    var top_right_navigation = new BMap.NavigationControl({
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        type: BMAP_NAVIGATION_CONTROL_SMALL
    }); //右上角，仅包含平移和缩放按钮
    map.enableScrollWheelZoom(); // 允许滚轮缩放
    map.addControl(top_left_control);
    map.addControl(top_left_navigation);
    map.addControl(top_right_navigation);

    var heatmapOverlay = new BMapLib.HeatmapOverlay({"radius": 20});
    function kk(area) {
        $.get('/Subscribe/ajax_map_area', {res: area, res1: 2}).done(function (points) {
            map.addOverlay(heatmapOverlay);
            heatmapOverlay.setDataSet({data: points['points'], max: 100});
        });
    }

    //以下是划分区域模块
    function getBoundary(caocaocao, c_y, c_x) {
        var bdary = new BMap.Boundary();
        bdary.get(caocaocao, function (rs) {       //获取行政区域
            //            map.clearOverlays();        //清除地图覆盖物
            var count = rs.boundaries.length; //行政区域的点有多少个
            if (count === 0) {
                alert('未能获取当前输入行政区域');
                return;
            }
            var pointArray = [];

            $.get('/Subscribe/xq_circle_map_tools_port', {res: 11}).done(function (result) {
                var tmp = [];
                var x;
                var y;
                var result1 = [];
                var result2 = [];
                for (var i = 0; i < result.length; i++) {
//                tmp.push(new BMap.Point(result[i].c_y, result[i].c_x));
                    x = result[i].c_x;
                    y = result[i].c_y;
                    var ply = new BMap.Circle(new BMap.Point(y, x), 1000, {
                        strokeColor: "red",
                        strokeWeight: 1,
                        strokeOpacity: 0.8
                    });
                    ply.setFillOpacity(0.5);
                    ply.setFillColor('red');
                    map.addOverlay(ply);
                }
                //            map.setViewport(pointArray);    //调整视野
                map.centerAndZoom(new BMap.Point(120.158243, 30.210808), 11);

                ply.addEventListener("mouseover", function () {
                    //                map.clearOverlays(pointArray);
                    ply.setStrokeColor("red");
                    ply.setStrokeWeight("8");
//                ply.("white");
//                map.addOverlay(pointArray);
//                map.panTo(pointArray);
                });
                ply.addEventListener("mouseout", function () {
                    ply.setStrokeColor("Aqua");
                    ply.setStrokeWeight("3");
                    ply.setFillColor("blue");
                    map.removeOverlay(heatmapOverlay);
                    map.removeOverlay(pointArray);
                    $('#dashboard').hide();
                });
            });

        });
    }


    $("#allmap_button").click(function () {
        map.removeOverlay(heatmapOverlay);
    });

    setTimeout(function () {
        getBoundary('滨江区', 120.17857, 30.191758);
    }, 500);
</script>