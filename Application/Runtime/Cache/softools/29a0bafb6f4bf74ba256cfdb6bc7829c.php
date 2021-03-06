<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <title>长连接测试</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
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
//            console.log(result['links']);
        }

        for(var k=0;k<result['nodes'].length;k++){

            var k_s_value = '';
            var k_m_value = '';

            for(var j=0;j<result['nodes'][k]['value'].length;j++){
                k_s_value = result['nodes'][k]['value'][j];
                k_m_value = k_s_value+'</br>' + k_m_value
            }
            result['nodes'][k]['value']=[];
            result['nodes'][k]['value'][0]=k_m_value;
        }

        console.log(result['categories']);

        var option = {
            title : {
                text: result['title'],
                x:'left',
                y: 30
            },
//                tooltip : {
//                },
            tooltip : {
//                    trigger: 'item',
                formatter: '{c}'
            },
            toolbox: {
                show : true,
                feature : {
                    restore : {show: true},
                    magicType: {show: true, type: ['force', 'chord']},
                    saveAsImage : {show: true}
                }
            },
            legend: {
                x: 'left',
                data: result['legend']
            },
            series : [
                {
                    type:'force',
//                    name : "",
                    ribbonType: false,
                    categories: result['categories'],
                    roam: true,
                    itemStyle: {
                        normal: {
                            label: {
                                show: false,
                                textStyle: {
                                    color: '#333'
                                }
                            },
                            nodeStyle : {
//                                    brushType : 'both',
//                                    borderColor : 'rgba(255,215,0,0.4)',
//                                    borderWidth : 1
                            }
//                                linkStyle: {
//                                    type: 'curve'
//                                }
                        },
                        emphasis: {
                            label: {
                                show: false
                                // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                            },
                            nodeStyle : {
                                //r: 30
                            },
                            linkStyle : {}
                        }
                    },
                    useWorker: false,
                    minRadius : 15,
                    maxRadius : 25,
                    gravity: 1.0,
                    scaling: 1.5,
//                    linkSymbol: ['arrow'],

//                        roam: 'move',
                    nodes:result['nodes'],
                    links:result['links']
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