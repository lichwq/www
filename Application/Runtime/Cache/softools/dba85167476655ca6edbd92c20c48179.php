<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <title>报表工单上传</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/Public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/Public/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
        }
    </style>

    <script>


        $(function xunhuan() {
            $.get('/Sof/gongdanshangchuan_status', {res: 1, res1: 1}).done(function (points) {
                if ((points[0]['status']==0)&&(points[1]['status']==0)){
                    $("#file").attr("disabled", false);
                    $("#submit").attr("disabled", false);
                }
                else {
                    $("#file").attr("disabled", true);
                    $("#submit").attr("disabled", true);
                }
            });
            setTimeout(xunhuan, 5000);//这里的1000表示1秒有1000毫秒,1分钟有60秒,7表示总共7分钟
        });

        $(function () {

            $("#delete_all").click(function () {

                $.get('/Sof/workorder_count', {is_query: 1, res1: 1}).done(function (points) {
                    var king = '系统中目前有 '+points['count']+' 份报告的数据,您确定要删除全部数据吗?';
                    $("#alert_motai").text(king);
                    $('#myModal').modal('show');
                });


            });

            $("#queren_shanchu").click(function () {
                $.get('/Sof/queren_shanchu', {is_query: 1, res1: 1}).done(function (points) {
                    alert('数据已经被全部清空!');
                });
            });


            $.get('/Sof/gongdanshangchuan_status', {res: 1, res1: 1}).done(function (points) {
                if ((points[2]['status'].indexOf("浙江")>=0)||(points[2]['status'].indexOf("上海")>=0)||(points[2]['status'].indexOf("江苏")>=0)){

                }
                else {
                    alert("上传的excel中project字段不包含地域信息!!!!!!!请等待系统自动恢复待机!!!!");
                }
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
                    <li class="active"><a href="gongdanshangchuan">报告工单上传</a></li>
                    <li><a href="work_order_tools">报告工单监控</a></li>
                    <li><a href="sof_map_tools">报告人群地图</a></li>
                    <li><a href="shiwu_people">项目三级人群</a></li>
                    <li><a href="yichang">项目人群异动分析</a></li>
                    <li><a href="bussiness_assessment_workorder">业务评估系统</a></li>
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

<form action="/Sof/upload_gongdan" method="post" enctype="multipart/form-data">
    <br /><br />
    <table align="center">
    <tr>
        <td><input class="btn btn-default" id="file" name="photo" type="file" value="" /></td>
        <td><input class="btn btn-default" id="submit" type="submit" value="上传" name="" /></td>
        <td>&nbsp&nbsp&nbsp</td>
        <td><button class="btn btn-danger" type="button" id="delete_all">删除目前报告数据</button></td>
    </tr>
    </table>
</form>
<h1 id="test" style="position: absolute;left: 45%;top:45%"></h1>
<div style="width: 80%;margin: 2% 5% 5% 10%">
        <table  class="table table-bordered" id = "case" align="center">
            <thead>
            <tr>
                <th>productor</th>
                <th>project</th>
                <th>product</th>
                <th>isowner</th>
                <th>biaoqian</th>
            </tr>
            </thead>
            <?php if(is_array($rs)): $i = 0; $__LIST__ = $rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tbody>
                <tr>
                    <td><?php echo ($vo["productor"]); ?></td>
                    <td><?php echo ($vo["project"]); ?></td>
                    <td><?php echo ($vo["product"]); ?></td>
                    <td><?php echo ($vo["isowner"]); ?></td>
                    <td><?php echo ($vo["biaoqian"]); ?></td>
                </tr>
                </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
</div>

<div style="margin: 10%" class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">删除报告数据</h4>
            </div>
            <form role="form" novalidate="" class="ng-pristine ng-invalid ng-invalid-required">
                <div id="alert_motai" align="center" style="font-size: x-large;color: red" class="modal-body"></div>
                <div class="modal-footer">
                    <button id="queren_shanchu" type="button" class="btn btn-default"  data-dismiss="modal">确定</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>