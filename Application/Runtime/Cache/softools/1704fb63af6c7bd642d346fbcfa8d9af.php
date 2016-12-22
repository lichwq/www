<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
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
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <script type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript"></script>
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

    <script>
        $(function () {

            $('#h_tab6').hide();
            $('#h_tab1').hide();

            //初始化下拉列表:
            $('#list_jingpin').append('<option>无数据</option>>');

            $("#map_li").click(function () {
                $('#tabs-5').html('<iframe src="yichang_map_cirecle" frameborder="0" width="100%" height="1200"></iframe>');
            });

            var myChart = echarts.init(document.getElementById('main_1'));
            myChart.showLoading();

            $('#table_id1').dataTable(
                    {
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
            $('#table_id2').dataTable(
                    {
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
            $('#table_id3').dataTable(
                    {
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


            //以下是本案计算系列
            $("#chufa_button").click(function () {
                $('#h_tab1').show();
                $('#tabs-5').html('<iframe src="yichang_map_cirecle" frameborder="0" width="100%" height="800"></iframe>');
                bb = $("#list option:selected").val();
                ccc = $("#list_wuye option:selected").val();
                b = $("#input_keywords").val();
                if(b.length==0){
                    $('#h_tab1').hide();
                    alert("请输入想要查询的本案楼盘");
                    return;
                }
                $("#jingpin_chart_button").attr("disabled", true);
                $("#chufa_button").attr("disabled", true);
                $("#list_jingpin").attr("disabled", true);
                $("#jingpin_button").attr("disabled", true);

                $.get('/Sof/yichang_qushu', {keywords: b, beilv: bb, wuye: ccc}).done(function (result) {

                    if (result[0]=='n'){
                        $("#jingpin_chart_button").attr("disabled", false);
                        $("#list_jingpin").attr("disabled", false);
                        $("#chufa_button").attr("disabled", false);
                        $("#jingpin_button").attr("disabled", false);
                        $('#h_tab1').hide();
                        alert("请检查本案名称,没有这个楼盘!!!");
                    }


                    $('#list_jingpin').empty();
                    var tmp_option = $('<option>');
                    result[4].forEach(function (d) {
                        var _tmp = tmp_option.clone();
                        _tmp.val(d.xg_keywords);
                        _tmp.text(d.xg_keywords);
                        $('#list_jingpin').append(_tmp);
                    });

                    myChart.showLoading();
                    var k = [];
                    var c = [];
                    var b = [];
                    var d = [];
                    var e = [];
                    var i = 0;
                    result[3].forEach(function(kk) {
                        k[i] = kk['date'];
                        b[i] = kk['one_day_count'];
                        c[i] = kk['one_day_count_1'];
                        d[i] = kk['one_day_count_2'];
                        e[i] = kk['three_avg_count'];
                        i=i+1;
                    });

                    // 基于准备好的dom，初始化echarts实例

                    // 指定图表的配置项和数据
                    var option = {
                        tooltip : {
                            trigger: 'item'
                        },
                        toolbox: {
                            show : true,
                            feature : {
                                mark : {show: true},
                                dataView : {show: true, readOnly: false},
                                magicType: {show: true, type: ['line', 'bar']},
                                restore : {show: true},
                                saveAsImage : {show: true}
                            }
                        },
                        title: {
                            text: '异动展示'
                        },
                        legend: {
                            data:['关注量','异常点','三日均线']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: {
                            axisLabel: {
                                interval: 0
                            },
                            type : 'category',
                            data: k
                        },
                        yAxis: {
                            type : 'value'
                        },
                        series: [

                            {   name: '关注量',
                                type: 'bar',
                                data: c},

                            {   name: '异常点',
                                type: 'bar',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'top'
                                    }
                                },
                                data: d},

                            {   name: '三日均线',
                                type: 'line',
                                data: e}

                        ]
                    };

                    // 使用刚指定的配置项和数据显示图表。
                    myChart.hideLoading();
                    myChart.setOption(option);

                    $('#table_id1').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: result[0],
                                columns: [
                                    {data: 'num'},
                                    {data: 'date'},
                                    {data: 'tagname'},
                                    {data: 'one_day_count'},
                                    {data: 'three_avg_count'},
                                    {data: 'm_count'},
                                    {data: 'percent'},
                                    {data: 'unusual'}
                                ]
                            }
                    );


                    $('#table_id1').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                "createdRow": function (row, data, index) {
                                    if (data[7] == '1') {
                                        $('td', row).eq(7).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(6).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(5).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(4).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(3).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(2).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(1).css('font-weight', "bold").css("color", "red");
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



                    $('#table_id2').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: result[1],
                                columns: [
                                    {data: 'date'},
                                    {data: 'center'},
                                    {data: 'to_left_left'},
                                    {data: 'left_f_m_minus'},
                                    {data: 'left_count_day'},
                                    {data: 'to_right_right'},
                                    {data: 'right_f_m_minus'},
                                    {data: 'right_count_day'}
                                ],
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
                            }
                    );


                    $('#table_id3').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: result[2],
                                columns: [
                                    {data: 'center_date'},
                                    {data: 'left_new_date'},
                                    {data: 'left_f_m_minus'},
                                    {data: 'left_count_day'},
                                    {data: 'right_new_date'},
                                    {data: 'right_f_m_minus'},
                                    {data: 'right_count_day'}
                                ],
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
                            }
                    );


                    $("#jingpin_chart_button").attr("disabled", false);
                    $("#chufa_button").attr("disabled", false);
                    $("#list_jingpin").attr("disabled", false);
                    $("#jingpin_button").attr("disabled", false);
                    $('#h_tab1').hide();



                });
            });


//以下是竞品计算


            $("#jingpin_button").click(function () {
                $('#tabs-5').html('<iframe src="yichang_map_cirecle" frameborder="0" width="100%" height="800"></iframe>');
                bb = $("#list option:selected").val();
                b = $("#list_jingpin option:selected").val();
                ccc = $("#list_wuye option:selected").val();
                $("#jingpin_chart_button").attr("disabled", true);
                $("#chufa_button").attr("disabled", true);
                $("#list_jingpin").attr("disabled", true);
                $("#jingpin_button").attr("disabled", true);

                $.get('/Sof/yichang_qushu', {keywords: b, beilv: bb , wuye: ccc}).done(function (result) {

                    if (result[0]=='n'){
                        $("#jingpin_chart_button").attr("disabled", false);
                        $("#list_jingpin").attr("disabled", false);
                        $("#chufa_button").attr("disabled", false);
                        $("#jingpin_button").attr("disabled", false);
                        $('#h_tab1').hide();
                        alert("请检查本案名称,没有这个楼盘!!!");
                    }

//                    var myChart = echarts.init(document.getElementById('main_1'));
                    myChart.showLoading();
                    var k = [];
                    var c = [];
                    var b = [];
                    var d = [];
                    var e = [];
                    var i = 0;
                    result[3].forEach(function(kk) {
                        k[i] = kk['date'];
                        b[i] = kk['one_day_count'];
                        c[i] = kk['one_day_count_1'];
                        d[i] = kk['one_day_count_2'];
                        e[i] = kk['three_avg_count'];
                        i=i+1;
                    });

                    // 基于准备好的dom，初始化echarts实例

                    // 指定图表的配置项和数据
                    var option = {
                        tooltip : {
                            trigger: 'item'
                        },
                        toolbox: {
                            show : true,
                            feature : {
                                mark : {show: true},
                                dataView : {show: true, readOnly: false},
                                magicType: {show: true, type: ['line', 'bar']},
                                restore : {show: true},
                                saveAsImage : {show: true}
                            }
                        },
                        title: {
                            text: '异动展示'
                        },
                        legend: {
                            data:['关注量','异常点','三日均线']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: {
                            axisLabel: {
                                interval: 0
                            },
                            type : 'category',
                            data: k
                        },
                        yAxis: {
                            type : 'value'
                        },
                        series: [

                            {   name: '关注量',
                                type: 'bar',
                                data: c},

                            {   name: '异常点',
                                type: 'bar',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'top'
                                    }
                                },
                                data: d},

                            {   name: '三日均线',
                                type: 'line',
                                data: e}

                        ]
                    };

                    // 使用刚指定的配置项和数据显示图表。
                    myChart.hideLoading();
                    myChart.setOption(option);



                    $('#table_id1').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: result[0],
                                columns: [
                                    {data: 'num'},
                                    {data: 'date'},
                                    {data: 'tagname'},
                                    {data: 'one_day_count'},
                                    {data: 'three_avg_count'},
                                    {data: 'm_count'},
                                    {data: 'percent'},
                                    {data: 'unusual'}
                                ]
                            }
                    );


                    $('#table_id1').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                "createdRow": function (row, data, index) {
                                    if (data[7] == '1') {
                                        $('td', row).eq(7).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(6).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(5).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(4).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(3).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(2).css('font-weight', "bold").css("color", "red");
                                        $('td', row).eq(1).css('font-weight', "bold").css("color", "red");
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



                    $('#table_id2').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: result[1],
                                columns: [
                                    {data: 'date'},
                                    {data: 'center'},
                                    {data: 'to_left_left'},
                                    {data: 'left_f_m_minus'},
                                    {data: 'left_count_day'},
                                    {data: 'to_right_right'},
                                    {data: 'right_f_m_minus'},
                                    {data: 'right_count_day'}
                                ],
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
                            }
                    );



                    $('#table_id3').dataTable(
                            {
                                "bProcessing": true,
                                "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: result[2],
                                columns: [
                                    {data: 'center_date'},
                                    {data: 'left_new_date'},
                                    {data: 'left_f_m_minus'},
                                    {data: 'left_count_day'},
                                    {data: 'right_new_date'},
                                    {data: 'right_f_m_minus'},
                                    {data: 'right_count_day'}
                                ],
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
                            }
                    );

                    $("#jingpin_chart_button").attr("disabled", false);
                    $("#chufa_button").attr("disabled", false);
                    $("#list_jingpin").attr("disabled", false);
                    $("#jingpin_button").attr("disabled", false);

                });
            });

            $("#tabs").tabs();
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
                    <li><a href="work_order_tools">报告工单监控</a></li>
                    <li><a href="sof_map_tools">报告人群地图</a></li>
                    <li><a href="shiwu_people">项目三级人群</a></li>
                    <li class="active"><a href="yichang">项目人群异动分析</a></li>
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
                    <li><a href="">围栏坐标（杭州专用）</a></li>
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

