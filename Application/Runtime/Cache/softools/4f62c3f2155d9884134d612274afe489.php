<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <script src="//code.jquery.com/jquery-1.12.0.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/0.4.0/style/weui.css">
    <title>兑换记录</title>
</head>
<body>
<div class="weui_cells_title">您的兑换记录</div>
<div class="weui_cells">

    <?php if(is_array($rs)): $i = 0; $__LIST__ = $rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="weui_cell">

        <div class="weui_cell_bd weui_cell_primary">
            <p><?php echo ($vo["giftname"]); ?><br></p>
        </div>
        <div class="weui_cell_ft">
            <?php echo ($vo["createdat"]); ?><br>
        </div>

    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

</body>
</html>