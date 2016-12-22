<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <title>360echarts</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>360关系图明细</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="/Public/echarts.min.js"></script>
    <script src="/Public/dataTool.js"></script>
    <script>

        $(function () {

            function demo(){
            var ajaxTimeoutTest = $.ajax({
                url: 'http://127.0.0.1/Echarts360/longpoll_test',  //请求的URL
                beforeSend :function(xhr){
//                    xhr.setRequestHeader('Request-Id',_request_id);//设置消息头
                },
//                timeout: 1000*30, //超时时间设置，单位毫秒 1000为1秒
                type: 'post',  //请求方式，get或post
//                data: {login_name:_login_name},  //请求所传参数，json格式
                dataType: 'json',//返回的数据格式
                success: function (data, status, xhr) { //请求成功的回调函数
                    pictures(data);
//                    console.log(xhr.getResponseHeader("Request-Id"));
//                    console.log(_request_id);
                    //数据校验部分.
//                    if(xhr.getResponseHeader("Request-Id") == _request_id) {
//                        _ajax_status = 'free';
//                        processData(data);
//                    }else{
//                        alert("请求校验失败!")
//                    }
                },
                complete: function (XMLHttpRequest, status) { //请求完成后最终执行参数
                    if (status == 'timeout') {
                        ajaxTimeoutTest.abort();
                        _ajax_status = 'free';
                        poll_long_test();
//                        alert("请求超时,系统会自动重新求情!");
                    }
                }
//                error: function (data) {
//                    alert("请求发生错误");
//          longPolling();
//                }
            });
            }

            demo();

            function pictures(result){

                var myChart = echarts.init(document.getElementById('main'));
                myChart.showLoading();

                var option = {
                    title: {
                        text: 'Les Miserables',
                        subtext: 'Default layout',
                        top: 'bottom',
                        left: 'right'
                    },
                    tooltip: {},
                    legend: result['legend'],
                    animation: false,
                    series : [
                        {
                            name: 'Les Miserables',
                            type: 'graph',
                            layout: 'force',
                            data:[{"name":"wangqiang"},{"name":"lijianjun"},{"name":"heyi"},{"name":"zhangchen"},{"name":"gaomang"}],
                            links:result['links'],
//                            categories: result['categories'],
                            roam: true,
                            label: {
                                normal: {
                                    position: 'right'
                                }
                            },
                            force: {
                                repulsion: 100
                            }
                        }
                    ]
                };


                myChart.hideLoading();
                myChart.setOption(option);
            }




//        poll_long_test();

        });


    </script>

</head>
<body style="height: 100%;">
<div id="main_1" style="width: 100%;height: 100%"></div>
</body>
</html>