<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <title>3.0版本</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="/Public/echarts.min3.0.js"></script>
    <script src="/Public/dataTool.js"></script>
    <script src="/Public/md5.js"></script>
</head>
<script>
    var _login_name;
    var _ajax_status = 'free';
    $(function() {
        $("#test_button").click(function () {
            if(_ajax_status == 'free'){
                poll_long_test();
            }else{
                alert("服务器忙,不能发送请求");
            }
        });

        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if ( encodeURI(r) != null) return unescape(encodeURI(r[2])); return null;
        }

        _login_name = decodeURI(getQueryString("login_name"));

        var myChart = echarts.init(document.getElementById('main'));
        myChart.showLoading();

    function processData(result){

        var myChart = echarts.init(document.getElementById('main'));

        for(var i=0;i<result['links'].length;i++){

            var s_value = '';
            var m_value = '';

            for(var n=0;n<result['links'][i]['value'].length;n++){
                s_value = result['links'][i]['value'][n];
                m_value = s_value+'</br>'+m_value;
//                result['links'][i].push({ name: 'itemStyle', data: ['fdsfdsfs'] })
                result['links'][i].itemStyle = {normal: {
                    type: 'curve'
                }}
            }
            result['links'][i]['value']=[];
            result['links'][i]['value'][0]=m_value;
        }

        console.log(result['categories']);

        for(var k=0;k<result['nodes'].length;k++){

            result['nodes'][k].symbolSize = 25;

            var k_s_value = '';
            var k_m_value = '';

            for(var j=0;j<result['nodes'][k]['value'].length;j++){
                k_s_value = result['nodes'][k]['value'][j];
                k_m_value = k_s_value+'</br>' + k_m_value
            }
            result['nodes'][k]['value']=[];
            result['nodes'][k]['value'][0]=k_m_value;
        }

        var new_arr = [];
        var king_new_arr = [];

        for(var c=0;c<result['nodes'].length;c++){

            var items=result['nodes'][c]['name'];

            //判断元素是否存在于new_arr中，如果不存在则插入到new_arr的最后

            if($.inArray(items,king_new_arr)==-1) {
                king_new_arr.push(result['nodes'][c]['name']);
                new_arr.push(result['nodes'][c]);
            }

        }

        console.log(new_arr);

        console.log(result['legend']);

        var option = {
            title: {
                text: result['title'],
                top: 'bottom',
                left: 'right'
            },
            tooltip: {
                formatter:'{c}'
            },
            legend: {
                data:result['legend']
            },
//            animation: false,

            series : [
                {
                    name: result['title'],
                    type: 'graph',
                    layout: 'force',
                    categories: result['categories'],
                    focusNodeAdjacency: true,
                    data:new_arr,
                    links:result['links'],
                    draggable :true,
//                    animation: false,
//                    animationDuration: 500,
                    lineStyle: { normal: { curveness: 0.2 }},
                    roam: true,
                    label: {
                        normal: {
                            position: 'right'
                        }
                    },
                    force: {
                        gravity : 0.3,
                        edgeLength : 70,
                        repulsion: 300
//                        layoutAnimation:false
                    }
                }
            ]
        };

        myChart.on('click', function (params) {

//            king_tag = params['seriesName'];

//            $('#king_iframe').attr("src",'http://softools.richest007.com/subscribe/three_lev_people_bos_map?tagname='+king_tag+'&typename='+_levname);
//
//
//            $('#myModal').modal('show');

//                            console.log(params);
            console.log(params['name']);
            var pap = params['name'];
            poll_long_test(pap);

            //调用新的方法

        });


        myChart.hideLoading();
        myChart.setOption(option);
    }

        //实验2:单次长连接.

        function　poll_long_test() {
            _ajax_status = 'busy';
            _timestamp = (new Date()).valueOf();
            _request_id = hex_md5(_timestamp+_login_name);
            var ajaxTimeoutTest = $.ajax({
                url: '/Echarts360/longpoll_test',  //请求的URL
                beforeSend :function(xhr){
                    xhr.setRequestHeader('Request-Id',_request_id);//设置消息头
                },
                timeout: 1000*30, //超时时间设置，单位毫秒 1000为1秒
                type: 'post',  //请求方式，get或post
                data: {login_name:_login_name},  //请求所传参数，json格式
                dataType: 'json',//返回的数据格式
                success: function (data, status, xhr) { //请求成功的回调函数
//                    console.log(xhr.getResponseHeader("Request-Id"));
//                    console.log(_request_id);
                    //数据校验部分.
                    if(xhr.getResponseHeader("Request-Id") == _request_id) {
                        _ajax_status = 'free';
                        processData(data);
                    }else{
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
});




</script>
<body style="height: 100%;width: 100%">

<!--<div id = "test">-->
    <!--<button id = "test_button">测试发送请求</button>-->
<!--</div>-->

<div id="main" style="width: 100%;height: 100%"></div>

<!--<div id="msg"></div>测试开始<input id="btn" type="button" value="测试" />-->

</body>
</html>