<?php if (!defined('THINK_PATH')) exit();?></head>
<body>
<div class="login">
    <h2>Acced Form</h2>
    <div class="login-top">
        <h1>LOGIN FORM</h1>
        <form>
            <input type="text" value="User Id" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User Id';}">
            <input type="password" value="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}">
        </form>
        <div class="forgot">
            <a href="#">forgot Password</a>
            <input type="submit" value="Login" >
        </div>
    </div>
    <div class="login-bottom">
        <h3>New User &nbsp;<a href="#">Register</a>&nbsp Here</h3>
    </div>
</div>
<div class="copyright">
    <p>Copyright &copy; 2015.Company name All rights reserved.<a target="_blank" href="http://sc.chinaz.com/moban/">&#x7F51;&#x9875;&#x6A21;&#x677F;</a></p>
</div>


</body>
</html>