<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/public/jquery-ui.css">
    <script src="/public/jquery-1.12.0.js"></script>
    <script src="/public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/public/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>
    <script>
        $(function () {
                $.get('/Wechat/wechat_workorder_list', {res: 1}).done(function (k) {
                    $('#table_id2').DataTable(
                            {"bProcessing": true,
//                                "autoWidth": false,
                                "columnDefs": [
                                    { "width": "20%"}, {"width": "20%"},{"width": "20%" }
                                ],
                                "bSortClasses": true,
                                "bStateSave": true, //保存状态到cookie
                                "bJQueryUI": true,
                                bDestroy: true,
                                data: k,
                                columns: [{data: 'date'},
                                    {data: 'project'},
                                    {data: 'part'}]
                            }
                    );


                    $('#table_id2').DataTable(
                            {
                        "bProcessing": true,
                        "bSortClasses": true,
//                                "autoWidth": false,
                        "bStateSave": true, //保存状态到cookie
                                "columnDefs": [
                                    { "width": "20%"}, {"width": "20%"},{"width": "20%" }
                                ],
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

            $("#tabs").tabs();

            })

    </script>

</head>
<body>


<div id="tabs">
    <div id="tabs-2">
        <table id="table_id2" class="display">
            <thead>
            <tr>
                <th>日期</th>
                <th>项目</th>
                <th>完成度</th>
            </tr>
            </thead>
            <tbody style="font-size: 30px">
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

<!--<script>-->

    <!--$('#table_id2_wrapper').attr(width = "70%");-->

<!--</script>-->
</html>