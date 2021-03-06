<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <title>360关系图3.0版本</title>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css"  href="http://cdn.datatables.net/plug-ins/28e7751dbec/integration/jqueryui/dataTables.jqueryui.css">
    <script src="/Public/echarts.min3.0.js"></script>
    <script src="/Public/dataTool.js"></script>
    <script src="/Public/md5.js"></script>
</head>
<script>
    var _search_condition;
    var _ajax_status = 'free';
    $(function() {
        $("#test_button").click(function () {
            if(_ajax_status == 'free'){
                ajax_nodes_api();
            }else{
                alert("服务器忙,不能发送请求");
            }
        });

        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if ( encodeURI(r) != null) return unescape(encodeURI(r[2])); return null;
        }

        _search_condition = decodeURI(getQueryString("search_condition"));

        var myChart = echarts.init(document.getElementById('main'));
        myChart.showLoading();

    function processData(result){

        var search_condition = arguments[1] ? arguments[1] : _search_condition;

//        console.log('这是搜索条件:'+search_condition);

        if(result['nodes'].length==0){
            alert("查询不到数据,请重新输入查询条件!");
        }

        var myChart = echarts.init(document.getElementById('main'));

        for(var i=0;i<result['links'].length;i++){

            var s_value = '';
            var m_value = '';

            for(var n=0;n<result['links'][i]['value'].length;n++){
                s_value = result['links'][i]['value'][n];
                m_value = s_value+'</br>'+m_value;
                result['links'][i].itemStyle = {normal: {
                    type: 'curve'
                }}
            }

            result['links'][i]['value']=[];
            result['links'][i]['value'][0]=m_value;
        }

//        console.log(result['categories']);

        for(var k=0;k<result['nodes'].length;k++){

            if(result['nodes'][k]['name']==search_condition){
                result['nodes'][k].symbolSize = 40;
            }else{
            result['nodes'][k].symbolSize = 25;
            }
            var k_s_value = '';
            var k_m_value = '';

            for(var j=0;j<result['nodes'][k]['value'].length;j++){
                k_s_value = result['nodes'][k]['value'][j];
                k_m_value = k_s_value+'</br>' + k_m_value
            }

            result['nodes'][k]['value']=[];
            result['nodes'][k]['value'][0]=k_m_value;
        }

        result['categories'] = [];

        for(var k1=0;k1<result['legend'].length;k1++){

            result['categories'][k1] = {name: result['legend'][k1],symbolSize: 10};

            for(var k2=0;k2<result['nodes'].length;k2++){
                if(result['legend'][k1]==result['nodes'][k2]['name']){
                    result['nodes'][k2]['category']=k1;
                }
            }
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
                    name: "关系图",
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
                    }
                }
            ]
        };

        myChart.on('click', function (params) {

//            console.log(params['name']);
//            console.log(params['data']['category']);
            var nodeName = params['name'];
            var nodeCategory = params['data']['category'];
            ajax_nodes_api(nodeName,nodeCategory);
            //调用新的方法
        });


        myChart.hideLoading();
        myChart.setOption(option);
    }

        //实验2:单次长连接.

        function　ajax_nodes_api(nodeName) {

            var nodeCategory = arguments[1] ? arguments[1] : "PERSON";

            console.log(nodeName);
            console.log(nodeCategory);

            _ajax_status = 'busy';
            _timestamp = (new Date()).valueOf();
            _request_id = hex_md5(_timestamp+_search_condition);

            var this_json = '{"apiName":"test","caller": "core", "timestamp": '+_timestamp+', "token": "hello","payload": {"nodeName": "'+nodeName+'","nodeCategory":"'+nodeCategory+'"}}';

            var ajaxTimeoutTest = $.ajax({
                url: '/Echarts360/zechuan_demo',  //请求的URL
                beforeSend :function(xhr){
                    xhr.setRequestHeader('Request-Id',_request_id);//设置消息头
                    xhr.setRequestHeader('Accept','application/json');
                    xhr.setRequestHeader('Content-Type','application/json');
                    var myChart = echarts.init(document.getElementById('main'));
                    myChart.showLoading();
                },
                timeout: 1000*30, //超时时间设置，单位毫秒 1000为1秒
                type: 'post',  //请求方式，get或post
                data: this_json,  //请求所传参数，json格式
                dataType: 'json',//返回的数据格式
                success: function (data, status, xhr) { //请求成功的回调函数
                    //数据校验部分.
                    if(xhr.getResponseHeader("Request-Id") == _request_id) {
//                        alert("请求校验成功!");
                        _ajax_status = 'free';
                        processData(data,nodeName);
                    }else{
                        alert("请求校验失败!")
                    }
                },
                complete: function (XMLHttpRequest, status) { //请求完成后最终执行参数
                    if (status == 'timeout') {
                        ajaxTimeoutTest.abort();
                        _ajax_status = 'free';
                        ajax_nodes_api();
                    }
                }
            });
        }

        ajax_nodes_api(_search_condition);
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