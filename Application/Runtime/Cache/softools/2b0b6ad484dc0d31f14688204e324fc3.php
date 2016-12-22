<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <script src="/Public/app.bundle.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/Public/app.css">
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/public/dataTables.jqueryui.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>

    <script>

        $(function () {

            $.get('/Sof/new_people_select_dim_port', {}).done(function (result_final) {

                var tmp_div = $('<div>');

                var tmp_ul = $('<ul>');

                for(var bswx = 0;bswx<result_final.length;bswx++) {

                    var _tmp_div = tmp_div.clone();
                    _tmp_div.attr('class', 'item');
                    _tmp_div.attr('id', 'item_'+bswx);
                    $('#content-item-list_1').append(_tmp_div);


                    var _tmp_div_2 = tmp_div.clone();
                    _tmp_div_2.attr('id', bswx);
                    _tmp_div_2.attr('class', 'type pull-left');
                    _tmp_div_2.text(result_final[bswx][0]['typename']+': '+'0');
                    $('#'+'item_'+bswx).append(_tmp_div_2);

                    var _tmp_ul = tmp_ul.clone();
                    _tmp_ul.attr('class','ul_'+result_final[bswx][0]['typename']);
                    _tmp_ul.attr('id', 'ul_'+bswx);
                    _tmp_ul.attr('val1', '');
                    $('#'+'item_'+bswx).append(_tmp_ul);

                    var tmp = $('<li>');
                    result_final[bswx].forEach(function (d) {
                        var _tmp = tmp.clone();
                        _tmp.attr('class', '');
                        _tmp.text(d.tagname);
                        $('#'+'ul_'+bswx).append(_tmp);
                    });
                }

                $("li").click(function () {

                    if ($(this).attr("class") == 'active') {
                        $(this).attr("class", '');
                    }
                    else {
                        $(this).attr("class", 'active');

                        var n = 0;

                        total_shuzu = [];
                        pzbs = '';

                    }

                    var total_result = [];

                    $(this).parent().children("li.active").each(function () {
                        var result = 'tagname =' + '\'' + $(this).text() + '\'' + ' or ';
                        total_result = total_result + result;
                    });

                    total_result = total_result + "tagname = ''";

//                    console.log(total_result);

                    $(this).parent().attr('val1',total_result);
//                    $(this).parent().text(total_result);

//                $(this).parent().prev().text('fdsfsd');

//                var fun = '';
                    var fun = $(this);

                    var m1_count = '';

                    $.get('/Sof/new_people_select_port', {chaoxiang: total_result}).done(function (points) {

                        m1_count = points[0]['count'];
//                    var bspz = '';
                        var bspz = fun.parent().prev().text().split(':')[0] + ': ' + m1_count;
                        fun.parent().prev().text(bspz);

                    });

                });



                $("#next").click(function () {

                    var ul_tot = '';

                    for(var bspz = 0;bspz<result_final.length;bspz++) {

                        if($("#ul_" + bspz).attr('val1')!=''&&$("#ul_" + bspz).attr('val1')!="tagname = ''")
                        {

                            var ul_sin = $("#ul_" + bspz).attr('val1');

                            ul_tot = '('+ul_sin+')' + ' and ' + ul_tot ;
                        }
                    }



                    //用来提交到sql;
                    console.log(ul_tot.substring(0,ul_tot.length - 4));



                    function xunhuan() {
                        $.get('/Sof/new_people_select_final_port', {res: ul_tot.substring(0,ul_tot.length - 4)}).done(function (k) {
                            $('#table_id2').dataTable(
                                    {"bProcessing": true,
                                        "bSortClasses": true,
                                        "bStateSave": true, //保存状态到cookie
                                        "bJQueryUI": true,
                                        bDestroy: true,
                                        data: k,
                                        columns: [
                                            {data: 'userid'}
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
                    }

                    $("#tabs").tabs();

                    xunhuan();


                    $(".step-1").hide();
                    $(".step-2").show();
                    $("#next").hide();
                    $("#prv").show();

                });

                $("#prv").click(function () {
                    $(".step-2").hide();
                    $(".step-1").show();
                    $("#next").show();
                    $("#prv").hide();
                });


                $("#qingkong").click(function () {

                    $('li').attr('class','');
                    $('ul').attr('val1','');
                    $('li').parent().prev().each(function () {
                        $(this).text($(this).text().split(':')[0] +': 0');
                    });

                })
            });


            $("#keywords_search").keyup(function () {
                k = $(this).val();
                if (k == '') {
                    $("li").parent().prev().show();
                    $("li").parent().show();
                    $("li").show();
                    return;
                }

                $("li").hide();

                $("li").parent().prev().hide();

                $("li").parent().parent().hide();


                $("li").each(function(){

                    if($(this).text().indexOf(k)>=0){
                        $(this).parent().parent().show();
                        $(this).show();
                        $(this).parent().prev().show();
                    }
                });
            });
        });


        $(function () {

        });

    </script>

</head>

<body>

<div class="sof-modal" data-target=".bs-example-modal-lg">
    <div class="choose-pane" style="width: 80%;height: 80%">
        <div class="choose-title">
<div class="pull-right choose-operation">
        </div></div><div class="clearfix"></div>
        <div class="choose-content step0">
        <div class="step-1">
        <div class="choose-content-left pull-left">
        <div class="item icon icon_fc active">房产-新房</div>
        </div>
        <div class="choose-content-main  pull-right" style="width: 980px">
<div id ='content-item-list_1' class="content-item-list " style="height: 440px;">
    <div id="search" class="chooseSearch">
        <button id="qingkong" class="btn btn-danger pull-right"  style="display: block;margin-right: 8%">清空所选</button>
        <input id="keywords_search" type="text" class="form-control" placeholder="搜索关键字,如：楼盘名称">
        </div>
    <div class="loading-pane ">loading...</div>
</div></div>
        </div>
            <div class="step-2" style="height: 440px;">
                <div class="btn-group" style="height: 440px;">
        </div>

            </div>
        </div>

        <div class="next">
        <button id="next" class="btn btn-default pull-right"  style="display: block;">下一步</button>
        <!--<button class="btn btn-success pull-right"  style="display: none;">确认</button>-->
        <button id="prv" class="btn btn-default pull-right" style="display: none;">上一步</button>
    </div>
    </div>
    <div class="modal-backdrop">
    </div>
    </div>




<div id="tabs">
    <ul>
        <li><a href="#tabs-2">当前工单执行情况</a></li>
    </ul>
    <div id="tabs-2">
        <table id="table_id2" class="display">
            <thead>
            <tr>
                <th>用户</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>