<h1 align="center">上富楼盘数据异常状态处理系统</h1><br />

<div id="main" style="width: 100%;height:100%;">
<div style="margin-left: 20%;">
    <input type="text" placeholder="输入想计算的楼盘本案" style="width: 200px" id="input_keywords" name="lastname" />&nbsp标准差倍率:
    <select name="list" id="list"  style="font-size: large">
        <option value="1">1</option>
        <option value="1.5" selected="selected">1.5</option>
    </select>
    <button type="button" class="btn btn-primary btn-sm" id="chufa_button" value="计算本案异常"><span
            class="glyphicon glyphicon-search" aria-hidden="true">计算本案异常</span>
    </button>
    &nbsp 竞品列表 : <select name="list_jingpin" id="list_jingpin" style="font-size: large"></select>
    &nbsp 物业类型 : <select name="list_jingpin" id="list_wuye" style="font-size: large">
    <option value="住宅" selected="selected">住宅</option>
    <option value="别墅">别墅</option>
    <option value="商住">商住</option>
    <option value="商铺">商铺</option>
    <option value="写字楼">写字楼</option>
</select>
    <button type="button" class="btn btn-info btn-sm" id="jingpin_button" value="计算竞品异常"><span
            class="glyphicon glyphicon-star" aria-hidden="true">计算竞品异常</span>
    </button>
