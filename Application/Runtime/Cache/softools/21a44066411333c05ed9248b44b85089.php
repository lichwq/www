<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>上富大数据异常处理系统</title>
    <!-- Custom Theme files -->
    <link href="/Public/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="/public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <!-- Custom Theme files -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <!--Google Fonts-->
    <!--<link href='http://fonts.useso.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>-->
    <!--<link href='http://fonts.useso.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <!--Google Fonts-->
</head>
<body>
<div class="login">
    <h2>欢迎来到上富大数据处理系统!</h2>
    <div class="login-top">
        <h1>上富大数据处理系统</h1>
        <form action="/Sof/check_login_special" method="post">
            <input type="text" name="username" value="请输入帐号" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入帐号';}">
            <input id="passwd" type="text" name="password" value="请输入密码" onfocus="this.value = '';this.type = 'password';" onblur="if (this.value == '') {this.value = '请输入密码';this.type = 'text';}">
            <div class="forgot">
                <!--<a href="#">forgot Password</a>-->
                <input type="submit" value="登录" >
            </div>
        </form>
    </div>
    <div class="login-bottom">
        <!--<h3>新用户 &nbsp;<a href="sof_register">注册</a></h3>-->
    </div>
</div>
<!--<div class="copyright">-->
    <!--<p>Copyright &copy; 2015.Company name All rights reserved.<a target="_blank" href="">&#x7F51;&#x9875;&#x6A21;&#x677F;</a></p>-->
<!--</div>-->


</body>



</html>