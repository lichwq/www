<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>上富大数据业务集成系统</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/public/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
        }
    </style>


    <script>

        $(function () {
            function xunhuan() {
                $.get('/Sof/gongdanzhuangtai', {res: 1}).done(function (k) {
                    $("#tabs-1").text(k[0]['status']);
                });


                $.get('/Sof/test_sheet_ajax', {res: 1}).done(function (k) {
                    $('#table_id2').dataTable(
                            {"bProcessing": true,
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: k,
                                columns: [
                                    {data: 'date'},
                                    {data: 'project'},
                                    {data: 'part'}
                                ]
                            }
                    );

                    $('#table_id2').DataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        "createdRow": function ( row, data, index ) {
                            if ( data[2]=='successed' ) {
                                $('td', row).eq(2).css('font-weight',"bold").css("color","green");
                                $('td', row).eq(1).css('font-weight',"bold").css("color","green");
                            }else if( data[2]=='processing'){
                                $('td', row).eq(2).css('font-weight',"bold").css("color","red");
                                $('td', row).eq(1).css('font-weight',"bold").css("color","red");
                            }else if( data[2]=='waiting'){
                                $('td', row).eq(2).css('font-weight',"bold").css("color","blue");
                                $('td', row).eq(1).css('font-weight',"bold").css("color","blue");
                            }
                        },
                        language: {
                            "sProcessing": "处理中...",
                            "sLengthMenu": "显示 _MENU_ 项结果",
                            "sZeroRecords": "没有匹配结果",
                            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                            "sInfoPostFix": "",
                            "sSearch": "搜索:",
                            "sUrl": "",
                            "sEmptyTable": "表中数据为空",
                            "sLoadingRecords": "载入中...",
                            "sInfoThousands": ",",
                            "oPaginate": {
                                "sFirst": "首页",
                                "sPrevious": "上页",
                                "sNext": "下页",
                                "sLast": "末页"
                            },
                            "oAria": {
                                "sSortAscending": ": 以升序排列此列",
                                "sSortDescending": ": 以降序排列此列"
                            }
                        }
                    });
                });


                $.get('/Sof/gogndanlichwq', {res: 1}).done(function (c) {
                    $('#table_id3').dataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        data: c,
                        columns: [
                            {data: 'date'},
                            {data: 'product'},
                            {data: 'part'}
                        ],
                        "order": [[0, "desc"]]
                    });

                    $('#table_id3').DataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        "createdRow": function ( row, data, index ) {
                            if ( data[2]=='all_done' ) {
                                $('td', row).eq(2).css('font-weight',"bold").css("color","red");
                                $('td', row).eq(1).css('font-weight',"bold").css("color","red");
                            }
                        },
                        "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                        language: {
                            "sProcessing": "处理中...",
                            "sLengthMenu": "显示 _MENU_ 项结果",
                            "sZeroRecords": "没有匹配结果",
                            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                            "sInfoPostFix": "",
                            "sSearch": "搜索:",
                            "sUrl": "",
                            "sEmptyTable": "表中数据为空",
                            "sLoadingRecords": "载入中...",
                            "sInfoThousands": ",",
                            "oPaginate": {
                                "sFirst": "首页",
                                "sPrevious": "上页",
                                "sNext": "下页",
                                "sLast": "末页"
                            },
                            "oAria": {
                                "sSortAscending": ": 以升序排列此列",
                                "sSortDescending": ": 以降序排列此列"
                            }
                        }
                    });


                });


                setTimeout(xunhuan, 60000);//这里的1000表示1秒有1000毫秒,1分钟有60秒,7表示总共7分钟
            }

            $("#tabs").tabs();

            xunhuan();
        });


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
                    <li class="active"><a href="work_order_tools">报告工单监控</a></li>
                    <li><a href="sof_map_tools">报告人群地图</a></li>
                    <li><a href="shiwu_people">项目三级人群</a></li>
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
            <li>
                <a href="sof_login"> 退出登录</a>
            </li>
        </ul>
    </div>
</nav>


<div id="tabs">
    <ul>
        <li><a href="#tabs-1">系统状况监测</a></li>
        <li><a href="#tabs-2">当前工单执行情况</a></li>
        <li><a href="#tabs-3">lichwq专用</a></li>
    </ul>
    <div id="tabs-1" style="
    length: 100%;
    width: 100%;text-align: center;
font-size: 30px;">
    </div>
    <div id="tabs-2">
        <table id="table_id2" class="display">
            <thead>
            <tr>
                <th>日期</th>
                <th>项目</th>
                <th>完成度</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="tabs-3">
        <table id="table_id3" class="display">
            <thead>
            <tr>
                <th>日期</th>
                <th>项目</th>
                <th>完成度</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>

</html>