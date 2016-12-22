<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>type明细接口(日)</title>
    <link rel="stylesheet" href="/public/jquery-ui.css">
    <script src="/public/jquery-1.12.0.js"></script>
    <script src="/public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="/Public/echarts.min.js"></script>

    <style type="text/css">
        html
        {
            height:100%;
            margin:0;
        }
        body
        {
            height:100%;
            margin:0;
        }
    </style>

    <script>
        $(function () {
            function getQueryString(name) {
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
                var r = window.location.search.substr(1).match(reg);
                if ( encodeURI(r) != null) return unescape(encodeURI(r[2])); return null;
            }

            var key = decodeURI(getQueryString("keywords"));

            var _width = Number(decodeURI(getQueryString("width")));

            var _height = Number(decodeURI(getQueryString("height")));

            var _type = decodeURI(getQueryString("type"));

//            var _istrue = decodeURI(getQueryString("istrue"));

            var _interval = Number(decodeURI(getQueryString("interval")));

            var cccc = 'width: '+_width+'%;height: '+_height+'%';

//            $('#main_1').attr('style',cccc );

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();

            $.get('/Subscribe/type_total_day_port', {keywords: key}).done(function (result) {

                var k = [];
                var c = [];
                var b = [];
                var d = [];
                var i = 0;

                result.forEach(function(kk) {
                    k[i] = kk['date'];
                    b[i] = kk['indname'];
                    c[i] = kk['typename'];
                    d[i] = Number(kk['total_view_count']);
                    i=i+1;
                });

                var title = result[0]['typename'];

                var markLineOpt = {
                    animation: false,
//                    label: {
//                        normal: {
////                            formatter: 'y = 0.5 * x + 3',
//                            textStyle: {
//                                align: 'right'
//                            }
//                        }
//                    },
                    lineStyle: {
                        normal: {
                            type: 'dashed'
                        }
                    },
                    tooltip: {
//                        formatter: 'y = 0.5 * x + 3'
                    },
                    data: [
//                        {
//                         yAxis: 27000,
//                            symbol: 'none'
//                        },
                        {
                            name: '平均线',
                            // 支持 'average', 'min', 'max'
                            type: 'average',
                            symbol: 'none'
                        }
                    ]};

          var  option = {
                title: {
                    top:'3%',
                    text : title,
                    show : false
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    top:'3%',
                    data:[title]
                },
//                toolbox: {
//                    feature: {
//                        saveAsImage: {}
//                    }
//                },
                xAxis: {
                    axisLabel: {
                        rotate : 45,
                        interval: _interval
                    },
                    type: 'category',
                    boundaryGap: false,
                    data: k
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name: title,
                        type: _type,
                        data: d,
                        markLine: markLineOpt
                    }
                ]
            };
                myChart.hideLoading();
                myChart.setOption(option);
            }
            );
        });

    </script>

</head>
<body style="width: 100%;height: 100%;margin:0";>

<div id="main_1" style="width: 100%;height: 100%;margin:0"></div>

</body>
</html>