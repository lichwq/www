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
    <title>上富大数据业务集成工具</title>
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
            if (k == '江苏') {
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
            if (k == '江苏') {
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
                var  b = $("#product_select option:selected").text();
                var  b1 = $("#product_select option:selected").attr('val1');
                var c = $("#coordinate_select option:selected").attr('val1');
                var  d = $("#coordinate_select option:selected").attr('val2');
                var  e = $("#coordinate_select option:selected").val();
                var f = $("#hot_level_select option:selected").val();
                $("#hot_map_button").attr("disabled", true);
                $('#test').show();
//                $('#king_body').css("overflow","hidden");

                if (b1 == '含竞品') {
                    $.get('/Sof/ajax1', {res: b, res1: f}).done(function (points) {
                        $('#test').hide();
                        $("#hot_map_button").attr("disabled", false);
                        $('#king_body').css("overflow","auto");
                        showPoints(points, e, c, d);
                    });
                } else if (b1 == '仅本案') {
                    $.get('/Sof/ajax3', {res: b, res1: f}).done(function (points) {

                        $('#test').hide();
                        $("#hot_map_button").attr("disabled", false);
                        showPoints(points, e, c, d);
//                        $('#king_body').css("overflow","auto");
                    });
                } else if (b1 == '投放项目') {
                    $.get('/Sof/ajax1_1', {res: b, res1: f}).done(function (points) {
                        showPoints(points, e, c, d);
                        $('#test').hide();
                        $("#hot_map_button").attr("disabled", false);
                        $('#king_body').css("overflow","auto");
                    });
                }
            });
        });

        $(function () {
            $("#ma_points_map_button").click(function () {
                var  a = $("#product_select").val();
                var  b = $("#product_select option:selected").text();
                var b1 = $("#product_select option:selected").attr('val1');
                var  c = $("#coordinate_select option:selected").attr('val1');
                var  d = $("#coordinate_select option:selected").attr('val2');
                var e = $("#coordinate_select option:selected").val();
                $('#test').show();
                $("#ma_points_map_button").attr("disabled", true);
                if (b1 == '含竞品') {
                    $.get('/Sof/ajax1', {res: b}).done(function (points) {
                        showPoints2(points, e, c, d);
                        $('#test').hide();
                        $("#ma_points_map_button").attr("disabled", false);
                    });
                } else if (b1 == '仅本案') {
                    $.get('/Sof/ajax3', {res: b}).done(function (points) {
                        showPoints2(points, e, c, d);
                        $('#test').hide();
                        $("#ma_points_map_button").attr("disabled", false);
                    });
                }else if (b1 == '投放项目') {
                    $.get('/Sof/ajax1_1', {res: b}).done(function (points) {
                        showPoints2(points, e, c, d);
                        $('#test').hide();
                        $("#ma_points_map_button").attr("disabled", false);
                    });
                }
            });
        });

        $(function () {
            $("#get_more_hot_button").click(function () {
                var k = $("#hot_level_select option:selected").val();
                var b = $("#product_select option:selected").text();
                var  b1 = $("#product_select option:selected").attr('val1');
                var  c = $("#coordinate_select option:selected").attr('val1');
                var  d = $("#coordinate_select option:selected").attr('val2');
                var  e = $("#coordinate_select option:selected").val();
                $('#test').show();
                $("#get_more_hot_button").attr("disabled", true);
                if (b1 == '含竞品') {
                    $.get('/Sof/ajax2', {res: b, res1: k}).done(function (points) {
                        showPoints3(points, e, c, d);
                        $('#test').hide();
                        $("#get_more_hot_button").attr("disabled", false);
                    });
                } else if (b1 == '仅本案') {
                    $.get('/Sof/ajax4', {res: b, res1: k}).done(function (points) {
                        showPoints3(points, e, c, d);
                        $('#test').hide();
                        $("#get_more_hot_button").attr("disabled", false);
                    });
                }else if (b1 == '投放项目') {
                    $.get('/Sof/ajax1_1', {res: b, res1: k}).done(function (points) {
                        showPoints3(points, e, c, d);
                        $('#test').hide();
                        $("#get_more_hot_button").attr("disabled", false);
                    });
                }
            });
        });


        $(function () {
            $("#isofficeornot_button").click(function () {
                var a1 = $("#area_select option:selected").val();
                var a = $("#product_select option:selected").val();
                var  m = $("#isofficeornot2 option:selected").attr('val1');
                var  n = $("#isofficeornot2 option:selected").attr('val2');
                var  l = $("#isofficeornot2 option:selected").val();
                $('#test').show();
                $("#isofficeornot_button").attr("disabled", true);
                if (l == '大融合') {
                    $.get('/Sof/ajax6', {res: a, res1: m, res2: n, res3: l}).done(function (points) {
                        showPoints5(points, l, a1);
                        $('#test').hide();
                        $("#isofficeornot_button").attr("disabled", false);
                    });
                }
                else  {
                    $.get('/Sof/ajax5', {res: a, res1: m, res2: n, res3: l}).done(function (points) {
                        showPoints4(points, l, a1);
                        $('#test').hide();
                        $("#isofficeornot_button").attr("disabled", false);
                    });
                }
            });

            function competing_function() {
                var aa = $("#competing_select").val();
                var bb = $("#area_select").val();
                $.get('/Sof/sof_map_tools', {mm: aa, nn: bb}).done(function (points) {
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
                var m = $("#area_select option:selected").val();
                if (m == '上海') {
                    $('#coordinate_select').empty();
                    var _tmp = "<option value='11' val1='121.470463' val2='31.233588' val3='1'>上海人群分布地图</option>";
                    $('#coordinate_select').append($(_tmp));
                } else if (m == '江苏') {
                    $('#coordinate_select').empty();
                    var _tmp = "<option value='11' val1='120.686486' val2='31.273213' val3='1'>江苏人群分布地图</option>";
                    $('#coordinate_select').append($(_tmp));
                } else if (m == '浙江') {
                    $('#coordinate_select').empty();
                    var _tmp = "<option value='12' val1='120.186989' val2='30.287045'>浙江人群地图</option>";
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
<body id="king_body" style="height: 100%">

<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom:0px;">
    <div class="navbar-header">
        <a class="navbar-brand" href="sof_home">上富报告工具集合</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            <li><a href="work_order_tools">工单运行监控</a></li>
            <li><a href="gongdanshangchuan">工单上传工具</a></li>
            <li class="active"><a href="sof_map_tools">上富地图工具</a></li>
            <li><a href="sites_6_points">围栏坐标绘制工具</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    更多功能
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="http://www.richest007.com/softools">ETL数据处理</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav pull-right">
            <li>
                <a href="sof_login"> 退出登录</a>
            </li>
        </ul>
    </div>
</nav>

<div id="container" style=" height: 90%;"></div>
<div id="r-result"></div>


<div style="width: 1400px;">
    <form class="form form-horizontal" style="margin: 0">
        <div class="col-xs-10">
            <button type="button" class="btn btn-warning" id="map_sales_points_button" value="查看热区中介"><span
                    class="glyphicon glyphicon-thumbs-up" aria-hidden="true">查看热区中介</span>
            </button>
        </div>
    </form>
</div>


<!--<h1 id="test" style="position: absolute;left: 45%;top:45%"></h1>-->


<script type="text/javascript">
    var map = new BMap.Map("container");          // 创建地图实例
    var point = new BMap.Point(121.470463,31.241986);
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


<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">中介清单列表</h4>
            </div>
            <form role="form" novalidate="" class="ng-pristine ng-invalid ng-invalid-required">
                <div class="modal-body">

                    <div id="zhongjie_list">
                        <table id ='result_table' class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>中介店名</th>
                                <th>城市</th>
                                <th>地址</th>
                                <th>电话号码</th>
                            </tr>
                            </thead>
                            <tbody id = 'left_kuang'>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" ng-disabled="!orderName" ng-click="saveOrder()" disabled="disabled">保存</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="test"  style=";background-color: white; display :none ; opacity: 0.6;position: absolute;left: 0;top:0;height: 90%;width: 100%;margin-top: 53px;" class="spinner">
    <div class="rect1"></div>

    <div class="rect2"></div>

    <div class="rect3"></div>

    <div class="rect4"></div>

    <div class="rect5"></div>

    <div class="rect6"></div>

    <div class="rect7"></div>
</div>


</body>


<script>

    $("#map_sales_points_button").click(function () {
        $("#map_sales_points_button").attr("disabled", true);
        $("#modal_list").attr("disabled", true);


        map_sale_points();

//        console.log(map.getOverlays());

//        map.centerAndZoom(ppoo,11);

//        alert('fdsfsdfs');
    });


    function map_sale_points(){

        $('#left_kuang').empty();

        kk = $("#product_select").val();

        hot = $("#hot_area_count").val();
        var zhongjie = Number($("#zhongjie_count").val());

//        var allOverlay = map.getOverlays();
//
//        for (var i = 1; i < allOverlay.length; i++){
//            if(allOverlay[i]['Lb'] == "overlay"){
//                map.removeOverlay(allOverlay[i]);
//                return false;
//            }
//        }
//           map.clearOverlays();



        $.get('/Sof/map_sales_points', {project: kk, ishot: hot}).done(function (points) {

            var point;
            var local;


//            alert(zhongjie);
//            map.removeOverlay(local);

            map.clearOverlays();


            var cell=[];
            var i = 1;
            var nn = 0;
            function getLocalResult(){

                cell = local.getResults();
                var king = cell['wr'];
                var tmp_option2 = $('<td></td>');

                var tmp_option_tr = $('<tr></tr>');

                king.forEach(function (dd) {

//                    console.log(dd.address);

                    var _tmp_tr = tmp_option_tr.clone();
                    _tmp_tr.attr('id', 't'+nn);
                    $('#left_kuang').append(_tmp_tr);

                    var _tmp1 = tmp_option2.clone();
                    _tmp1.text(dd['title']);
                    $('#t'+nn).append(_tmp1);

                    var _tmp2 = tmp_option2.clone();
                    _tmp2.text(dd['city']);
                    $('#t'+nn).append(_tmp2);

                    var _tmp3 = tmp_option2.clone();
                    _tmp3.text(dd['address']);
                    $('#t'+nn).append(_tmp3);

                    var _tmp4 = tmp_option2.clone();
                    _tmp4.text(dd['phoneNumber']);
                    $('#t'+nn).append(_tmp4);
                    nn=nn+1;
                });

            }




//                local = new BMap.LocalSearch(map, {renderOptions: {map: map, autoViewport: false},onSearchComplete : getLocalResult, pageCapacity: zhongjie
//                });
//                local.searchNearby("房产中介", point, 1000);


            map.centerAndZoom(new BMap.Point(121.473913,31.239022), 18);
            var myKeys = ["服务公寓"];
            var local = new BMap.LocalSearch(map, {
                renderOptions:{map: map, panel:"r-result"},
                pageCapacity:100
            });
            local.searchInBounds(myKeys, map.getBounds());
        });

        $("#map_sales_points_button").attr("disabled", false);
        $("#modal_list").attr("disabled", false);
    }

</script>

</html>