</div>
    <div  class="form-control" id="result_div" style="
    display: none;
    border: 1px solid #000;
    width: 14%;
    height: 200px;
    margin-left: 20%;
    overflow-y: scroll;">
        <ul style="
        list-style: none;
    " class="list">
        </ul>
    </div>

<br />
    <h1 id="h_tab1" align="center">正在计算中....</h1>
<br />

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">异常状况总览</a></li>
        <li><a href="#tabs-2">异常状况一阶明细</a></li>
        <li><a href="#tabs-3">异常状况二阶明细</a></li>
        <li><a href="#tabs-4">图例</a></li>
        <li id="map_li"><a href="#tabs-5">地图</a></li>
        <li><a href="#tabs-6">竞品异动表格</a></li>
    </ul>
    <div id="tabs-1">
        <table id="table_id1" class="display">
            <thead>
            <tr>
                <th>周期编号</th>
                <th>日期</th>
                <th>项目名称</th>
                <th>当日访问量</th>
                <th>三日平均访问量</th>
                <th>单日访问量差</th>
                <th>单日访问量差百分比</th>
                <th>是否异常</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="tabs-2">
        <table id="table_id2" class="display">
            <thead>
            <tr>
                <th>日期</th>
                <th>异常中心点</th>
                <th>左侧拐点</th>
                <th>左差值</th>
                <th>左差值天数</th>
                <th>右侧拐点</th>
                <th>右差值</th>
                <th>右差值天数</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <th>异常点日期</th>
                <th>左侧高位新点日期</th>
                <th>左差值</th>
                <th>左差值天数</th>
                <th>右侧高位新点日期</th>
                <th>右差值</th>
                <th>右差值天数</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="tabs-4">
        <div id="main_1" style="width: 100%;height: 1000px;"></div>
    </div>
    <div id="tabs-5">
    </div>

    <div id="tabs-6">

        <div id="new">

            <div align="center">
        <button type="button" class="btn btn-danger btn-sm" id="jingpin_chart_button" value="计算异常列表"><span
                class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> 计算异常列表</span>
        </button>

            </div>
            <h1 id="h_tab6" align="center">正在计算中....</h1>
            <br />
        <table id ="table1" border="1" style="display: inline-table">
            <tbody id="tb_kks">
            <tr class="ttt" id="tk"></tr>
            <tr class="ttt" id="t0"></tr>
            <tr class="ttt" id="t1"></tr>
            <tr class="ttt" id="t2"></tr>
            <tr class="ttt" id="t3"></tr>
            <tr class="ttt" id="t4"></tr>
            <tr class="ttt" id="t5"></tr>
            <tr class="ttt" id="t6"></tr>
            <tr class="ttt" id="t7"></tr>
            <tr class="ttt" id="t8"></tr>
            <tr class="ttt" id="t9"></tr>
            <tr class="ttt" id="t10"></tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>

