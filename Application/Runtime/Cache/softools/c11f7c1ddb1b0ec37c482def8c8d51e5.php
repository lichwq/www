<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>上富大数据异常处理系统</title>
    <!-- Custom Theme files -->
    <link href="/Public/style.css" rel="stylesheet" type="text/css" media="all"/>
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
        <h1>开始注册</h1>
        <form name="form1" id="form1" action="/Sof/sof_register_ruku" method="post">
            <input type="text" name="username" value="请输入帐号" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入帐号';}">
            <input type="text" name="password" value="请输入密码" onfocus="this.value = '';this.type = 'password';" onblur="if (this.value == '') {this.value = '请输入密码';this.type = 'text';}">
            <input type="text" name="password_check" value="请确认密码" onfocus="this.value = '';this.type = 'password';" onblur="if (this.value == '') {this.value = '请确认密码';this.type = 'text';}">
            <input  style="width: 25%;margin: 0px 0px 12px 62%;" type="text" name="yaoqingma" value="请输入邀请码" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入邀请码';}">
            <div class="forgot">
                <!--<a href="#">forgot Password</a>-->
                <input type="submit" value="注册" onClick="return check()">
            </div>
        </form>
    </div>
    <div class="login-bottom">
        <h3>老用户 &nbsp;<a href="sof_login">登录</a></h3>
    </div>
</div>


</body>
<script language="javascript" type="text/javascript">
    function check()
    {

        if (document.form1.username.value==""||document.form1.username.value=="请输入帐号"){
            alert("请输入登录账号!");
            return false;
        }
        if (document.form1.password.value==""||document.form1.password.value=="请输入密码"){
            alert("请输入登录密码!");
            return false;
        }
        if (document.form1.password_check.value==""||document.form1.password_check.value=="请确认密码"){
            alert("请输入重复密码!");
            return false;
        }
        if (document.form1.yaoqingma.value==""||document.form1.yaoqingma.value=="请输入邀请码"){
            alert("请输入邀请码!");
            return false;
        }
        if (document.form1.password.value!=document.form1.password_check.value){
            alert("对不起!两次输入的密码不同");
            return false;
        }

        return true;

    }
</script>

</html>