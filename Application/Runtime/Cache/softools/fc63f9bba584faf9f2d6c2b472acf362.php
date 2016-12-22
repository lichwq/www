<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>上富楼盘数据异常状态处理系统</title>
    <link rel="stylesheet" href="/public/jquery-ui.css">
    <script src="/public/jquery-1.12.0.js"></script>
    <script src="/public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="/Public/echarts.min.js"></script>

    <script>
        $(function () {
            function getQueryString(name) {
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
                var r = window.location.search.substr(1).match(reg);
                if ( encodeURI(r) != null) return unescape(encodeURI(r[2])); return null;
            }

            var key = decodeURI(getQueryString("keywords"));

            var _width = decodeURI(getQueryString("width"));

            var _height = decodeURI(getQueryString("height"));

            var cccc = 'width: '+_width+';height: '+_height;

            $('#main_1').attr('style',cccc );

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();

            $.get('/Subscribe/type_total_day', {keywords: key}).done(function (result) {

                console.log(result);

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
                    text : title
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
                        interval: 2
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
                        type:'line',
                        data: d,
                        markLine: markLineOpt
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