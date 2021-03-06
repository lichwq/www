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
        $.get('/Sof/ajax_map_area', {res: area, res1: 2}).done(function (points) {
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
            for (var i = 0; i < count; i++) {
                var ply = new BMap.Polygon(rs.boundaries[i], {
                    strokeWeight: 3,
                    strokeColor: "Aqua",
                    strokeOpacity: 0.8,
                    fillOpacity: 0.1,
                    fillColor: "blue"
                }); //建立多边形覆盖物
                map.addOverlay(ply);  //添加覆盖物
                pointArray = pointArray.concat(ply.getPath());
            }
            //            map.setViewport(pointArray);    //调整视野
            map.centerAndZoom(new BMap.Point(120.158243, 30.210808),11);


            //以下是创建地图的区域标签
            var haidianCenter = new BMap.Point(c_y, c_x);

            var haidianLabel2 = new BMap.Label(caocaocao, {offset: new BMap.Size(10, -30), position: haidianCenter});
            haidianLabel2.setStyle({
                "line-height": "20px",
                "text-align": "center",
                "width": "38px",
                "height": "18px",
                "border": "1px solid",
                "padding": "1px",
                "background": "white"
            });
            map.addOverlay(haidianLabel2);

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
            ply.addEventListener("click", function () {

                kk(caocaocao);


                $.get('/Sof/ajax_map_area', {res: caocaocao, res1: 2}).done(function (points) {
//                    alert();
                    $('#dashboard').html(caocaocao+"</br>目标人群:"+points['users_count'][0]['users_count']).show();
                });

                //以下是创建地图的dashboard
//                var secRingCenter = new BMap.Point(c_y, c_x);
//                var secRingCenter22 = new BMap.Point(120.785189,30.074502);
//                var secRingLabel = new BMap.Label("<b>"+caocaocao+"</b>包括了热力点 XXX个</br>目前有ad: XXX个</br>激活ad: XXX个</br>现有人员数目: XXX个",{offset: new BMap.Size(-100,0), position: secRingCenter22 });
//                secRingLabel.setStyle({"z-index":"999999", "padding": "100px","width": "140px","border": "1px solid #ccff00"});
//                map.addOverlay(secRingLabel);


//                $('#dashboard').display(block);
//                    map.clearOverlays(pointArray);
//                    map.removeOverlay(pointArray);
            });
//                ply.addEventListener("doubleclick",function(){
//                    map.clearOverlays();
//                })
//                    map.setViewport(pointArray);
//                    map.zoomIn();
//                    map.setCenter(pointArray);
//                });
        });
    }


    $("#allmap_button").click(function () {
        map.removeOverlay(heatmapOverlay);
    });

    setTimeout(function () {
        getBoundary('滨江区', 120.17857, 30.191758);
        getBoundary('富阳市', 119.887422, 30.067751);
        getBoundary('西湖区', 120.063526, 30.198001);
        getBoundary('余杭区', 119.930721, 30.369153);
        getBoundary('拱墅区', 120.151201, 30.338612);
        getBoundary('萧山区', 120.391275, 30.205929);
        getBoundary('江干区', 120.281994, 30.296043);
        getBoundary('上城区', 120.172149, 30.229709);
        getBoundary('下城区', 120.170953, 30.306191);
        getBoundary('临安市', 119.453503, 30.242876);
    }, 500);
</script>