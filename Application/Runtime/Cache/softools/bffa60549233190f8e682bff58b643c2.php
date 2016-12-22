<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/data/points-sample-data.js"></script>
    <title>地图工具</title>
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
        }

        #container {
            height: 668px;
            width: 100%;
        }

        #r-result {
            width: 100%;
        }
    </style>

    <script>
        function showPoints(points, e, c, d) {
            var point = new BMap.Point(c, d);
            map.centerAndZoom(point, e);
            map.clearOverlays();
            var heatmapOverlay = new BMapLib.HeatmapOverlay({"radius": 20});
            map.addOverlay(heatmapOverlay);
            heatmapOverlay.setDataSet({data: points, max: 100});
        }
    </script>

    <script>
        function showPoints2(points, e, c, d) {
            var point = new BMap.Point(c, d);
            map.centerAndZoom(point, e);
            map.clearOverlays();
            var pitting = new BMap.PointCollection(points, {color: '#dd4444', opacity: 0.7});
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

        function showPoints4(points, l, k) {
            if (k == '苏州') {
                var point = new BMap.Point(120.659465, 31.285558);
            } else if (k == '上海') {
                var point = new BMap.Point(121.470463, 31.233588);
            }
            map.centerAndZoom(point, 12);
            map.clearOverlays();
            if (l == '办公室') {
                var pitting = new BMap.PointCollection(points, {color: '#CC3299', opacity: 0.7});
                map.addOverlay(pitting);
            } else {
                var pitting = new BMap.PointCollection(points, {color: '#32CD32', opacity: 0.7});
                map.addOverlay(pitting);
            }
        }

        function showPoints5(points, l, k) {
            if (k == '苏州') {
                var point = new BMap.Point(120.659465, 31.285558);
            } else if (k == '上海') {
                var point = new BMap.Point(121.470463, 31.233588);
            }
            map.centerAndZoom(point, 12);
            map.clearOverlays();
            var pitting = new BMap.PointCollection(points.data1, {color: '#CC3299', opacity: 0.7});
            map.addOverlay(pitting);
            var pitting = new BMap.PointCollection(points.data2, {color: '#32CD32', opacity: 0.7});
            map.addOverlay(pitting);
        }

    </script>


    <script type="text/javascript">

        $(function () {
            $("#hot_map_button").click(function () {
                b = $("#product_select option:selected").text();
                b1 = $("#product_select option:selected").attr('val1');
                c = $("#coordinate_select option:selected").attr('val1');
                d = $("#coordinate_select option:selected").attr('val2');
                e = $("#coordinate_select option:selected").val();
                f = $("#hot_level_select option:selected").val();
                $("#hot_map_button").attr("disabled", true);
                $('#test').text('正在查询....').show();
                if (b1 == '含竞品') {
                    $.get('/Sof/ajax1', {res: b, res1: f}).done(function (points) {
                        showPoints(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#hot_map_button").attr("disabled", false);
                    });
                } else if (b1 == '仅本案') {
                    $.get('/Sof/ajax3', {res: b, res1: f}).done(function (points) {
                        showPoints(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#hot_map_button").attr("disabled", false);
                    });
                } else if (b1 == '投放项目') {
                    $.get('/Sof/ajax1_1', {res: b, res1: f}).done(function (points) {
                        showPoints(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#hot_map_button").attr("disabled", false);
                    });
                }
            });
        });

        $(function () {
            $("#ma_points_map_button").click(function () {
                a = $("#product_select").val();
                b = $("#product_select option:selected").text();
                b1 = $("#product_select option:selected").attr('val1');
                c = $("#coordinate_select option:selected").attr('val1');
                d = $("#coordinate_select option:selected").attr('val2');
                e = $("#coordinate_select option:selected").val();
                $('#test').text('正在查询....').show();
                $("#ma_points_map_button").attr("disabled", true);
                if (b1 == '含竞品') {
                    $.get('/Sof/ajax1', {res: b}).done(function (points) {
                        showPoints2(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#ma_points_map_button").attr("disabled", false);
                    });
                } else if (b1 == '仅本案') {
                    $.get('/Sof/ajax3', {res: b}).done(function (points) {
                        showPoints2(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#ma_points_map_button").attr("disabled", false);
                    });
                }else if (b1 == '投放项目') {
                    $.get('/Sof/ajax1_1', {res: b}).done(function (points) {
                        showPoints2(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#ma_points_map_button").attr("disabled", false);
                    });
                }
            });
        });

        $(function () {
            $("#get_more_hot_button").click(function () {
                k = $("#hot_level_select option:selected").val();
                b = $("#product_select option:selected").text();
                b1 = $("#product_select option:selected").attr('val1');
                c = $("#coordinate_select option:selected").attr('val1');
                d = $("#coordinate_select option:selected").attr('val2');
                e = $("#coordinate_select option:selected").val();
                $('#test').text('正在查询....').show();
                $("#get_more_hot_button").attr("disabled", true);
                if (b1 == '含竞品') {
                    $.get('/Sof/ajax2', {res: b, res1: k}).done(function (points) {
                        showPoints3(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#get_more_hot_button").attr("disabled", false);
                    });
                } else if (b1 == '仅本案') {
                    $.get('/Sof/ajax4', {res: b, res1: k}).done(function (points) {
                        showPoints3(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#get_more_hot_button").attr("disabled", false);
                    });
                }else if (b1 == '投放项目') {
                    $.get('/Sof/ajax1_1', {res: b, res1: k}).done(function (points) {
                        showPoints3(points, e, c, d);
                        $('#test').text('等待查询!!!').hide();
                        $("#get_more_hot_button").attr("disabled", false);
                    });
                }
            });
        });


        $(function () {
            $("#isofficeornot_button").click(function () {
                a1 = $("#area_select option:selected").val();
                a = $("#product_select option:selected").val();
                m = $("#isofficeornot2 option:selected").attr('val1');
                n = $("#isofficeornot2 option:selected").attr('val2');
                l = $("#isofficeornot2 option:selected").val();
                $('#test').text('正在查询....').show();
                $("#isofficeornot_button").attr("disabled", true);
                if (l == '大融合') {
                    $.get('/Sof/ajax6', {res: a, res1: m, res2: n, res3: l}).done(function (points) {
                        showPoints5(points, l, a1);
                        $('#test').text('等待查询!!!').hide();
                        $("#isofficeornot_button").attr("disabled", false);
                    });
                }
                else if (b1 == '仅本案') {
                    $.get('/Sof/ajax5', {res: a, res1: m, res2: n, res3: l}).done(function (points) {
                        showPoints4(points, l, a1);
                        $('#test').text('等待查询!!!').hide();
                        $("#isofficeornot_button").attr("disabled", false);
                    });
                }
            });

            function competing_function() {
                aa = $("#competing_select").val();
                bb = $("#area_select").val();
                $.get('/Sof/ajax', {mm: aa, nn: bb}).done(function (points) {
                    $('#product_select').empty();
                    var tmp = $('<option>');
                    if (aa == '仅本案') {
                        if(points.length==0)
                        {
                            $('#product_select').append('<option value="无数据" val1="无数据" val2="无数据">无数据</option>');
                        }
                        $("#isofficeornot_button").attr("disabled", false);
                        points.forEach(function (d) {
                            var _tmp = tmp.clone();
                            _tmp.val(d.district);
                            _tmp.attr('val1', '仅本案');
                            _tmp.text(d.district);
                            $('#product_select').append(_tmp);
                        })
                    } else if (aa == '含竞品') {
                        if(points.length==0)
                        {
                            $('#product_select').append('<option value="无数据" val1="无数据" val2="无数据">无数据</option>');
                        }
                        $("#isofficeornot_button").attr("disabled", true);
                        points.forEach(function (d) {
                            var _tmp = tmp.clone();
                            _tmp.val(d.district);
                            _tmp.attr('val1', '含竞品');
                            _tmp.text(d.district);
                            $('#product_select').append(_tmp);
                        })
                    } else if (aa=='投放项目') {
                        if(points.length==0)
                        {
                            $('#product_select').append('<option value="无数据" val1="无数据" val2="无数据">无数据</option>');
                        }
                        $("#isofficeornot_button").attr("disabled", true);
                        points.forEach(function (d) {
                                var _tmp = tmp.clone();
                                _tmp.val(d.district);
                                _tmp.attr('val1', '投放项目');
                                _tmp.text(d.district);
                                $('#product_select').append(_tmp);
                        })
                    }
                });
            }

            competing_function();

            $("#competing_select").change(function () {
                competing_function();
            });

            function area_function() {
                m = $("#area_select option:selected").val();
                if (m == '上海') {
                    $('#coordinate_select').empty();
                    var _tmp = "<option value='11' val1='121.470463' val2='31.233588' val3='1'>上海人群分布地图</option>";
                    $('#coordinate_select').append($(_tmp));
                } else if (m == '苏州') {
                    $('#coordinate_select').empty();
                    var _tmp = "<option value='11' val1='120.686486' val2='31.273213' val3='1'>苏州人群分布地图</option>";
                    $('#coordinate_select').append($(_tmp));
                } else if (m == '杭州') {
                    $('#coordinate_select').empty();
                    var _tmp = "<option value='12' val1='120.186989' val2='30.287045'>杭州人群地图</option>";
                    $('#coordinate_select').append($(_tmp));
                }
            }

            area_function();

            $("#area_select").change(function () {
                area_function();
                competing_function();
            });
        });




    </script>
    <script type="text/javascript"
            src="http://api.map.baidu.com/geocoder/v2/?ak=3c0e5fed39c5e64f6effefa1e1f54e0a&callback=renderReverse&location=31.085,121.448&output=json&pois=1"></script>

</head>
<body>

<nav class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">上富工具集</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            <li><a href="http://121.41.5.20/index.php/home/Index/tabs_test">工单运行监控</a></li>
            <li><a href="http://adms.richest007.net:8080/wo#/">工单上传工具</a></li>
            <li class="active"><a href="http://121.41.5.20/index.php/home/Index/ajax">地图工具</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    看看有啥好玩的
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">没有</a></li>
                    <li><a href="#">真没有</a></li>
                    <li><a href="#">真的没有!</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>


<div id="container"></div>
<div id="r-result"></div>


<div style="width: 1400px;">
    <form class="form form-horizontal" style="margin: 0" ;>
        <select class="form-control col-xs-1" style="width: 100px;" name="area_select" id="area_select">
            <option value='上海'>上海</option>
            <option value='苏州'>苏州</option>
            <option value='杭州'>杭州</option>
        </select>
        <select class="form-control col-xs-2" style="width: 100px;" id="competing_select">
            <option value="含竞品" selected="selected">含竞品</option>
            <option value="仅本案">仅本案</option>
            <option value="投放项目">投放项目</option>
        </select>

        <div class="col-xs-10">
            <select class="form-control col-xs-2" style="width: 240px;" name="list" id="product_select">
            </select>
            <select class="form-control col-xs-5" style="width: 262px;" name="list2" id="coordinate_select">
            </select>
            &nbsp;

            <div class="btn-group btn-group" role="group" aria-label="...">
                <input type="button" id="hot_map_button" style="width: 50px;" class="btn btn-danger" value="热力">
                <input type="button" id="ma_points_map_button" class="btn btn-success" value="麻点">
                <input type="button" id="get_more_hot_button" class="btn btn-primary" value="热力+麻点">
            </div>

            <label class="control-label" style="text-align: center">热度:</label>
            <select style="width: 80px;" name="list1" id="hot_level_select">
                <option value="1" selected="selected">原版</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="60">60</option>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-info" id="isofficeornot_button" value="办公 or 家里"><span
                    class="glyphicon glyphicon-star" aria-hidden="true">用户场景</span>
            </button>
            <select name="list4" id="isofficeornot2">
                <option value="家里" val1="19" val2="08">家里</option>
                <option value="办公室" val1="09" val2="18">办公室</option>
                <option value="大融合" val1="09" val2="18">大融合</option>
            </select>
            (仅本案使用)
        </div>
    </form>
</div>


<h1 id="test" style="position: absolute;left: 45%;top:45%"></h1>

<script type="text/javascript">
    var map = new BMap.Map("container");          // 创建地图实例
    var point = new BMap.Point(120.587888, 31.306294);
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

</body>
</html>