<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>上富楼盘数据异常状态处理系统</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/Public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/Public/dataTables.jqueryui.js"></script>
    <script src="/Public/echarts.min.js"></script>

    <style>
        .list {
            padding: 0;
        }

        .list li {
            line-height: 24px;
            text-indent: 1em;
        }

        .list li:nth-child(2n+1) {
            background-color: #eee;
        }
    </style>

    <script type="text/javascript">
        $(function () {

        });

    </script>



    <script>
        $(function () {

            $("#keywords_search").keyup(function () {
                k1 = $(this).val();
                if (k1 == '') {
                    $('#result_div').hide();
                    return;
                }
                $.get('/Sof/search_keywords_ajax', {res: k1}).done(function (shuju) {
                            $('#result_div').show();
                            $('#result_div ul').empty();
                            if (!!shuju && shuju.length > 0) {
                                var li = $('<li>');
                                shuju.forEach(function (r) {
                                    var tmp = li.clone();
                                    tmp.val(r.keywords).text(r.keywords);
                                    $('#result_div ul').append(tmp);
                                })
                            } else {
                                $('#result_div ul').append("<li>暂无此楼盘</li>");
                            }
                        }
                );
            });

            $("#result_div ul").on('click', 'li', function () {
                k1 = $(this).text();
                $('#keywords_search').val(k1);
                $('#result_div').hide();
            });

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();


            $("#isofficeornot_button").click(function () {
                var king = $('#keywords_search').val();
            $.get('/Sof/shiwu_people_data', {keywords: king}).done(function (result) {


                var k = [];
                var c = [];
                var b = [];
                var d = [];
                var e = [];
                var f = [];
                var g = [];
                var i = 0;

                result.forEach(function(kk) {
                    k[i] = kk['dick'];
                    b[i] = kk['date'];
                    c[i] = kk['know_userid_count'];
                    d[i] = kk['analysis_userid_count'];
                    e[i] = kk['self_userid_count'];
                    f[i] = kk['trade_count'];
                    g[i] = kk['avg'];
                    i=i+1;
                });

                var title = result[0]['dick'];


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
                    data:['了解','分析','决策','交易','加权平均值']
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: {
                    axisLabel: {
                        rotate : 45,
                        interval: 0
                    },
                    type: 'category',
                    boundaryGap: false,
                    data: b
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name:'了解',
                        type:'line',
                        data:c
                    },
                    {
                        name:'分析',
                        type:'line',
                        data:d
                    },
                    {
                        name:'决策',
                        type:'line',
                        data:e
                    },
                    {
                        name:'交易',
                        type:'line',
                        data:f
                    },
                    {
                        name:'加权平均值',
                        type:'line',
                        data:g
                    }
                ]


            };

                myChart.hideLoading();
                myChart.setOption(option);


            });

            });


        });

        </script>


    <script>
        function creatInput() {
            var template = $('<div class="text">' +
                    '<input tyle="text" />' +
                    '<div class="clean">X</div>' +
                    '</div>');
            template.find('input').on('keyup', function() {
                if( template.find('input').val() == '' ) template.find('.clean').hide();
                template.find('.clean').show();
            });
            template.find('.clean').on('click', function() {
                template.find('input').val('');
                $(this).hide();
            });

            return template;
        }

        function scan() {
            $('[xinput]').each(function() {
                $(this).append( new creatInput() );
            })
        }

        $(function() {
            scan();
        })

    </script>

</head>
<body>

<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom:0px;">
    <div class="navbar-header">
        <a class="navbar-brand" href="sof_home">上富科技运营系统</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    项目报告
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="gongdanshangchuan">报告工单上传</a></li>
                    <li><a href="work_order_tools">报告工单监控</a></li>
                    <li><a href="sof_map_tools">报告人群地图</a></li>
                    <li class="active"><a href="shiwu_people">项目三级人群</a></li>
                    <li><a href="yichang">项目人群异动分析</a></li>
                    <li><a href="bussiness_assessment_workorder">业务评估系统</a></li>
                    <li><a href="click_tools">结案报告</a></li>
                    <li><a href="xq_circle_map_tools">小区分析</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    销售支持
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <!--<li><a href="">项目电话</a></li>-->
                    <!--<li><a href="">项目热区</a></li>-->
                    <li><a href="sof_map_tools_zhongjie">中介地图</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    投放支持
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="sof_cm">电信投放部署</a></li>
                    <li><a href="">SOF投放部署</a></li>
                    <li><a href="sites_6_points">围栏坐标（杭州专用）</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    ETL处理监控
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="">楼盘字典入库</a></li>
                    <li><a href="">上海监控</a></li>
                    <li><a href="">江苏监控</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav pull-right">
            <li><a href="sof_login"> 退出登录</a>
            </li>
        </ul>
    </div>
</nav>

<div align="center" >

<div style="margin-top: 1%;width: 50%" class="">
    <input class=""
           id="keywords_search"
           placeholder="请输入需要搜索的楼盘" type="text" style="width: 30%;">
    <button type="button" class="btn btn-primary btn-sm" id="isofficeornot_button">生成
    </button>
</div>
<div  class="form-control" id="result_div" style="margin-left: 0%;
display: none;
    border: 1px solid #000;
    width: 18%;
    height: 180px;
    overflow-y: scroll;">
    <ul style="
        list-style: none;
    " class="list">
    </ul>
</div>

</div>

<div id="main_1" style="width: 100%;height:600px;"></div>
</body>
</html>