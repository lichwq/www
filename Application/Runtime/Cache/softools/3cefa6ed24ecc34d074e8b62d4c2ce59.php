<?php if (!defined('THINK_PATH')) exit();?>﻿<html>
<head>
    <title>围栏坐标生成工具</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="/public/jquery-ui.css">
    <script src="/public/jquery-1.12.0.js"></script>
    <script src="/public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>
    <!--<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>-->
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
        }
    </style>

    <script>
        $(function () {
            $("#hot_map_button").click(function () {
                $("#hot_map_button").attr("disabled", true);
                $('#test').text('正在计算中....').show();
                    $.get('/Sof/sites_6_points_weilan', {res: 1, res1: 1}).done(function (points) {
                        $("#hot_map_button").attr("disabled", false);
                        $('#test').text('正在计算中....').hide();
                    });
                    });
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
                    <li><a href="yichang">项目人群异动分析</a></li>
                    <li><a href="bussiness_assessment_workorder">业务评估系统</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    销售支持
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <!--<li><a href="gongdanshangchuan">项目电话</a></li>-->
                    <!--<li><a href="work_order_tools">项目热区</a></li>-->
                    <li><a href="sof_map_tools">中介地图</a></li>
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
                    <li  class="active"><a href="sites_6_points">围栏坐标（杭州专用）</a></li>
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

<form action="/Sof/upload" method="post" enctype="multipart/form-data">

    <table align="center">
        <tr>
            <td><input name="photo" type="file" value=""></td>
            <td><input type="submit" value="上传" name=""></td>
            <td><input type="button" id="hot_map_button" style="width: 110px;"  value="计算围栏坐标"></td>
        </tr>
    </table>
</form>
<P align="center"><a href="<?php echo U('Sof/expUser');?>" >导出数据并生成excel</a></P><br/>
<h1 id="test" style="position: absolute;left: 45%;top:45%"></h1>
<div  align="center">
    <ul>

        <table width="60%">
            <thead>
            <tr>
                <th>project</th>
                <th>product</th>
            </tr>
            </thead>
        <?php if(is_array($rs)): $i = 0; $__LIST__ = $rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tbody>
                <tr>
                    <td><?php echo ($vo["project"]); ?></td>
                    <td><?php echo ($vo["product"]); ?></td>
                </tr>
                </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </ul>

</div>
</body>
</html>