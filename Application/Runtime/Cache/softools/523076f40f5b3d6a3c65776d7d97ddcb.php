<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="width: 100%;height: 100%">
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
    <title>异常地图工具</title>

</head>
<body>

<div id="allmap" style="height: 1200px"></div>
<div id="dashboard"  style=" display: none;
position: absolute;
font-size: 20px;
padding-left:100px;
left: 50%;
top:58%;
width: 800px;
height:300px;
background-color: white;
border: solid 1px #ccff00;
filter: Chroma(Color=#FFFFFF);
opacity:0.8; "></div>

<!--<input type="button" id="allmap_button" style="width: 50px;" class="" value="关闭">-->
</body>
</html>


<script type="text/javascript">

    //    //初始化下拉列表:
    //    $('#list').empty();
    //    $('#list').append('<option>无数据</option>>');

    var map = new BMap.Map("allmap");      //设置卫星图为底图
    map.centerAndZoom(new BMap.Point(120.757,29.817),14);                     // 初始化地图,设置中心点坐标和地图级别。
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


//    $.get('/Subscribe/yichang_map_shuju', {res: 1, res1: 2}).done(function (result) {
//        var tmp_option = $('<option>');
//        result[2].forEach(function (d) {
//            var _tmp = tmp_option.clone();
//            _tmp.val(d.details);
//            _tmp.attr('val1', d.start_date);
//            _tmp.attr('val2', d.end_date);
//            _tmp.text(d.details);
//            _tmp.attr('val3', d.tagname);
//            $('#list').append(_tmp);
//        });
//    });


    $(function () {
        map.clearOverlays();
        $.get('/Subscribe/xq_circle_map_tools_port', {res: 11}).done(function (result) {
            var x;
            var y;

            for (var i = 0; i < result.length; i++) {
//                tmp.push(new BMap.Point(result[i].c_y, result[i].c_x));
                x = result[i].c_x;
                y = result[i].c_y;

//                eval("var circle" + i + "=" + 'new BMap.Circle(new BMap.Point(y, x), 1000,{strokeColor:"red", strokeWeight:1, strokeOpacity:0.8})');
//
////                eval("console.log(circle"+i+")");
//
//                eval("circle"+i+".setFillOpacity(0.5)");
//                eval("circle"+i+".setFillColor('red')");
//                eval("map.addOverlay(circle"+i+")");


                var circle = new BMap.Circle(new BMap.Point(y, x), 1000,{strokeColor:"red", strokeWeight:1, strokeOpacity:0.8});
                circle.setFillColor("grey");
                circle.setFillOpacity(0.2);
                map.addOverlay(circle);
//
                circle.addEventListener("mouseover", function () {
                    this.setStrokeColor("blue");
                    this.setStrokeWeight("5");
                    console.log(this['point']['lat']);
                    console.log(this['point']['lng']);

                    var x1 = this['point']['lat'];
                    var y1 = this['point']['lng'];

                    $.get('/Subscribe/xq_circle_map_tools_dashboard_port', {c_x: x1,c_y: y1}).done(function (result) {
                        $('#dashboard').html(result[0][0]['total_user_count']+'</br>'+result[1][0]['total_user_count']);
                        $('#dashboard').fadeIn(200);
                    });
                });
//
                circle.addEventListener("mouseout", function () {
                    this.setStrokeColor("red");
                    this.setStrokeWeight("1");
                    this.setFillColor("grey");
                    $('#dashboard').hide();
                });
            }

            map.centerAndZoom(new BMap.Point(y,x),12);
        })
    });

//    $("#all_map").hide();
//
//        $("#all_map").show();

</script>