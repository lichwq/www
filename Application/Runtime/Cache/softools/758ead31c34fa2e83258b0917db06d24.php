<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=3c0e5fed39c5e64f6effefa1e1f54e0a"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/Heatmap/2.0/src/Heatmap_min.js"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/data/points-sample-data.js"></script>
    <script src="http://c.cnzz.com/core.php"></script>
    <title>搜索测试页</title>
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
    </style>

    <script type="text/javascript">
        $(function () {
            $("#keywords_search").keyup(function () {
                k = $(this).val();
                if (k == '') {
                    $('#result_div').hide();
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
                                $('#result_div ul').append("<li>暂无此楼盘</li>");
                            }
                        }
                );
            });

            $("#result_div ul").on('click', 'li', function () {
                k = $(this).text();
                $('#keywords_search').val(k);
                $('#result_div').hide();
            })
        });


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

        $(function() {
            scan();
        })

    </script>
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

</head>

<body>


<div  class="">
<input class=""
       id="keywords_search"
       placeholder="请输入需要搜索的楼盘" type="text" style="width: 180px;">
<button type="button" class="btn btn-info" id="isofficeornot_button">办公室
</button>
</div>
<div class="form-control" id="result_div" style="
display: none;
    border: 1px solid #000;
    width: 240px;
    height: 140px;
    overflow-y: scroll;">
    <ul style="
        list-style: none;
    " class="list">
    </ul>
</div>




</body>
</html>