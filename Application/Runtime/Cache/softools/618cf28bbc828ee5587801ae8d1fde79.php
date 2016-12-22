<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>java测试</title>
    <script>

        $(function() {

            function poll_long_test() {
                _ajax_status = 'busy';
                _timestamp = (new Date()).valueOf();
                _request_id = hex_md5(_timestamp + _search_condition);
                var ajaxTimeoutTest = $.ajax({
                    url: '/Sof/zechuan_demo',  //请求的URL
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Request-Id', _request_id);//设置消息头
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                    },
                    timeout: 1000 * 30, //超时时间设置，单位毫秒 1000为1秒
                    type: 'post',  //请求方式，get或post
                    data: {
                        "apiName": "test", "caller": "core", "timestamp": _timestamp, "token": "hello",
                        "payload": {
                            "acc": _search_condition
                        }
                    },  //请求所传参数，json格式
                    dataType: 'json',//返回的数据格式
                    success: function (data, status, xhr) { //请求成功的回调函数
//                    console.log(xhr.getResponseHeader("Request-Id"));
//                    console.log(_request_id);
                        //数据校验部分.
                        if (xhr.getResponseHeader("Request-Id") == _request_id) {
//                        alert("请求校验成功!");
                            _ajax_status = 'free';
                            processData(data);
                        } else {
                            alert("请求校验失败!")
                        }
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

            poll_long_test();

        }
            );

    </script>
</head>
<body>
<h1>你好,世界!!!</h1>

</body>
</html>