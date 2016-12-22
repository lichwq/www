<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>集成工具开发页面</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.0.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        //        $.get('/Sof/gongdanzhuangtai', {res: 1}).done(function (k) {
        //            $("#tabs-1").text(k[0]['status']).show();
        //        });
    </script>


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

<nav class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">上富工具集</a>
    </div>
    <div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="http://121.41.5.20/index.php/home/Index/tabs_test">工单状态类</a></li>
            <li><a href="http://adms.richest007.net:8080/wo#/">工单上传工具</a></li>
            <li><a href="http://121.41.5.20/index.php/home/Index/ajax">地图工具</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    看看有啥好玩的
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">没有</a></li>
                    <li><a href="#">真没有</a></li>
                    <li><a href="#">真的没有!</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">系统状况监测</a></li>
        <li><a href="#tabs-2">当前工单执行情况</a></li>
        <li><a href="#tabs-3">lichwq专用</a></li>
        <li><a href="#tabs-4">测试页面</a></li>
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
    <div id="tabs-4">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover"
               id="example">
            <thead>
            <tr>
                <th>昵称</th>
                <th>技能</th>
                <th>添加时间</th>
                <th>备注</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</body>


<script>




</script>

</html>