<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>上富楼盘数据异常状态处理系统</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/Public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/Public/dataTables.jqueryui.js"></script>
    <script src="/Public/echarts.min.js"></script>

    <style>
        .text {
            width: 240px;
            height: 30px;
            position: relative;
            margin: 20px 0 0 20px;
        }
        .text .clean {
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
            display: none;
        }
        .text input {
            width: 240px;
            height: 30px;
        }
    </style>

    <style>
        .list {
            padding: 0;
        }

        .list li {
            line-height: 24px;
            text-indent: 1em;
        }

        .list li:nth-child(2n+1) {
            background-color: #eee;
        }

        #result_div_right ul li:nth-child(1) {
            color: red;
        }

    </style>


    <script type="text/javascript">
        $(function () {
            $("#keywords_search").keyup(function () {
                k = $(this).val();
                if (k == '') {
//                    $('#result_div').hide();
                    return;
                }
                $.get('/Sof/search_keywords_ajax', {res: k}).done(function (shuju) {
                            $('#result_div').show();
                            $('#result_div ul').empty();
                            if (!!shuju && shuju.length > 0) {
                                var li = $('<li>');
                                shuju.forEach(function (r) {
                                    var tmp = li.clone();
                                    tmp.val(r.keywords).text(r.keywords);
                                    $('#result_div ul').append(tmp);
                                })
                            } else {
                                $('#result_div ul').append("<li>对不起,没有搜到楼盘</li>");
                            }
                        }
                );
            });

            var li_right = $('<li>');

            function creatInput() {
                var template = $('<div class="text">' +
                        '<input tyle="text" />' +
                        '<div class="clean">X</div>' +
                        '</div>');
                template.find('input').on('keyup', function() {
                    if( template.find('input').val() == '' ) template.find('.clean').hide();
                    template.find('.clean').show();
                });
                template.find('.clean').on('click', function() {
                    template.find('input').val('');
                    $(this).hide();
                });
                return template;
            }

            function scan() {
                $('[xinput]').each(function() {
                    $(this).append( new creatInput() );
                })
            }
            scan();


//            点击左侧框,将li的text写入右侧框并且写入输入框
            $("#result_div ul").on('click', 'li', function () {
               var k = $(this).text();
                $('#keywords_search').val(k);

            var king2 =  right_div_single(k);
                if(king2=='chongfu'){
                    alert("您点击了已经存在于最终清单的楼盘");
                    return;
                }

                var tmp_right = li_right.clone();
                tmp_right.val(k).text(k);
                $('#result_div_right ul').append(tmp_right);
//                console.log(right_div_single(k));
//                console.log(k);
                right_div_bianli();
            });

            var li_right_2 = $('<li>');

//            点击中间框将li的text加入右侧框
            $("#result_div_middle ul").on('click', 'li', function () {
                var k = $(this).text();
                var king2 =  right_div_single(k);
                if(king2=='chongfu'){
                    alert("您点击了已经存在于最终清单的楼盘");
                    return;
                }
                var tmp_right = li_right_2.clone();
                tmp_right.val(k).text(k);
                $('#result_div_right ul').append(tmp_right);
                right_div_bianli();
            });

//            点击右侧框去除li的text
            $("#result_div_right ul").on('click', 'li', function () {
                $(this).remove();
                right_div_bianli();
            });

//            计算右侧框li的个数
            function right_div_bianli(){
                var n=0;
                $('#result_div_right ul li').each(function(){
                    n=n+1;
//                    console.log($(this).text());
                });
                $("#delete_all_right").text("清空已选择清单,已有"+n+"个")
            }


//            遍历右侧框,看看和传进来的值是否相同
         function right_div_single(canshu)
            {
                var n=0;

                var shuzu =  [];

                $('#result_div_right ul li').each(function(){
                    shuzu[n] = $(this).text();
                    n = n+1;
                });

                var right_list = $('#result_div_right ul li');

                for (var i = 0;i <= right_list['length']; i++) {
                    if(shuzu[i]==canshu){
                        return 'chongfu';
                    }
                }
            }

            $("#delete_all_right").click(function () {
                $("#result_div_right ul").empty();
                right_div_bianli();
            });

            $("#jingpin_list").click(function () {
                var keywords = $('#keywords_search').val();
                $.get('/Sof/some_keywords_jingpin', {keywords: keywords}).done(function (shuju) {
                            $('#result_div_middle').show();
                            $('#result_div_middle ul').empty();
                            if (!!shuju && shuju.length > 0) {
                                var li = $('<li>');
                                shuju.forEach(function (r) {
                                    var tmp = li.clone();
                                    tmp.val(r.keywords).text(r.keywords);
                                    $('#result_div_middle ul').append(tmp);
                                })
                            } else {
                                $('#result_div_middle ul').append("<li>这个楼盘没有系统推荐竞品</li>");
                            }
                        }
                );
            });


            $("#tijiao_list").click(function () {
                var n=0;

                total_shuzu =  [];
                pzbs='';

                $('#result_div_right ul li').each(function(){
                    total_shuzu[n] = $(this).text();
                    pzbs = pzbs+','+'\''+$(this).text()+'\'';
                    n = n+1;
                });
                total_kess = total_shuzu[0];

//                $.get('/Sof/xq_circle_map_tools_dashboard_port', {keywords: pzbs,benan: total_kess}).done(function () {
//
//                });
            });

        })

    </script>




<body>


<div id="step1">
    <div style="margin-top: 3%;margin-left: 12%" class="">
        <div class="input-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-search">
                </span>
            </span>
            <input style="width: 22%;" type="text" id="keywords_search" class="form-control" placeholder="请输入要搜索的楼盘名称">
            <button id="jingpin_list" style="margin-left: 14%" class="btn btn-default">查看系统推荐竞品</button>
            <div id="delete_all_right" style="margin-left: 20%" class="btn btn-danger">清空已选择清单,已有0个</div>
        </div>


        <!--<input class=""-->
               <!--id="keywords_search"-->
               <!--placeholder="请输入需要搜索的楼盘" type="text" style="width: 180px;">-->
        <!--<button type="button" class="btn btn-primary btn-sm" id="isofficeornot_button">生成-->
        <!--</button>-->
    </div>
    <div  class="form-control" id="result_div" style="
    display: inline-block;
    border: 1px solid #000;
    width: 22%;
    height: 500px;
    margin-left: 12%;
    margin-top: 1%;
    overflow-y: scroll;">
        <ul style="
        list-style: none;
    " class="list">
        </ul>
    </div>


    <div class="form-control" id="result_div_middle" style="
    display: inline-block;
    border: 1px solid #000;
    width: 22%;
    height: 500px;
    margin-left: 5%;
    margin-top: 1%;
    overflow-y: scroll;">
        <ul style="
        list-style: none;
    " class="list">
        </ul>
    </div>

    <div  class="form-control" id="result_div_right" style="
    display: inline-block;
    border: 1px solid #000;
    width: 22%;
    height: 500px;
    margin-left: 5%;
    margin-top: 1%;
    overflow-y: scroll;">
        <ul id="result_div_right_ul" style="
        list-style: none;
    " class="list">
        </ul>
    </div>


<div id="tijiao_list" style="width: 19%;margin-left: 68%;margin-top: 1%" class="btn btn-primary">提交</div>

</div>


    </body>



</html>