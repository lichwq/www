<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <title>上富大数据异常处理系统</title>
    <!-- Custom Theme files -->
    <link href="/Public/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
</head>

<script>
    $(function () {
        $("#yanzhengma_pic").click(function () {
            $("#yanzhengma_pic").attr('src',"/sof/yanzhengma");
        });
    });
</script>

<body>

<div class="login">
    <h2>欢迎来到上富订阅系统综合版!</h2>
    <div class="login-top">
        <h1>上富订阅系统综合版</h1>
        <form action="/Sof/check_login" method="post">
            <input type="text" name="username" value="请输入帐号" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入帐号';}">
            <input id="passwd" type="text" name="password" value="请输入密码" onfocus="this.value = '';this.type = 'password';" onblur="if (this.value == '') {this.value = '请输入密码';this.type = 'text';}">
            <table border="0">
                <tr>
                    <td style="margin: auto;vertical-align:middle">
                        <img  id="yanzhengma_pic" style="width:90% ;height: 55%;margin: auto" src="/sof/yanzhengma"/>
                    </td>
                    <td  style="margin: auto;vertical-align:middle;">
                        <input id="code" style="width: 70%;height:55%;margin: 1% 25% 1% 1%" type="text" name="code" value="请输入验证码" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入验证码';}">
                    </td>
                </tr>
            </table>

            <div  style="width: 60%;height:20px;margin: 3% 2% 1% 5%" class="forgot">

                <input  style="width: 100px;height:40px" type="submit" value="登录" >

            </div>
        </form>
    </div>
    <div class="login-bottom">
        <h3>新用户 &nbsp;<a href="sof_register">注册</a></h3>
    </div>
</div>

</body>

</html>