<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <title>异常处理</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.0.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!--<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>
</head>
<body>

<table id ="table1" border="1" style="display: inline-table">
    <tbody id="tb_kks">
    <tr id="tk"></tr>
    <tr id="t0"></tr>
    <tr id="t1"></tr>
    <tr id="t2"></tr>
    <tr id="t3"></tr>
    <tr id="t4"></tr>
    <tr id="t5"></tr>
    <tr id="t6"></tr>
    <tr id="t7"></tr>
    <tr id="t8"></tr>
    <tr id="t9"></tr>

    </tbody>
</table>


<script>

    function jingpin_chart(_keywords,_beilv){

    $.get('/Sof/yichang_jinpin_data_total', {keywords: _keywords, beilv: _beilv}).done(function (jingpin_result) {


        $.get('/Sof/yichang_jinpin_new', {res2: _keywords}).done(function (jingpin_result) {


            $.get('/Sof/yichang_data_new').done(function (result_new_data) {

                var loupan = [];
                var ranse = [];
                var i = 0;
                jingpin_result[0].forEach(function (dd) {
                    loupan[i] = result_new_data[0].filter(function (x) {
                        return x.tagname == dd.xg_keywords;
                    });

                    ranse[i] = result_new_data[1].filter(function (x) {
                        return x.tagname == dd.xg_keywords;
                    });

                    i = i + 1;
                });

//        console.log(loupan);


                //标题(日期)
                var tmp_option1 = $('<th></th>');
                $('#tk').append(tmp_option1);
                var c = 0;
                loupan[0].forEach(function (dd) {
                    var _tmp1 = tmp_option1.clone();
                    _tmp1.attr('id', c + dd.date);
                    _tmp1.text(dd.date);
                    $('#tk').append(_tmp1);
                    c = c + 1;
                });


                loupan.forEach(function (dd, index) {

                    //第一个楼盘(生成一个表格)
                    var first_gird = $('<td></td>');
                    first_gird.text(dd[0].tagname);
                    $('#t' + index).append(first_gird);


                    var tmp_option2 = $('<td></td>');
                    loupan[index].forEach(function (dd) {
                        var _tmp1 = tmp_option2.clone();
                        _tmp1.attr('id', dd.tagname + dd.date);
                        _tmp1.attr('style', "width: 40px;height: 40px");
//                _tmp1.text(dd.tagname);
                        $('#t' + index).append(_tmp1);
                    });


                    ranse[index].forEach(function (dd) {
                        $('#' + dd.tagname + dd.date).attr('bgcolor', "red");
                    });

                });


                ranse[0].forEach(function (dd) {
                    $('#' + dd.tagname + dd.date).attr('bgcolor', "red");
                });


            });

        });

    });

    }

</script>

</body>
</html>