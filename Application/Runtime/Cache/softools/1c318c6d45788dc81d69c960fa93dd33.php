<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>三级人群(日)</title>
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

            var _key = decodeURI(getQueryString("keywords"));

            var _width = Number(decodeURI(getQueryString("width")));

            var _height = Number(decodeURI(getQueryString("height")));

            var _type = decodeURI(getQueryString("type"));

            var _interval = Number(decodeURI(getQueryString("interval")));

            var cccc = 'width: '+_width+'%;height: '+_height+'%';

            $('#main_1').attr('style',cccc );

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();

            $.get('/Subscribe/three_lev_people_port', {keywords: _key,type: _type}).done(function (result) {

//                        console.log(result['data']);


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
                    text :result['total_name']+'三级人群变化趋势',
                    show : false
                },
                tooltip: {
                },
                legend: {
                    data: result['tagname'],
                    containLabel: true
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
                    data: result['date']
                },
                yAxis: [{
                    name: '关注量',
                    type: 'value'
                },
                    {
                        name: '交易',
//                        nameLocation: 'start',
                        min: 0,
                        max: result['max'],
                        type: 'value'
//                        inverse: true
                    }
                ],
                series:
                        [{
                                name:'了解',
                                type:'line',
                                data: result['data'][0]['data']
                      },
                            {
                                name:'分析',
                                type:'line',
                                data: result['data'][1]['data']
                            },{
                            name:'决定',
                            type:'line',
                            data: result['data'][2]['data']
                        },
                            {
                                name: '成交',
                                type: 'line',
                                yAxisIndex:1,
                                data: result['data'][3]['data']
                            },
                            {
                            name:'加权平均值',
                            type:'line',
                            data: result['data'][4]['data']
                        },
                            {
                                name:'人群质量',
                                type:'line',
                                data: result['data'][5]['data']
                            }]
                  }
            ;
                myChart.hideLoading();
                myChart.setOption(option);
            }
            );
        });

    </script>

</head>
<body>

<div id="main_1"></div>

</body>
</html>