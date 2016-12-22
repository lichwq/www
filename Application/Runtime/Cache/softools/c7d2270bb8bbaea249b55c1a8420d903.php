<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title>报表工单上传</title>
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
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
        }
    </style>


    <script>

//        $(function xunhuan() {
//            $.get('/Subscribe/businss_assessment_status', {res: 1, res1: 1}).done(function (points) {
//                if ((points[0]['status']==0)&&(points[1]['status']==0)){
//                    $("#file").attr("disabled", false);
//                    $("#submit").attr("disabled", false);
//                }
//                else {
//                    $("#file").attr("disabled", true);
//                    $("#submit").attr("disabled", true);
//                }
//            });
//            setTimeout(xunhuan, 5000);//这里的1000表示1秒有1000毫秒,1分钟有60秒,7表示总共7分钟
//        });
//
//        $(function () {
//            $.get('/Subscribe/businss_assessment_status', {res: 1, res1: 1}).done(function (points) {
//                if ((points[2]['status'].indexOf("浙江")>=0)||(points[2]['status'].indexOf("上海")>=0)||(points[2]['status'].indexOf("江苏")>=0)){
//
//                }
//                else {
//                    alert("上传的excel中project字段不包含地域信息!!!!!!!请等待系统自动恢复待机!!!!");
//                }
//            });
//
//        });



            $.get('/Subscribe/businss_assessment_status', {res: 1, res1: 1}).done(function (points) {


                $('#result_table').empty();
                var tmp = $('<tr>');
                var tmp_td = $('<td>');


                for (king = 0; king < points.length; king++) {
                    var _tmp = tmp.clone();
                    var _tmp_td = tmp_td.clone();
                    _tmp.attr('id', king);
                    _tmp_td.text(points[king].keywords);
                    $('#result_table').append(_tmp);
                    $('#'+king).append(_tmp_td);
                }

//                console.log(count(points));



//                points.forEach(function (d) {
//                    var _tmp = tmp.clone();
//                    var _tmp_td = tmp_td.clone();
////                    _tmp.val(d.keywords);
//                    _tmp.attr('id', n);
//                    _tmp_td.text(d.keywords);
//                    $('#0').append(_tmp_td);
//                    $('#result_table').append(_tmp);
//                    n = n+1;
//                });

//                console.log(points);

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
                    <li class="active"><a href="gongdanshangchuan">报告工单上传</a></li>
                    <li><a href="work_order_tools">报告工单监控</a></li>
                    <li><a href="sof_map_tools">报告人群地图</a></li>
                    <li><a href="shiwu_people">项目三级人群</a></li>
                    <li><a href="yichang">项目人群异动分析</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    销售支持
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="">项目电话</a></li>
                    <li><a href="">项目热区</a></li>
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

<form action="/Subscribe/businss_assessment_upload" method="post" enctype="multipart/form-data">
    <br /><br />
    <table align="center">
        <tr>
            <td><input id="file" name="photo" type="file" value="" /></td>
            <td><input id="submit" type="submit" value="上传" name="" /></td>
            <td><button type="button">开始业务评估</button></td>
        </tr>
    </table>
</form>

<h1 id="test" style="position: absolute;left: 45%;top:45%"></h1>
<div >
    <table  class="table table-striped" id = "case">
        <thead>
        <tr>
            <th>楼盘名称</th>
        </tr>
        </thead>
            <tbody id="result_table">
            </tbody>
    </table>
</div>
</body>
</html>