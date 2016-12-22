<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title>上富业务评估系统</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link href="/Public/loading.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/Public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/Public/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript" src="/public/cebiandaohang/js/side-bar.js"></script>
    <style type="text/css">
        body {
            position:relative;
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
        }
        h2{
            color:#FFFFFF;
            font-size:90%;
            font-family:arial;
            margin:10px 20px 50px 20%;
            font-weight:bold;
        }
        h2 span{
            font-size:105%;
            font-weight:normal;
        }
        #sideBar{
            position: absolute;
            width: auto;
            height: auto;
            top: 200px;
            right:0px;
            background-image:url("http://127.0.0.1/public/cebiandaohang/images/background.gif");
            background-position:top left;
            background-repeat:repeat-y;
        }
        #sideBarTab{
            float:left;
            height:137px;
            width:28px;
        }
        #sideBarTab img{
            border:0px solid #FFFFFF;
        }
        #sideBarContents{
            overflow:hidden !important;
        }

        #sideBarContentsInner{
            width:200px;
        }
    </style>

    <script>

        $(function xunhuan() {
            $.get('/Sof/businss_assessment_ex_status', {is_query: 1, res1: 1}).done(function (points) {
                if (points[0]['status']==0){
                    $("#file").attr("disabled", false);
                    $("#assessment_button").attr("disabled", false);

                }
                else {
                    $("#file").attr("disabled", true);
                    $("#submit").attr("disabled", true);
                    $("#assessment_button").attr("disabled", true);
                }
            });
            setTimeout(xunhuan, 5000);//这里的1000表示1秒有1000毫秒,1分钟有60秒,7表示总共7分钟
        });
//
//        $(function () {
//            $.get('/Sof/businss_assessment_status', {res: 1, res1: 1}).done(function (points) {
//                if ((points[2]['status'].indexOf("浙江")>=0)||(points[2]['status'].indexOf("上海")>=0)||(points[2]['status'].indexOf("江苏")>=0)){
//
//                }
//                else {
//                    alert("上传的excel中project字段不包含地域信息!!!!!!!请等待系统自动恢复待机!!!!");
//                }
//            });
//
//        });

            $.get('/Sof/businss_assessment_status', {res: 1, res1: 1}).done(function (points) {

                $('#result_table').empty();
                var tmp = $('<tr>');
                var tmp_td = $('<td>');

                for (king = 0; king < points.length; king++) {
                    var _tmp = tmp.clone();
                    var _tmp_td = tmp_td.clone();
                    var _tmp_td_2 = tmp_td.clone();
                    _tmp.attr('id', king);
                    if(points[king].is_trade=='没有'){
                        _tmp_td_2.attr('style','color:red');
                    }else{
                        _tmp_td_2.attr('style','color:green');
                    }

                    _tmp_td.text(points[king].keywords);
                    _tmp_td_2.text(points[king].is_trade);
                    $('#result_table').append(_tmp);
                    $('#'+king).append(_tmp_td);
                    $('#'+king).append(_tmp_td_2);
                }
            });

$(function () {

    $("#assessment_button").click(function () {
        $("#file").attr("disabled", true);
        $("#submit").attr("disabled", true);
        $("#assessment_button").attr("disabled", true);
        $('#test1').show();
        $('#yewu').empty;

        $.get('/Sof/businss_assessment_exe_data', {is_query: 1, res1: 1}).done(function (points) {

            $("#file").attr("disabled", false);
            $("#submit").attr("disabled", false);
            $("#assessment_button").attr("disabled", false);

            $('#yewu').html('<iframe style="width: 100%;height: 1300px" src="http://softools.richest007.com/subscribe/k_20160719_new_experiment?keywords=楼盘业务评估&typename=%E5%9C%B0%E9%93%81&levname=%E4%BA%86%E8%A7%A3&width=100&height=100&type=scatter&interval=1" frameborder="0"></iframe>');
            $('#test1').hide();
        });

    });



    $("#file").click(function () {
        $("#submit").attr("disabled", false);
    });

    $("#submit").attr("disabled", true);

});


        xunhuan();

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
                    <li><a href="yichang">项目人群异动分析</a></li>
                    <li class="active"><a href="bussiness_assessment_workorder">业务评估系统</a></li>
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

<form action="/Sof/businss_assessment_upload" method="post" enctype="multipart/form-data">
    <br /><br />
    <table align="center">
        <tr>
            <td><input  class="btn btn-default" id="file" name="photo" type="file" value="" /></td>
            <td><input  class="btn btn-default" id="submit" type="submit" value="上传" name="" /></td>
            <td><button  class="btn btn-default" id="assessment_button" type="button">开始业务评估</button></td>
        </tr>
    </table>
</form>

<h1 id="test" style="position: absolute;left: 45%;top:45%"></h1>
<div style="margin: 2% 10% 2% 10%">
    <table  class="table table-striped" id = "case">
        <thead>
        <tr>
            <th>楼盘名称</th>
            <th>是否有交易</th>
        </tr>
        </thead>
            <tbody id="result_table">
            </tbody>
    </table>
</div>

<div id="yewu" style="margin: 5% 1% 2% 1%">
</div>

<div id="test1"  style=";background-color: white; display :none ; opacity: 0.6;position: absolute;left: 0;top:0;height: 90%;width: 100%;margin-top: 53px;" class="spinner">
    <div class="rect1"></div>

    <div class="rect2"></div>

    <div class="rect3"></div>

    <div class="rect4"></div>

    <div class="rect5"></div>

    <div class="rect6"></div>

    <div class="rect7"></div>
</div>

</body>

</html>