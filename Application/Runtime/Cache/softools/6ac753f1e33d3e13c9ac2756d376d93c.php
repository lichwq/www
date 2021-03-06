<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <style type="text/css">
        body, html, #allmap {
            width: 100%;
            height:150%;
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

<div  align="center">
    <select name="list" id="list"></select>&nbsp
    <button class="btn btn-success" id="button_1"><span
            class="glyphicon glyphicon-globe" aria-hidden="true"> 绘制地图</span></button></div><br />


<div id="allmap" style="height: 1200px"></div>

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



    $.get('/Sof/yichang_map_shuju', {res: 1, res1: 2}).done(function (result) {
        var tmp_option = $('<option>');
        result[2].forEach(function (d) {
            var _tmp = tmp_option.clone();
            _tmp.val(d.details);
            _tmp.attr('val1', d.start_date);
            _tmp.attr('val2', d.end_date);
            _tmp.text(d.details);
            _tmp.attr('val3', d.tagname);
            $('#list').append(_tmp);
        });
    });


    function getBoundary(aa,bb,cc) {
        map.clearOverlays();
        $.get('/Sof/yichang_map_shuju', {res: aa, res1: bb, res2: cc}).done(function (result) {


            var tmp = [];
            var x;
            var y;
            var result1 = [];
            var result2 = [];

            result[3].forEach(function (d) {
                    tmp.push(new BMap.Point(d.new_c_y, d.new_c_x));
                    x = d.new_c_x;
                    y = d.new_c_y;
                var circle = new BMap.Circle(new BMap.Point(y, x), 500,{strokeColor:"red", strokeWeight:3, strokeOpacity:0.8});
                circle.setFillOpacity(0.5);
                circle.setFillColor('red');
                map.addOverlay(circle);
                });

            result[4].forEach(function (d) {
                tmp.push(new BMap.Point(d.new_c_y, d.new_c_x));
                x = d.new_c_x;
                y = d.new_c_y;
                var circle = new BMap.Circle(new BMap.Point(y, x), 500,{strokeColor:"blue", strokeWeight:3, strokeOpacity:0.8});
                circle.setFillOpacity(0.1);
//                circle.setFillColor('yellow');
                map.addOverlay(circle);
            });
                map.centerAndZoom(new BMap.Point(y,x),12);
            $("#button_1").attr("disabled", false);

            })
        }

    $("#all_map").hide();
    $("#button_1").click(function () {
        $("#button_1").attr("disabled", true);
        $("#all_map").show();
        getBoundary($("#list option:selected").attr('val1'),$("#list option:selected").attr('val2'),$("#list option:selected").attr('val3'));

    });


</script>