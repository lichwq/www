<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
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
    <title>人群质量分布</title>
    <script src="/Public/echarts.min.js"></script>


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

            var _typename = decodeURI(getQueryString("typename"));

            var _levname = decodeURI(getQueryString("levname"));

            var _interval = Number(decodeURI(getQueryString("interval")));

            var cccc = 'width: '+_width+'%;height: '+_height+'%;'+'float:left';

            var bbbb = 'width: '+_width+'%;height: '+_height+'%;'+'float:right';

//            $('#main_1').attr('style',cccc );
//            $('#main_2').attr('style',bbbb );

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();

            var myChart2 = echarts.init(document.getElementById('main_2'));
            myChart2.showLoading();

            var myChart3 = echarts.init(document.getElementById('main_3'));
            myChart3.showLoading();


            $.get('/Subscribe/k_20160719_new_experiment_port', {keywords: _key,type: _type,levname: _levname,typename: _typename}).done(function (result) {


                var sss = ['triangle', 'diamond', 'pin', 'arrow'];

//                        for(var i=0;i<result['data'].length;i++) {
//                            result['data'][i]['symbolSize'] = function (data) {
//                                return  data[2]*30/data[4];
//                            };
//                            result['data'][i]['label'] = {normal: {
//                                show: true,
//                                formatter: function (param) {
//                                    return param.data[3];
//                                },
//                                position: 'top'
//                            }};
//                        }

                var option = {
                            baseOption: {
                                title: {
                                    text: _key,
                                    show: true
                                },
                                tooltip: {
//
                                },
                                legend: {
                                    left: '20%',
                                    right: '4%',
                                    data: result['tagname'],
                                    containLabel: true
                                },
//                toolbox: {
//                    feature: {
//                        saveAsImage: {}
//                    }
//                },
                                xAxis: result['x'],
                                yAxis: result['y'],
                                series: result['data']
                            }
                        };

                        myChart.on('click', function (params) {

                            king_tag = params['seriesName'];

//                            $('#king_iframe').attr("src",'http://softools.richest007.com/subscribe/three_lev_people_bos_map?tagname='+king_tag+'&typename='+_levname);
//                            $('#myModal').modal('show');

//                            console.log(params);
                            console.log(params['seriesName']);
//                            alert(params['seriesName']);
                        });

                        myChart.hideLoading();
                myChart.setOption(option);

                        var option2 = {
                            color: ['#3398DB'],
                            tooltip : {
                                formatter: '{c}',
                                trigger: 'axis',
                                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                                }
                            },
                            xAxis : [
                                {                    axisLabel: {
                                    rotate : 20,
                                    interval: 0
                                },
                                    data : result['bar_king_name']
                                }
                            ],
                            yAxis : [
                                {
                                    type : 'value'
                                }
                            ],
                            series : [
                                {
                                    silent:true,
                                    type:'bar',
                                    data: result['bar_king'],
                                    markLine: {
                                        symbol:'none',
                                        label:{
                                            normal:{
                                                show:true,
                                                position: 'middle',
                                                formatter: '市场成长性基准线'
                                            }

                                        },
                                        lineStyle:{
                                            normal:{
                                                color: 'orange'
                                            }
                                        },
                                        data: [{yAxis: result['new_biaoxian_num']}]
                                    }
                                }
                            ]
                        };

                        myChart2.on('click', function (params) {

                            king_tag = params['seriesName'];
//                            $('#king_iframe').attr("src",'http://softools.richest007.com/subscribe/three_lev_people_bos_map?tagname='+king_tag+'&typename='+_levname);
//                            $('#myModal').modal('show');

//                            console.log(params);
                            console.log(params['seriesName']);
//                            alert(params['seriesName']);
                        });

                        myChart2.hideLoading();
                        myChart2.setOption(option2);


                        var option3 = {
                    title: {
                        text: '波士顿矩阵',
                                show: true
                    },
                    tooltip: {
//
                    },
                    legend: {
                        left: '20%',
                                right: '4%',
                                data: result['bos']['tagname'],
                                containLabel: true
                    },
//                toolbox: {
//                    feature: {
//                        saveAsImage: {}
//                    }
//                },
                    xAxis: result['bos']['x'],
                            yAxis: result['bos']['y'],
                            series: result['bos']['data']
                };

                        myChart3.on('click', function (params) {

                            king_tag = params['seriesName'];
//                            $('#king_iframe').attr("src",'http://softools.richest007.com/subscribe/three_lev_people_bos_map?tagname='+king_tag+'&typename='+_levname);
//                            $('#myModal').modal('show');
//                            console.log(params);
                            console.log(params['seriesName']);
//                            alert(params['seriesName']);
                        });

                        myChart3.hideLoading();
                        myChart3.setOption(option3);
            }
            );
        });

    </script>

</head>
<body>

<div id="main_1" style="width: 50%;height:768px;display: inline-block"></div>


<div id="main_2" style="width: 49%;height:768px;display: inline-block"></div>


<div id="main_3" style="width:1000px;height:500px"></div>

</body>
</html>