<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>电信投放部署</title>
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
                    <li><a href="click_tools">结案报告</a></li>
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
                    <li class="active"><a href="sof_cm">电信投放部署</a></li>
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
<iframe src="http://adms.richest007.net:9876/cm" frameborder="0" width="100%" height="2500px"></iframe>
</body>
</html>