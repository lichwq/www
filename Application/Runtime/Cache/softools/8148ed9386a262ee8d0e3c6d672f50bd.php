<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <title>360echarts</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>360关系图明细</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
    <script src="/Public/dataTool.js"></script>
    <script>

        $(function () {
            var myChart = echarts.init(document.getElementById('main'));
            myChart.showLoading();

            $.get('/Public/360echarts_test_ver0.2.json').done(function (result) {

                console.log(result['categories']['name']);

            var option = {
                title : {
                    text: result['title'],
                    x:'left',
                    y: 30
                },
//                tooltip : {
//                },

                tooltip : {
//                    trigger: 'item',
                    formatter: '{c}'
                },
                toolbox: {
                    show : true,
                    feature : {
                        restore : {show: true},
                        magicType: {show: true, type: ['force', 'chord']},
                        saveAsImage : {show: true}
                    }
                },
                legend: {
                    x: 'left',
                    data:['人物','家人','朋友']
            },
                series : [
                    {
                        type:'force',
                        name : "人物关系",
                        ribbonType: false,
//                        categories:result['categories'][0],

                        categories: [
                            {"name": "人物","symbolSize": 25,"itemStyle":{"normal":{
                                "color":"red"
                        }}
                            },
                            {"name": "家人","symbolSize": 15,"itemStyle":{"normal":{
                                "color":"yellow"
                            }}
                            },
                            {"name":"朋友","symbolSize": 15,"itemStyle":{"normal":{
                                "color":"orange"
                            }}
                            }
                        ],


//                        categories : {
//                            name:['人物','家人 ','朋友']
//                        },

                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    textStyle: {
                                        color: '#333'
                                    }
                                },
                                nodeStyle : {
//                                    brushType : 'both',
//                                    borderColor : 'rgba(255,215,0,0.4)',
//                                    borderWidth : 1
                                }
//                                linkStyle: {
//                                    type: 'curve'
//                                }
                            },
                            emphasis: {
                                label: {
                                    show: false
                                    // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                                },
                                nodeStyle : {
                                    //r: 30
                                },
                                linkStyle : {}
                            }
                        },
                        useWorker: false,
                        minRadius : 15,
                        maxRadius : 25,
//                        ribbonType : false,
                        gravity: 1.5,
                        scaling: 1.5,
                        linkSymbol: ['arrow'],

//                        roam: 'move',
                        nodes:result['nodes'],
                        links:result['links']
                    }
                ]
            };

            myChart.hideLoading();
            myChart.setOption(option);

//            var ecConfig = require('echarts/config');
//            function focus(param) {
//                var data = param.data;
//                var links = option.series[0].links;
//                var nodes = option.series[0].nodes;
//                if (
//                        data.source !== undefined
//                        && data.target !== undefined
//                ) { //点击的是边
//                    var sourceNode = nodes.filter(function (n) {return n.name == data.source})[0];
//                    var targetNode = nodes.filter(function (n) {return n.name == data.target})[0];
//                    console.log("选中了边 " + sourceNode.name + ' -> ' + targetNode.name + ' (' + data.weight + ')');
//                } else { // 点击的是点
//                    console.log("选中了" + data.name + '(' + data.value + ')');
//                }
//            }
//            myChart.on(ecConfig.EVENT.CLICK, focus);
//
//            myChart.on(ecConfig.EVENT.FORCE_LAYOUT_END, function () {
//                console.log(myChart.chart.force.getPosition());
//            });

        });

        });

    </script>

</head>
<body style="height: 100%;">
<div id="main" style="width: 100%;height: 100%"></div>
</body>
</html>