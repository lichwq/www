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
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/data/points-sample-data.js"></script>
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
    var map = new BMap.Map("allmap");      //设置卫星图为底图
//    map.centerAndZoom(new BMap.Point(120.757,29.817),14);                     // 初始化地图,设置中心点坐标和地图级别。
    map.addControl(new BMap.NavigationControl());  //添加鱼骨控件
    map.addControl(new BMap.MapTypeControl());          //添加地图类型控件

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


    function getBoundary() {
        $.get('/Sof/hangzhou_6_bianxing', {res: 1, res1: 2}).done(function (points) {

            var x_o;
            var y_o;
            var kkk=[];


            for (var n=0;n<6000;n=n+6) {
                for (var i = 0; i < 6; i++) {
                    var tmp=[];

                    kkk[i] = points[i+n];
                    console.log(kkk[i]);
                }
                kkk.forEach(function (d) {
                    tmp.push(new BMap.Point(d.y, d.x));
                    x_o = d.x_original;
                    y_o = d.y_original;
                });

            map.centerAndZoom(new BMap.Point(y_o,x_o),12);
            var secRingPolygon = new BMap.Polygon(tmp, {strokeColor:"black", strokeWeight:3, strokeOpacity:0.8});
                secRingPolygon.setFillOpacity(0.1);
            //添加多边形到地图上
            map.addOverlay(secRingPolygon);
            }

        });
    }

    getBoundary();

</script>