<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <title>根据中心点关键字周边搜索</title>
    <script async src="http://c.cnzz.com/core.php"></script></head>
<body>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">

    // 百度地图API功能
    var map = new BMap.Map("allmap");            // 创建Map实例
    map.centerAndZoom(new BMap.Point(121.363, 31.161), 10);
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
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map, autoViewport:true},pageCapacity: 35});
//    local.pageCapacity(35);
//    local.searchNearby("中介", "中原");
    local.searchNearby("房产中介", new BMap.Point(121.363, 31.161),1000)
</script>