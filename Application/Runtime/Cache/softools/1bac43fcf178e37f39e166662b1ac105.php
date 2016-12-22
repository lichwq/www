<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>结案报告</title>
    <script src="/Public/echarts.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="/Public/jquery-ui.css">
    <script src="/Public/jquery-1.12.0.js"></script>
    <script src="/Public/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"  href="/Public/dataTables.jqueryui.css">
    <script type="text/javascript" language="javascript" src="/public/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/public/dataTables.jqueryui.js"></script>
    <script type="text/javascript" charset="utf-8"></script>

    <style>
        body {
            margin: 0px;
            padding: 0px;
            font-family: "微软雅黑";
        }
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

    <script>

        $(function () {

            $("#li_1").click(function () {
                var king = $('#keywords_search').val();

                if(!$('#keywords_search').val()) {
                    alert("请输入楼盘名称");
                }else {
                    $.get('/Sof/click_data_port', {keywords: king}).done(function (result) {

                        var myChart = echarts.init(document.getElementById('tabs-1'));
                        myChart.showLoading();

                        var option = {
                            title: {
                                text: '点击人群流量类型分布'
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['tagname'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result

                            }

                        };
                        myChart.hideLoading();
                        myChart.setOption(option);

                    });
                }
            });


                $("#li_2").click(function () {
                    var king = $('#keywords_search').val();
                    if(!$('#keywords_search').val()) {
                        alert("请输入楼盘名称");
                    }else {
                        $.get('/Sof/click_data_port2', {keywords: king}).done(function (result) {
                            var myChart2 = echarts.init(document.getElementById('tabs-2'));
                            myChart2.showLoading();

                            var option2 = {
                                title: {
                                    text: '点击人群区域分布'
//                  x:'center'
                                },
                                tooltip: {
                                    trigger: 'item',
                                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                                },
                                legend: {
                                    left: '20%',
                                    right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                    data: result['tagname'],
                                    containLabel: true
                                },
                                toolbox: {
                                    show: true,
                                    feature: {
                                        mark: {show: true},
                                        dataView: {show: true, readOnly: false},
                                        magicType: {
                                            show: true,
                                            type: ['pie', 'funnel']
                                        },
                                        restore: {show: true},
                                        saveAsImage: {show: true}
                                    }
                                },
                                calculable: true,
                                series: {
                                    name: '半径模式',
                                    type: 'pie',
                                    label: {
                                        normal: {
                                            show: true,
                                            formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                        }

                                    },
                                    lableLine: {
                                        normal: {
                                            show: false
                                        },
                                        normal: {
                                            show: true
                                        }
                                    },
                                    data: result

                                }

                            };
                            myChart2.hideLoading();
                            myChart2.setOption(option2);
                        });
                    }
                });




            $("#li_3").click(function () {
                var king = $('#keywords_search').val();
                if(!$('#keywords_search').val()) {
                    alert("请输入楼盘名称");
                }else {
                    $.get('/Sof/click_data_port3', {keywords: king}).done(function (result) {
                        $("#3_1").empty();
                        $("#3_2").empty();
                        $("#3_3").empty();
                        $("#3_4").empty();
                        $("#3_5").empty();
//
//                    $("#3_1").attr('style','height: 550px');
//                    $("#3_2").attr('style','height: 550px');

                        var myChart3 = echarts.init(document.getElementById('3_1'));
                        myChart3.showLoading();

                        var option3 = {
                            title: {
                                text: result[0][0]['policyname']
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['0'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[0]

                            }

                        };
                                myChart3.hideLoading();
                        myChart3.setOption(option3);


                        var myChart3_2 = echarts.init(document.getElementById('3_2'));
                        myChart3_2.showLoading();

                        var option3_2 = {
                            title: {
                                text: result[1][0]['policyname']
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['1'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[1]

                            }

                        };
                        myChart3_2.hideLoading();
                        myChart3_2.setOption(option3_2);


                        var myChart3_3 = echarts.init(document.getElementById('3_3'));
                        myChart3_3.showLoading();

                        var option3_3 = {
                            title: {
                                text: result[2][0]['policyname']
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['2'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[2]

                            }

                        };
                        myChart3_3.hideLoading();
                        myChart3_3.setOption(option3_3);


                        var myChart3_4 = echarts.init(document.getElementById('3_4'));
                        myChart3_4.showLoading();

                        var option3_4 = {
                            title: {
                                text: result[3][0]['policyname']
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['3'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[3]

                            }

                        };
                        myChart3_4.hideLoading();
                        myChart3_4.setOption(option3_4);


                        var myChart3_5 = echarts.init(document.getElementById('3_5'));
                        myChart3_5.showLoading();

                        var option3_5 = {
                            title: {
                                text: result[4][0]['policyname']
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['4'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[4]

                            }

                        };
                        myChart3_5.hideLoading();
                        myChart3_5.setOption(option3_5);


                        console.log(result[3].length);

//                    if(length(result[0][0]['policyname'])==0){
//                        $("#3_1").empty();
//                    }
//                    if(length(result[1][0]['policyname'])==0){
//                        $("#3_2").empty();
//                    }
//                    if(length(result[2][0]['policyname'])==0){
//                        $("#3_3").empty();
//                    }
//                    if(length(result[3][0]['policyname'])==0){
//                        $("#3_4").empty();
//                    }
//                    if(length(result[4][0]['policyname'])==0){
//                        $("#3_5").empty();
//                    }

                    });
                }
            });








            $("#li_4").click(function () {
                var king = $('#keywords_search').val();
                if(!$('#keywords_search').val()) {
                    alert("请输入楼盘名称");
                }else {
                    $.get('/Sof/click_data_port4', {keywords: king}).done(function (result) {
                        var myChart4 = echarts.init(document.getElementById('td1'));
                        myChart4.showLoading();

                        var option4 = {
                            title: {
                                text: '客户性别分布'
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['tagname'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[1]

                            }

                        };
                        myChart4.hideLoading();
                        myChart4.setOption(option4);


                        var myChart4_1 = echarts.init(document.getElementById('td2'));
                        myChart4_1.showLoading();

                        var option4_1 = {
                            title: {
                                text: '客户年龄分布'
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['tagname'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result[2]

                            }

                        };
                        myChart4_1.hideLoading();
                        myChart4_1.setOption(option4_1);

                    });
                }
            });



            $("#li_5").click(function () {
                var king = $('#keywords_search').val();
                if(!$('#keywords_search').val()) {
                    alert("请输入楼盘名称");
                }else {
                    $.get('/Sof/click_data_port5', {keywords: king}).done(function (result) {
                        var myChart5 = echarts.init(document.getElementById('tabs-5'));
                        myChart5.showLoading();

                        var option5 = {
                            title: {
                                text: '点击人群区域分布'
//                  x:'center'
                            },
                            tooltip: {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                left: '20%',
                                right: '4%',
//                  x : 'center',
//                  y : 'bottom',
                                data: result['tagname'],
                                containLabel: true
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            calculable: true,
                            series: {
                                name: '半径模式',
                                type: 'pie',
                                label: {
                                    normal: {
                                        show: true,
                                        formatter: '{b}:{d}' + '%'
//                          position : 'inside'
                                    }

                                },
                                lableLine: {
                                    normal: {
                                        show: false
                                    },
                                    normal: {
                                        show: true
                                    }
                                },
                                data: result

                            }

                        };
                        myChart5.hideLoading();
                        myChart5.setOption(option5);
                    });
                }
            });


            $("#li_6").click(function () {

                var king = $('#keywords_search').val();
                if(!$('#keywords_search').val()) {
                    alert("请输入楼盘名称");
                }else {
                $.get('/Sof/click_data_port6', {keywords: king}).done(function (c) {
                    $('#table_id3').DataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        data: c,
                        columns: [
                            {data: 'rank'},
                            {data: 'projectname'},
                            {data: 'details'},
                            {data: 'hot'},
                            {data: 'c_x'},
                            {data: 'c_y'}
                        ]
                    });

                    $('#table_id3').DataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        "createdRow": function ( row, data, index ) {
                            if ( data[2]=='all_done' ) {
                                $('td', row).eq(2).css('font-weight',"bold").css("color","red");
                                $('td', row).eq(1).css('font-weight',"bold").css("color","red");
                            }
                        },
                        "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                        language: {
                            "sProcessing": "处理中...",
                            "sLengthMenu": "显示 _MENU_ 项结果",
                            "sZeroRecords": "没有匹配结果",
                            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                            "sInfoPostFix": "",
                            "sSearch": "搜索:",
                            "sUrl": "",
                            "sEmptyTable": "表中数据为空",
                            "sLoadingRecords": "载入中...",
                            "sInfoThousands": ",",
                            "oPaginate": {
                                "sFirst": "首页",
                                "sPrevious": "上页",
                                "sNext": "下页",
                                "sLast": "末页"
                            },
                            "oAria": {
                                "sSortAscending": ": 以升序排列此列",
                                "sSortDescending": ": 以降序排列此列"
                            }
                        }
                    });
                });
                }
            });


            $("#tabs").tabs();
                $.get('/Sof/click_data_port6', {res: 1}).done(function (c) {
                    $('#table_id3').DataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        data: c,
                        columns: [
                            {data: 'rank'},
                            {data: 'projectname'},
                            {data: 'details'},
                            {data: 'hot'},
                            {data: 'c_x'},
                            {data: 'c_y'}
                        ]
                    });

                    $('#table_id3').DataTable({
                        "bProcessing": true,
                        "bSortClasses": true,
                        "bStateSave": true, //保存状态到cookie
                        "bJQueryUI": true,
                        bDestroy: true,
                        "createdRow": function ( row, data, index ) {
                            if ( data[2]=='all_done' ) {
                                $('td', row).eq(2).css('font-weight',"bold").css("color","red");
                                $('td', row).eq(1).css('font-weight',"bold").css("color","red");
                            }
                        },
                        "lengthMenu": [[30, 40, -1], [30, 40, "All"]],
                        language: {
                            "sProcessing": "处理中...",
                            "sLengthMenu": "显示 _MENU_ 项结果",
                            "sZeroRecords": "没有匹配结果",
                            "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                            "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                            "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                            "sInfoPostFix": "",
                            "sSearch": "搜索:",
                            "sUrl": "",
                            "sEmptyTable": "表中数据为空",
                            "sLoadingRecords": "载入中...",
                            "sInfoThousands": ",",
                            "oPaginate": {
                                "sFirst": "首页",
                                "sPrevious": "上页",
                                "sNext": "下页",
                                "sLast": "末页"
                            },
                            "oAria": {
                                "sSortAscending": ": 以升序排列此列",
                                "sSortDescending": ": 以降序排列此列"
                            }
                        }
                    });
                });

        });


    </script>



    <script>
        $(function () {

            $("#keywords_search").keyup(function () {
                k1 = $(this).val();
                if (k1 == '') {
                    $('#result_div').hide();
                    return;
                }
                $.get('/Sof/search_hangzhou_keywords', {res: k1}).done(function (shuju) {
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
                k1 = $(this).text();
                $('#keywords_search').val(k1);
                $('#result_div').hide();
            });

        });

    </script>


    <script>
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
                    <li><a href="gongdanshangchuan">报告工单上传</a></li>
                    <li><a href="work_order_tools">报告工单监控</a></li>
                    <li><a href="sof_map_tools">报告人群地图</a></li>
                    <li><a href="shiwu_people">项目三级人群</a></li>
                    <li><a href="yichang">项目人群异动分析</a></li>
                    <li><a href="bussiness_assessment_workorder">业务评估系统</a></li>
                    <li class="active"><a href="click_tools">结案报告</a></li>
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
            <li><a href="sof_login"> 退出登录</a>
            </li>
        </ul>
    </div>
</nav>

<div align="center" >

    <div style="margin-top: 1%" class="">
        <input name="shurukuang" class=""
               id="keywords_search"
               placeholder="请输入需要搜索的楼盘" type="text" style="width: 180px;">
        <!--<button type="button" class="btn btn-primary btn-sm" id="isofficeornot_button">开始</button>-->
    </div>
    <div  class="form-control" id="result_div" style="margin-left: -2%;
display: none;
    border: 1px solid #000;
    width: 200px;
    height: 140px;
    overflow-y: scroll;">
        <ul style="
        list-style: none;
    " class="list">
        </ul>
    </div>

</div>

<div id="tabs">
    <ul>
        <li id="li_1"><a href="#tabs-1">点击人群流量类型分布</a></li>
        <li id="li_2"><a href="#tabs-2">点击人群区域分布</a></li>
        <li id="li_3"><a href="#tabs-3">流量类型区域分布</a></li>
        <li id="li_4"><a href="#tabs-4">点击人群属性分布</a></li>
        <li id="li_5"><a href="#tabs-5">点击人群兴趣分布</a></li>
        <li id="li_6"><a href="#tabs-6">点击人群热区排名</a></li>
    </ul>
    <div id="tabs-1" style="height: 500px">
    </div>
    <div id="tabs-2"  style="height: 500px">
        <!--<table id="table_id2"  class="display">-->
            <!--<thead>-->
            <!--<tr>-->
                <!--<th>日期</th>-->
                <!--<th>项目</th>-->
                <!--<th>完成度</th>-->
            <!--</tr>-->
            <!--</thead>-->
            <!--<tbody>-->
            <!--<tr>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
            <!--</tr>-->
            <!--</tbody>-->
        <!--</table>-->
    </div>
        <div id="tabs-3"  style="height: 550px">
        <div id="3_1" style="height: 550px"></div>
        <div id="3_2"  style="height: 550px"></div>
        <div id="3_3"  style="height: 550px"></div>
        <div id="3_4"  style="height: 550px"></div>
        <div id="3_5"  style="height: 550px"></div>
        <div id="3_6"  style="height: 550px"></div>
    </div>
    <div id="tabs-4"  style="height: 500px">
        <table>
            <tr>
                <td style="width: auto"><div  id="td1" style="width:650px;height: 500px"></div></td>
                <td style="width: auto"><div  id="td2" style="width:650px;height: 500px"></div></td>
            </tr>
        </table>
    </div>
    <div id="tabs-5"  style="height: 600px">
    </div>
    <div id="tabs-6">
        <table id="table_id3" class="display">
            <thead>
            <tr>
                <th>rank</th>
                <th>projectname</th>
                <th>details</th>
                <th>hot</th>
                <th>c_x</th>
                <th>c_y</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>


</html>