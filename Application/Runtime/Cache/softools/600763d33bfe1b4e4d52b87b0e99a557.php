<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>type中tag排名top5接口(日明细)</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
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

            var _interval = Number(decodeURI(getQueryString("interval")));

            var cccc = 'width: '+_width+'%;height: '+_height+'%';

            $('#main_1').attr('style',cccc );

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();

            $.get('/Subscribe/top5_tag_day_port', {keywords: key}).done(function (result) {

//                var title = result[0]['typename'];

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
                        text : key+'top5',
                        show : false
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        top:'3%',
                        data: result['top5']
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
                        data: result['pic'][0]['date']
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name: result['top5'][0],
                            type: _type,
                            data:
                                    result['pic'][0]['total_view_count']
//                            markLine: markLineOpt
                        },
                        {
                            name: result['top5'][1],
                            type: _type,
                            data:
                                    result['pic'][1]['total_view_count']
//                            markLine: markLineOpt
                        },
                        {
                            name: result['top5'][2],
                            type: _type,
                            data:
                                    result['pic'][2]['total_view_count']
//                            markLine: markLineOpt
                        },                        {
                            name: result['top5'][3],
                            type: _type,
                            data:
                                    result['pic'][3]['total_view_count']
//                            markLine: markLineOpt
                        },                        {
                            name: result['top5'][4],
                            type: _type,
                            data:
                                    result['pic'][4]['total_view_count']
//                            markLine: markLineOpt
                        }
                    ]
                };
                myChart.hideLoading();
                myChart.setOption(option);
            });
        });

    </script>


</head>
<body>

<div align="center" >

</div>

<div id="main_1"></div>


</body>
</html>