</body>

<script>
    $(function () {


        $("#input_keywords").keyup(function () {
            k = $(this).val();
            if (k == '') {
                    $('#result_div').hide();
                return;
            }
            $.get('/Sof/search_keywords_ajax', {res: k}).done(function (shuju) {
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
                            $('#result_div ul').append("<li>对不起,没有搜到楼盘</li>");
                        }
                    }
            );
        });

        var li_right = $('<li>');

        function creatInput() {
            var template = $('<div class="text">' +
                    '<input tyle="text" />' +
                    '<div class="clean">X</div>' +
                    '</div>');
            template.find('input').on('keyup', function () {
                if (template.find('input').val() == '') template.find('.clean').hide();
                template.find('.clean').show();
            });
            template.find('.clean').on('click', function () {
                template.find('input').val('');
                $(this).hide();
            });
            return template;
        }

        function scan() {
            $('[xinput]').each(function () {
                $(this).append(new creatInput());
            })
        }

        scan();

        $("#result_div ul").on('click', 'li', function () {
            var k = $(this).text();
            $('#input_keywords').val(k);
            $('#result_div').hide();
        });
    });





    //以下是本案计算系列

    function jingpin_chart(_keywords,_beilv,_wuye){

        $('.ttt').empty();
        $('#h_tab6').show();

        $.get('/Sof/yichang_jinpin_data_total', {keywords: _keywords, beilv: _beilv, wuye: _wuye}).done(function (key) {

            if (key[0]=='no'){
                $("#jingpin_chart_button").attr("disabled", false);
                $("#list_jingpin").attr("disabled", false);
                $("#chufa_button").attr("disabled", false);
                $("#jingpin_button").attr("disabled", false);
                $('#h_tab6').hide();
                alert("请检查本案名称,没有这个楼盘!!!");
            }

            $.get('/Sof/yichang_jinpin_new', {res2: _keywords,wuye: _wuye}).done(function (jingpin_result) {


                $.get('/Sof/yichang_data_new').done(function (result_new_data) {

                    var loupan = [];
                    var ranse = [];
                    var ranse_blue = [];
                    var i = 0;


                    try {
                        jingpin_result[0].forEach(function (dd) {

                            loupan[i] = result_new_data[0].filter(function (x) {
                                return x.tagname == dd.xg_keywords;
                            });

                            ranse[i] = result_new_data[1].filter(function (x) {
                                return x.tagname == dd.xg_keywords;
                            });

                            ranse_blue[i] = result_new_data[2].filter(function (x) {
                                return x.tagname == dd.xg_keywords;
                            });

                            i = i + 1;
                        });

//        console.log(loupan);

                        //标题(日期)
                        var tmp_option1 = $('<td style="font-size:16px;"></td>');
                        $('#tk').append(tmp_option1);
                        var c = 0;
                        loupan[0].forEach(function (dd) {
                            var _tmp1 = tmp_option1.clone();
                            _tmp1.attr('id', c + dd.date);
                            _tmp1.text(dd.date);
                            _tmp1.attr('style', "width: 40px;height: 20px");
                            $('#tk').append(_tmp1);
                            c = c + 1;
                        });


                        loupan.forEach(function (dd, index) {

                            //第一个楼盘(生成一个表格)
                            var first_gird = $('<td></td>');
                            first_gird.text(dd[0].tagname);
//                        first_gird.attr('style', "width: 40px;height: 40px");
                            $('#t' + index).append(first_gird);

                            var tmp_option2 = $('<td></td>');
                            loupan[index].forEach(function (dd) {
                                var _tmp1 = tmp_option2.clone();
                                _tmp1.attr('id', dd.tagname + dd.date);
                                _tmp1.attr('style', "width: 40px;height: 40px");
//                _tmp1.text(dd.tagname);
                                $('#t' + index).append(_tmp1);
                            });

                            ranse_blue[index].forEach(function (dd) {
                                $('#' + dd.tagname + dd.date).attr('bgcolor', "blue");
                            });

                            ranse[index].forEach(function (dd) {
                                $('#' + dd.tagname + dd.date).attr('bgcolor', "red");
                            });
                        });


                        ranse[0].forEach(function (dd) {
                            $('#' + dd.tagname + dd.date).attr('bgcolor', "red");
                        });
                    }catch(err){
                        alert('数据存在错误:原因可能为时间周期不连续或者某个竞品楼盘有异常!');
                    }

                    $("#jingpin_chart_button").attr("disabled", false);
                    $("#list_jingpin").attr("disabled", false);
                    $("#chufa_button").attr("disabled", false);
                    $("#jingpin_button").attr("disabled", false);
                    $('#h_tab6').hide();
                });
            });
        });
    }

    $("#jingpin_chart_button").click(function () {
        bb = $("#list option:selected").val();
        b = $("#input_keywords").val();
        ccc = $("#list_wuye option:selected").val();

        if(b.length==0){
         alert("请输入想要查询的本案楼盘");
            return;
        }
        $("#jingpin_chart_button").attr("disabled", true);
        $("#chufa_button").attr("disabled", true);
        $("#list_jingpin").attr("disabled", true);
        $("#jingpin_button").attr("disabled", true);
        jingpin_chart(b,bb,ccc);
    });

</script>

</html>