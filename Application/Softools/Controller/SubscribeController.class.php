<?php
namespace Softools\Controller;

use Think\Controller;
ignore_user_abort();
set_time_limit(0);

class SubscribeController extends Controller
{
    public function type_total_day_port()
    {

        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");

        $key = $_GET['keywords'];
        $result = $User->query("select * from new_subscribe.dw_basic_typename_converge_day where typename='$key'");
        $this->ajaxReturn($result);
    }

    public function top5_tag_day_port()
    {
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");

        $key = $_GET['keywords'];
        $result = $User->query("select tagname from new_subscribe.dw_basic_tagname_converge_day where typename='$key' group by tagname order by  sum(total_view_count) desc limit 5;");
        $i = 0;
        $result_area = [];
        $result_data = [];

        foreach ($result as $value) {
            $result_data['top5'][$i] = $value['tagname'];
            $tagname_key = $value['tagname'];
            $result_area[$i] = $User->query("select date,tagname,sum(total_view_count) as 'total_view_count'
            from new_subscribe.dw_basic_tagname_converge_day where typename='$key' and tagname='$tagname_key'
            group by date,tagname;");
            $i = $i + 1;
        }

        for ($i = 0; $i < count($result_area); $i++) {
            $str = $result_area[$i];
            for ($n = 0; $n < count($str); $n++) {
                $result_data['pic'][$i]['date'][$n] = $str[$n]['date'];
                $result_data['pic'][$i]['tagname'][$n] = $str[$n]['tagname'];
                $result_data['pic'][$i]['total_view_count'][$n] = $str[$n]['total_view_count'];
            }
        }
        $this->ajaxReturn($result_data);
    }

    public function wy_day_port()
    {
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $key = $_GET['keywords'];
        $type = $_GET['type'];
        $result_king = $User->query("select tagname as name,date,sum(total_view_count) value from  (select date,case when tagname like '%住宅%' then '住宅'
 when tagname like '%别墅%' then '别墅'
 when tagname like '%商住%' then '商住'
 when tagname like '%写字楼%' then '写字楼'
when tagname like '%商铺%' then '商铺' end as tagname,total_view_count
 from new_subscribe.dw_basic_tagname_converge_day where indname='房产-新房' and typename='上海楼盘'
) a group by tagname,date order by date ASC,value desc;");

        $result_data = [];

        for ($n = 0; $n < count($result_king); $n++) {
            $result_data['date'][$n] = $result_king[$n]['date'];
            $result_data['tagname'][$n] = $result_king[$n]['name'];
        }

        $result['date'] = array_values(array_unique($result_data['date']));
        $result['tagname'] = array_values(array_unique($result_data['tagname']));

        $str = [];

        for ($j1 = 0; $j1 < count($result['tagname']); $j1++) {
            for ($j = 0; $j < count($result_king); $j++) {
                $str[$j1]['name'] = $result['tagname'][$j1];
                $str[$j1]['type'] = $type;
                if ($result_king[$j]['name'] == $result['tagname'][$j1]) {
                    $str[$j1]['data'][$j] = $result_king[$j];
                };
            }
        }

        for ($j1 = 0; $j1 < count($str); $j1++) {
            $str[$j1]['data'] = array_values($str[$j1]['data']);
        }

        $result['data'] = $str;


        $this->ajaxReturn($result);
    }

    public function thecase_rel_top10_port()
    {
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $key = $_GET['keywords'];
        $type = $_GET['type'];
        $tiaojian_tmp = $User->query("select concat('(',GROUP_CONCAT('\'',name,'\''),')') as 'tiaojian' from dmp_server.subscribe_orders_content where id=$key and type='jingp';");

        $tiaojian = $tiaojian_tmp[0]['tiaojian'];

        $result_king = $User->query("select date,'竞品均值' as name,cast(avg(total_view_count) as signed) as value from dw_basic_tagname_converge_day where tagname in $tiaojian
        and tagname<>'$key'
        group by date union all
        select date,tagname,total_view_count from dw_basic_tagname_converge_day where tagname in $tiaojian");

//        print_r($result);

        $result['date'] = array_values(array_unique(array_column($result_king, 'date')));
        $result['tagname'] = array_values(array_unique(array_column($result_king, 'name')));

        $str = [];

        for ($j1 = 0; $j1 < count($result['tagname']); $j1++) {
            for ($j = 0; $j < count($result_king); $j++) {
                $str[$j1]['name'] = $result['tagname'][$j1];
                $str[$j1]['type'] = $type;
                if ($result_king[$j]['name'] == $result['tagname'][$j1]) {
                    $str[$j1]['data'][$j] = $result_king[$j];
                };
            }
        }

        for ($j1 = 0; $j1 < count($str); $j1++) {
            $str[$j1]['data'] = array_values($str[$j1]['data']);
        }

        $result['data'] = $str;

        $this->ajaxReturn($result);
    }

    public function three_lev_people_port()
    {
        $user = M('login_user_test');
        $key = $_GET['keywords'];
        $type = $_GET['type'];

        $result_king = $user->query("select a.date,a.dick as name,'了解' as name1,a.know_userid_count as value1,
        '分析' as name2,
        a.analysis_userid_count as value2,
        '决定' as name3,
        a.self_userid_count as value3,
        '成交' as name4,a.trade_count as value4,
        '加权平均值' as name5,
        a.avg as value5,'人群质量' as name6,a.avg*100/a.know_userid_count as value6
        from report_display_shanghai.st_soc_people_event_analysis_total a where dick='$key';
        ");

        $result['date'] = array_values(array_unique(array_column($result_king, 'date')));
        $result['tagname'][] = array_unique(array_column($result_king, 'name1'))[0];
        $result['tagname'][] = array_unique(array_column($result_king, 'name2'))[0];
        $result['tagname'][] = array_unique(array_column($result_king, 'name3'))[0];
        $result['tagname'][] = array_unique(array_column($result_king, 'name4'))[0];
        $result['tagname'][] = array_unique(array_column($result_king, 'name5'))[0];
        $result['tagname'][] = array_unique(array_column($result_king, 'name6'))[0];
        $result['total_name'] = $result_king[0]['name'];

        $str = [];

        for ($m = 0; $m < count($result['tagname']); $m++) {
            $str[$m]['name'] = $result['tagname'][$m];
            $str[$m]['type'] = $type;
            for ($n = 0; $n < count($result_king); $n++) {
                if ($result_king[$n]['name1'] == $result['tagname'][$m]) {
                    $str[$m]['data'][] = $result_king[$n]['value1'];
                }
            }
            for ($n = 0; $n < count($result_king); $n++) {
                if ($result_king[$n]['name2'] == $result['tagname'][$m]) {
                    $str[$m]['data'][] = $result_king[$n]['value2'];
                }
            }
            for ($n = 0; $n < count($result_king); $n++) {
                if ($result_king[$n]['name3'] == $result['tagname'][$m]) {
                    $str[$m]['data'][] = $result_king[$n]['value3'];
                }
            }
            for ($n = 0; $n < count($result_king); $n++) {
                if ($result_king[$n]['name4'] == $result['tagname'][$m]) {
                    $str[$m]['data'][] = $result_king[$n]['value4'];
                }
            }
            for ($n = 0; $n < count($result_king); $n++) {
                if ($result_king[$n]['name5'] == $result['tagname'][$m]) {
                    $str[$m]['data'][] = $result_king[$n]['value5'];
                }
            }
            for ($n = 0; $n < count($result_king); $n++) {
                if ($result_king[$n]['name6'] == $result['tagname'][$m]) {
                    $str[$m]['data'][] = $result_king[$n]['value6'];
                }
            }
        }

        $result['data'] = $str;

        $max = array_search(max(($result['data'][3]['data'])), ($result['data'][3]['data']));

        $max_num = $result['data'][3]['data'][$max] + 8;

        $result['max'] = $max_num;

        $this->ajaxReturn($result);

    }

    public function three_lev_people_bos_port()
    {
        $pwd = 'gdas.developer';

        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $key = $_GET['keywords'];
        $type = $_GET['type'];

        $levname = $_GET['levname'];

        $typename = $_GET['typename'];


        $old_data = M('login_user_test');

        $old_data->execute("call report_display_shanghai.soc_people_event_analysis_temp_wanghui('$key')");

        $max_date_sql = $User->query("select max(date) as date from new_subscribe.dw_basic_typename_converge_day");

        $max_date = $max_date_sql[0]['date'];

        if ($typename == '总价') {
            $result_king = $User->query("select a.*,b.pre_x from (
        select a.tagname,ifnull(cast((value_a-value_b)*100/value_b as decimal(10,2)),0) as 'pre_y',ifnull(value_a/king,1) as value_a from (SELECT tagname,sum(view_count) value_a,count(distinct userid) king from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_totalprice_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) a
        left join
        (SELECT tagname,sum(view_count) value_b from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_totalprice_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -60 day) and b.date<DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) b
        on a.tagname=b.tagname) a
        INNER JOIN
        (
        select a.tagname,ifnull(cast(value_a*100/value_b as decimal(10,2)),0)  as 'pre_x' from
        (SELECT tagname,sum(view_count) value_a from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_totalprice_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename'
        ) k1 group by tagname) a
        left JOIN
        (select sum(view_count) value_b from (
        select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_totalprice_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename') a) b on 1=1
        ) b on a.tagname=b.tagname;");
        } elseif ($typename == '面积') {
            $result_king = $User->query("select a.*,b.pre_x from (
        select a.tagname,ifnull(cast((value_a-value_b)*100/value_b as decimal(10,2)),0) as 'pre_y',ifnull(value_a/king,1) as value_a from (SELECT tagname,sum(view_count) value_a,count(distinct userid) king from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_square_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) a
        left join
        (SELECT tagname,sum(view_count) value_b from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_square_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -60 day) and b.date<DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) b
        on a.tagname=b.tagname) a
        INNER JOIN
        (
        select a.tagname,ifnull(cast(value_a*100/value_b as decimal(10,2)),0)  as 'pre_x' from
        (SELECT tagname,sum(view_count) value_a from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_square_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename'
        ) k1 group by tagname) a
        left JOIN
        (select sum(view_count) value_b from (
        select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_square_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename') a) b on 1=1
        ) b on a.tagname=b.tagname;");
        } elseif ($typename == '户型') {
            $result_king = $User->query("select a.*,b.pre_x from (
        select a.tagname,ifnull(cast((value_a-value_b)*100/value_b as decimal(10,2)),0) as 'pre_y',ifnull(value_a/king,1) as value_a from (SELECT tagname,sum(view_count) value_a,count(distinct userid) king from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_housetype_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) a
        left join
        (SELECT tagname,sum(view_count) value_b from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_housetype_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -60 day) and b.date<DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) b
        on a.tagname=b.tagname) a
        INNER JOIN
        (
        select a.tagname,ifnull(cast(value_a*100/value_b as decimal(10,2)),0)  as 'pre_x' from
        (SELECT tagname,sum(view_count) value_a from (select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_housetype_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename'
        ) k1 group by tagname) a
        left JOIN
        (select sum(view_count) value_b from (
        select distinct b.* from new_subscribe_tmp.st_10_5_20160701 a
        INNER JOIN new_subscribe.dw_basic_user_converge_housetype_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename') a) b on 1=1
        ) b on a.tagname=b.tagname;");
        } elseif ($typename == '地铁') {
            $result_king = $User->query("select a.*,b.pre_x from (
        select a.tagname,ifnull(cast((value_a-value_b)*100/value_b as decimal(10,2)),0) as 'pre_y',ifnull(value_a/king,1) as value_a from (SELECT tagname,sum(view_count) value_a,count(distinct userid) king from (select distinct b.* from (select distinct userid,tagname from new_subscribe_tmp.st_10_5_20160701 where tagname='$levname') a
        INNER JOIN new_subscribe.dw_basic_user_converge_railway_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) a
        left join
        (SELECT tagname,sum(view_count) value_b from (select distinct b.* from (select distinct userid,tagname from new_subscribe_tmp.st_10_5_20160701 where tagname='$levname') a
        INNER JOIN new_subscribe.dw_basic_user_converge_railway_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename' and b.date>=DATE_ADD('$max_date',INTERVAL -60 day) and b.date<DATE_ADD('$max_date',INTERVAL -30 day)
        ) k1 group by tagname) b
        on a.tagname=b.tagname) a
        INNER JOIN
        (
        select a.tagname,ifnull(cast(value_a*100/value_b as decimal(10,2)),0)  as 'pre_x' from
        (SELECT tagname,sum(view_count) value_a from (select distinct b.* from (select distinct userid,tagname from new_subscribe_tmp.st_10_5_20160701 where tagname='$levname') a
        INNER JOIN new_subscribe.dw_basic_user_converge_railway_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename'
        ) k1 group by tagname) a
        left JOIN
        (select sum(view_count) value_b from (
        select distinct b.* from (select distinct userid,tagname from new_subscribe_tmp.st_10_5_20160701 where tagname='$levname') a
        INNER JOIN new_subscribe.dw_basic_user_converge_railway_area_day b
        on a.userid=b.userid where a.tagname='$levname' and b.typename='$typename') a) b on 1=1
        ) b on a.tagname=b.tagname;");
        }

        $zuida_max = array_column($result_king, 'value_a');

        $max_num = array_search(max(($zuida_max)), ($zuida_max));

        $max_num_sss = $zuida_max[$max_num];

        $result['tagname'] = array_unique(array_column($result_king, 'tagname'));

        $king1 = array_column($result_king, 'pre_x');

        $max = array_search(max(($king1)), ($king1));

        $min = array_search(min(($king1)), ($king1));

        $max_num1 = $king1[$max] + 5;

        $min_num1 = $king1[$min] - 5;

        $result['x'][0]['girdIndex'] = 0;
        $result['x'][0]['min'] = $min_num1;
        $result['x'][0]['max'] = $max_num1;
        $result['x'][0]['axisTick']['show'] = false;
        $result['x'][0]['axisLine']['show'] = false;


        $king2 = array_column($result_king, 'pre_y');

        $max = array_search(max(($king2)), ($king2));

        $min = array_search(min(($king2)), ($king2));

        $max_num = $king2[$max] + 50;

        $min_num = $king2[$min] - 50;


        $result['y'][0]['girdIndex'] = 0;
        $result['y'][0]['min'] = $min_num;
        $result['y'][0]['max'] = $max_num;
        $result['y'][0]['axisTick']['show'] = false;
        $result['y'][0]['axisLine']['show'] = false;

        $str = [];

        for ($m = 0; $m < count($result['tagname']); $m++) {
            if ($result_king[$m]['tagname'] == $result['tagname'][$m]) {
                $str[$m]['name'] = $result['tagname'][$m];
                $str[$m]['type'] = $type;
                $str[$m]['label']['normal']['show'] = true;
                $str[$m]['label']['normal']['position'] = "top";
                $str[$m]['label']['normal']['formatter'] = "{a}";
                $str[$m]['data'][0][] = $result_king[$m]['pre_x'];
                $str[$m]['data'][0][] = $result_king[$m]['pre_y'];
                $str[$m]['data'][0][] = $result_king[$m]['value_a'];
                $str[$m]['data'][0][] = $result_king[$m]['tagname'];
                $str[$m]['data'][0][] = $max_num_sss;
            }
        }

        $avg = ($min_num + $max_num) / 2;

        #评判线生成X
        $str[0]['markLine']['animation'] = false;
        $str[0]['markLine']['label']['normal']['show'] = false;
        $str[0]['markLine']['lineStyle']['normal']['type'] = "solid";
        $str[0]['markLine']['tooltip']['formatter'] = "评判线";
        $str[0]['markLine']['data'][0][0]['coord'][0] = 10;
        $str[0]['markLine']['data'][0][0]['coord'][1] = $min_num;
        $str[0]['markLine']['data'][0][0]['symbol'] = "none";

        $str[0]['markLine']['data'][0][1]['coord'][0] = 10;
        $str[0]['markLine']['data'][0][1]['coord'][1] = $max_num;
        $str[0]['markLine']['data'][0][1]['symbol'] = "none";


        #评判线生成Y
        $str[0]['markLine']['data'][1][0]['coord'][0] = $min_num1;
        $str[0]['markLine']['data'][1][0]['coord'][1] = $avg;
        $str[0]['markLine']['data'][1][0]['symbol'] = "none";

        $str[0]['markLine']['data'][1][1]['coord'][0] = $max_num1;
        $str[0]['markLine']['data'][1][1]['coord'][1] = $avg;
        $str[0]['markLine']['data'][1][1]['symbol'] = "none";

        $result['data'] = $str;

        $this->ajaxReturn($result);

//        print_r($str);
    }

    public function three_lev_people_bos_map_port()
    {
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $tagname = $_GET['tagname'];
        $typename = $_GET['typename'];
        $result_king[0] = $User->query("select distinct a.c_x as lat,a.c_y as lng from new_subscribe.dw_basic_user_converge_railway_area_day a
        INNER JOIN
        new_subscribe_tmp.st_10_5_20160701 b
        on a.userid=b.userid
        where a.tagname='$tagname' and b.tagname='$typename' and a.c_x is not null;");

        $result_king[1] = $User->query("select distinct a.c_x as lat,a.c_y as lng from new_subscribe.dw_basic_user_converge_railway_area_day a
        INNER JOIN
        new_subscribe_tmp.st_10_5_20160701 b
        on a.userid=b.userid
        where  b.tagname='$typename' and a.c_x is not null;");
        $this->ajaxReturn($result_king);
    }


    public function test_bos()
    {
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $tagname = $_GET['tagname'];
        $typename = $_GET['typename'];
        $key = $_GET['keywords'];
        $type = $_GET['type'];

        $levname = $_GET['levname'];

        $typename = $_GET['typename'];

        $result_king = $User->query("select *,cast(rand()*50 as signed) count from dmp_server.subscribe_orders_content_long where type='zongj_bos' and id=10140");

        $result['tagname'] = array_values(array_unique(array_column($result_king, 'class')));

        $result['biaoqian'] = array_values(array_unique(array_column($result_king, 'type')));


        $str = [];


        for ($m = 0; $m < count($result['tagname']); $m++) {

            for ($n = 0; $n < count($result_king); $n++) {

                if ($result_king[$n]['class'] == $result['tagname'][$m]) {
                    $str[$m]['name'] = $result['tagname'][$m];
                    $str[$m]['data'][$n][0] = $result_king[$n]['value'];
                    $str[$m]['data'][$n][1] = $result_king[$n]['classcode'];
                    $str[$m]['data'][$n][2] = $result_king[$n]['count'];
                    $str[$m]['data'][$n][3] = $result_king[$n]['name'];
                    $str[$m]['data'][$n][4] = $result_king[$n]['class'];
                    $str[$m]['type'] = $type;
//                        $str[$m]['label']['normal']['show'] = true;
//                        $str[$m]['label']['normal']['position'] = "top";
//                        $str[$m]['label']['normal']['formatter'] = '';
//                        $str[$m]['symbolSize'] = $result_king[$n]['count'];
                }

            }
        }

        $king1 = array_column($result_king, 'value');

        $max = array_search(max(($king1)), ($king1));

        $min = array_search(min(($king1)), ($king1));

        $max_num1 = $king1[$max] + 5;

        $min_num1 = $king1[$min] - 5;

        $result['x'][0]['girdIndex'] = 0;
        $result['x'][0]['min'] = $min_num1;
        $result['x'][0]['max'] = $max_num1;
        $result['x'][0]['axisTick']['show'] = false;
        $result['x'][0]['axisLine']['show'] = false;


        $king2 = array_column($result_king, 'classcode');

        $max = array_search(max(($king2)), ($king2));

        $min = array_search(min(($king2)), ($king2));

        $max_num = $king2[$max] + 5;

        $min_num = $king2[$min] - 5;

        $result['y'][0]['girdIndex'] = 0;
        $result['y'][0]['min'] = $min_num;
        $result['y'][0]['max'] = $max_num;
        $result['y'][0]['axisTick']['show'] = false;
        $result['y'][0]['axisLine']['show'] = false;

        $avg = ($min_num + $max_num) / 2;

        #评判线生成X
        $str[0]['markLine']['animation'] = false;
        $str[0]['markLine']['label']['normal']['show'] = false;
        $str[0]['markLine']['lineStyle']['normal']['type'] = "solid";
        $str[0]['markLine']['tooltip']['formatter'] = "评判线";
        $str[0]['markLine']['data'][0][0]['coord'][0] = 10;
        $str[0]['markLine']['data'][0][0]['coord'][1] = $min_num;
        $str[0]['markLine']['data'][0][0]['symbol'] = "none";
        $str[0]['markLine']['data'][0][1]['coord'][0] = 10;
        $str[0]['markLine']['data'][0][1]['coord'][1] = $max_num;
        $str[0]['markLine']['data'][0][1]['symbol'] = "none";


        #评判线生成Y
        $str[0]['markLine']['data'][1][0]['coord'][0] = $min_num1;
        $str[0]['markLine']['data'][1][0]['coord'][1] = $avg;
        $str[0]['markLine']['data'][1][0]['symbol'] = "none";
        $str[0]['markLine']['data'][1][1]['coord'][0] = $max_num1;
        $str[0]['markLine']['data'][1][1]['coord'][1] = $avg;
        $str[0]['markLine']['data'][1][1]['symbol'] = "none";


        $str[0]['data'] = array_values($str[0]['data']);
        $str[1]['data'] = array_values($str[1]['data']);
        $str[2]['data'] = array_values($str[2]['data']);
        $str[3]['data'] = array_values($str[3]['data']);

        $result['data'] = $str;


        $this->ajaxReturn($result['data']);
    }


    public function k_20160719_new_experiment_port()
    {

        $type = $_GET['type'];

        $levname = $_GET['levname'];

        $typename = $_GET['typename'];

        $user = M('login_user_test');
        $result_king = $user ->query("select a.keywords, #楼盘名称
a.decision_count, #决策人数
cast(a.total_square as decimal(10,2)) as 'total_square', #本月交易面积
cast(decision_count*100/total_decision_count  as decimal(5,2)) 'decision_pre', #本月供给量占比
cast(a.total_square/decision_count as decimal(5,2)) as 'contribution_pre', #本月人群贡献率（㎡/人）
cast(previous_decision_count*100/total_previous_decision_count as decimal(5,2)) as 'previous_decision_pre', #上月供给量占比
cast( (previous_decision_count/total_previous_decision_count)*total_decision_count as signed) as 'contribution_KPI_count', #供给量指标
cast(a.previous_total_square/a.previous_decision_count as decimal(10,2)) as 'previous_contribution_pre', #上月人群贡献率指标（㎡/人）
a.decision_count*cast(a.previous_total_square/a.previous_decision_count as decimal(10,2)) as 'square_KPI', #交易(面积)量指标
cast( ( cast(decision_count*100/total_decision_count  as decimal(5,2))-cast(previous_decision_count*100/total_previous_decision_count as decimal(5,2)) )*100 / cast(previous_decision_count*100/total_previous_decision_count as decimal(5,2)) as decimal(5,2) ) as 'this/previous_pre_increase', #供应量占比涨幅
cast( ( cast(a.total_square/decision_count as decimal(5,2))-cast(a.previous_total_square/a.previous_decision_count as decimal(10,2)) )*100 /cast(a.previous_total_square/a.previous_decision_count as decimal(10,2)) as decimal(5,2)) as 'this/previous_people_pre_increase', #人群贡献率涨幅
a.previous_decision_count,  #上期决策人数
cast(a.previous_total_square as decimal(10,2)) as 'previous_total_square',
null as 'heng_biaoxian',
null as 'zong_biaoxian',
cast(a.total_square*100/total_total_square as decimal(10,2)) as 'square_pre'
from report_display_shanghai.st_10_5_20160719_new_experiment_final_step a
left JOIN
(
select sum(decision_count) as total_decision_count,
sum(total_square) total_total_square,
sum(previous_decision_count) as total_previous_decision_count,
sum(previous_total_square) as total_previous_total_square
from report_display_shanghai.st_10_5_20160719_new_experiment_final_step
) b on 1=1
union ALL
select '合计',
sum(decision_count),
cast(sum(total_square) as decimal(10,2)),
'100',
cast(sum(total_square)/sum(decision_count) as decimal(5,2)),
'100',
sum(decision_count),
cast(sum(previous_total_square)/sum(previous_decision_count) as decimal(5,2)),
sum(decision_count)*cast(sum(previous_total_square)/sum(previous_decision_count) as decimal(5,2)),
0,
0,
sum(previous_decision_count),
cast(sum(previous_total_square) as decimal(10,2)),
cast( (cast(sum(total_square)/sum(decision_count) as decimal(5,2))-(cast(sum(previous_total_square) as decimal(10,2))/sum(previous_decision_count)))*100/(cast(sum(previous_total_square) as decimal(10,2))/sum(previous_decision_count)) as decimal(10,2)),
cast( (sum(decision_count)-sum(previous_decision_count))*100/sum(previous_decision_count) as decimal(10,2)),
0
#sum(previous_decision_count) as total_previous_decision_count,
#sum(previous_total_square) as total_previous_total_square
from report_display_shanghai.st_10_5_20160719_new_experiment_final_step;");

        $result['tagname'] = array_values(array_unique(array_column($result_king, 'keywords')));

        $zong_biaoxian = array_values(array_unique(array_column($result_king, 'zong_biaoxian')));

        $heng_biaoxian = array_values(array_unique(array_column($result_king, 'heng_biaoxian')));

//        $result['zong_biaoxian'] = $zong_biaoxian;
//
//        $result['heng_biaoxian'] = $heng_biaoxian;

        $king1 = array_column($result_king, 'this/previous_pre_increase');

        $max = array_search(max(($king1)), ($king1));

        $min = array_search(min(($king1)), ($king1));

        $max_num1 = $king1[$max] + 5;

        $min_num1 = $king1[$min] - 5;

//        $result['x'][0]['girdIndex'] = 0;
        $result['x'][0]['min'] = $min_num1;
        $result['x'][0]['max'] = $max_num1;
//        $result['x'][0]['margin'] = 20;

        $king2 = array_column($result_king, 'this/previous_people_pre_increase');

        $max = array_search(max(($king2)), ($king2));

        $min = array_search(min(($king2)), ($king2));

        $max_num = $king2[$max] + 50;

        $min_num = $king2[$min] - 50;

//        $result['y'][0]['girdIndex'] = 0;

        $result['x'][0]['min'] = -$max_num;
        $result['x'][0]['max'] = $max_num;

        $result['y'][0]['min'] = -$max_num;
        $result['y'][0]['max'] = $max_num;

        $str = [];

        for ($m = 0; $m < count($result_king)-1; $m++) {
            $str[$m]['name'] = $result['tagname'][$m];
            $str[$m]['type'] = $type;
            $str[$m]['label']['normal']['show'] = true;
            $str[$m]['label']['normal']['position'] = "top";
            $str[$m]['label']['normal']['formatter'] = "{a}";
            $str[$m]['data'][0][0]=$result_king[$m]['this/previous_pre_increase'];
            $str[$m]['data'][0][1]=$result_king[$m]['this/previous_people_pre_increase'];



//            $str[0]['markLine']['data'][3+$m][0]['symbol'] = 'none';
//            $str[0]['markLine']['data'][3+$m][0]['coord'][0] = (float)$result_king[$m]['this/previous_pre_increase'];
//            $str[0]['markLine']['data'][3+$m][0]['coord'][1] = (float)$result_king[$m]['this/previous_people_pre_increase'];
//
//            $str[0]['markLine']['data'][3+$m][1]['symbol'] = 'none';
//            $str[0]['markLine']['data'][3+$m][1]['coord'][0] = ((float)$result_king[$m]['this/previous_pre_increase']-(float)$result_king[$m]['this/previous_people_pre_increase'])/2;
//            $str[0]['markLine']['data'][3+$m][1]['coord'][1] = -((float)$result_king[$m]['this/previous_pre_increase']-(float)$result_king[$m]['this/previous_people_pre_increase'])/2;
//            $str[0]['markLine']['data'][3+$m][1]['lineStyle']['normal']['color'] = '#8B008B';
//            $str[0]['markLine']['data'][3+$m][1]['label']['normal']['show'] = false;

        }

        for ($m = 0; $m < count($result_king)-1; $m++) {

            $ccc = intval( (abs($result_king[$m]['this/previous_pre_increase']+$result_king[$m]['this/previous_people_pre_increase']))/sqrt(2) ) ;

            $bar_king[$m]['name'] = $result_king[$m]['keywords'];

            $bar_king[$m]['value'] = intval( (abs($result_king[$m]['this/previous_pre_increase']+$result_king[$m]['this/previous_people_pre_increase']))/sqrt(2) );

            if($result_king[$m]['this/previous_pre_increase']+$result_king[$m]['this/previous_people_pre_increase']<0){
            $bar_king[$m]['value'] = -intval( (abs($result_king[$m]['this/previous_pre_increase']+$result_king[$m]['this/previous_people_pre_increase']))/sqrt(2) );
            }
            $str[$m]['markLine']['silent'] = true;
            $str[$m]['markLine']['data'][0][0]['symbol'] = 'none';
            $str[$m]['markLine']['data'][0][0]['coord'][0] = (float)$result_king[$m]['this/previous_pre_increase'];
            $str[$m]['markLine']['data'][0][0]['coord'][1] = (float)$result_king[$m]['this/previous_people_pre_increase'];

            $str[$m]['markLine']['data'][0][1]['symbol'] = 'none';
            $str[$m]['markLine']['data'][0][1]['coord'][0] = ((float)$result_king[$m]['this/previous_pre_increase']-(float)$result_king[$m]['this/previous_people_pre_increase'])/2;
            $str[$m]['markLine']['data'][0][1]['coord'][1] = -((float)$result_king[$m]['this/previous_pre_increase']-(float)$result_king[$m]['this/previous_people_pre_increase'])/2;
            $str[$m]['markLine']['data'][0][1]['lineStyle']['normal']['color'] = '#8B008B';
            $str[$m]['markLine']['data'][0][1]['label']['normal']['show'] = true;
            $str[$m]['markLine']['data'][0][1]['label']['normal']['formatter'] = "$ccc";
            $str[$m]['markLine']['data'][0][1]['label']['normal']['position'] = 'middle';
        }

//        $str[0]['markLine']['animation'] = false;
//        $str[0]['markLine']['label']['normal']['show'] = false;
//        $str[0]['markLine']['lineStyle']['normal']['type'] = "solid";
//        $str[0]['markLine']['tooltip']['formatter'] = "评判线";
        $str[0]['markLine']['data'][1]['yAxis'] = (float)$heng_biaoxian[1];
        $str[0]['markLine']['data'][1]['label']['normal']['show'] = true;
        $str[0]['markLine']['data'][1]['label']['normal']['position'] = 'end';
        $str[0]['markLine']['data'][1]['label']['normal']['formatter'] = '转化质量基准线';
        $str[0]['markLine']['symbol'] = 'none';

        $str[0]['markLine']['silent'] = true;
        $str[0]['markLine']['data'][2]['xAxis'] = (float)$zong_biaoxian[1];
        $str[0]['markLine']['data'][2]['label']['normal']['show'] = true;
        $str[0]['markLine']['data'][2]['label']['normal']['position'] = 'start';
        $str[0]['markLine']['data'][2]['label']['normal']['formatter'] = '供给量基准线';


        $str[0]['markLine']['data'][3][0]['symbol'] = 'none';
        $str[0]['markLine']['data'][3][0]['coord'][0] = -$max_num;
        $str[0]['markLine']['data'][3][0]['coord'][1] = $max_num;
        $str[0]['markLine']['data'][3][1]['symbol'] = 'none';
        $str[0]['markLine']['data'][3][1]['coord'][0] = $max_num;
        $str[0]['markLine']['data'][3][1]['coord'][1] = -$max_num;
        $str[0]['markLine']['data'][3][1]['lineStyle']['normal']['color'] = 'red';
        $str[0]['markLine']['data'][3][1]['lineStyle']['normal']['type'] = 'solid';
        $str[0]['markLine']['data'][3][1]['label']['normal']['show'] = true;
        $str[0]['markLine']['data'][3][1]['label']['normal']['formatter'] = '业务表现基准线';

#以下是新标线
        $new_biaoxian =  intval( (abs(((float)$zong_biaoxian[1]+(float)$heng_biaoxian[1])))/sqrt(2) );

        $str[0]['markLine']['silent'] = true;
        $str[0]['markLine']['data'][4][0]['symbol'] = 'none';
        $str[0]['markLine']['data'][4][0]['coord'][0] = (float)$zong_biaoxian[1];
        $str[0]['markLine']['data'][4][0]['coord'][1] = (float)$heng_biaoxian[1];

        $str[0]['markLine']['data'][4][1]['symbol'] = 'none';
        $str[0]['markLine']['data'][4][1]['coord'][0] = ((float)$zong_biaoxian[1]-(float)$heng_biaoxian[1])/2;
        $str[0]['markLine']['data'][4][1]['coord'][1] = -((float)$zong_biaoxian[1]-(float)$heng_biaoxian[1])/2;
        $str[0]['markLine']['data'][4][1]['lineStyle']['normal']['color'] = '#800000';
        $str[0]['markLine']['data'][4][1]['label']['normal']['show'] = true;
        $str[0]['markLine']['data'][4][1]['label']['normal']['formatter'] = "$new_biaoxian";
        $str[0]['markLine']['data'][4][1]['label']['normal']['position'] = 'middle';

        if((float)$zong_biaoxian[1]+(float)$heng_biaoxian[1]<0){
            $new_biaoxian_num=-$new_biaoxian;
        }

        $bbb = [];

        $result['data'] = $str;

        $cccnnn = array_column($bar_king, 'value');

        arsort($cccnnn,SORT_NUMERIC);

        $cccnnn = array_values($cccnnn);

        for ($n = 0; $n < count($cccnnn); $n++) {
            for ($c = 0; $c < count($bar_king); $c++) {
                if($cccnnn[$n]==$bar_king[$c]['value']){
                    $bbb[$n]['label']['normal']['show'] = false;
                    $bbb[$n]['label']['normal']['position'] = "top";
                    $bbb[$n]['label']['normal']['formatter'] = "{a}";
                    $bbb[$n]['name'] = $bar_king[$c]['name'];
                    $bbb[$n]['value'] = $bar_king[$c]['value'];
                }
            }
        }

        $result['bar_king']= $bbb;

        $result['bar_king_name']=array_column($bbb, 'name');

        $result['new_biaoxian_num']= $new_biaoxian_num;

//        $str[$m]['name'] = $result['tagname'][$m];
//        $str[$m]['type'] = $type;
//        $str[$m]['label']['normal']['show'] = true;
//        $str[$m]['label']['normal']['position'] = "top";
//        $str[$m]['label']['normal']['formatter'] = "{a}";
//        $str[$m]['data'][0][0]=$result_king[$m]['this/previous_pre_increase'];
//        $str[$m]['data'][0][1]=$result_king[$m]['this/previous_people_pre_increase'];

        #以下是新波士顿矩阵的图标数据

        for ($m = 0; $m < count($result_king)-1; $m++) {

            $bos_str[$m]['name'] = $result_king[$m]['keywords'];

            $bos_str[$m]['type'] = $type;

        $bos_str[$m]['label']['normal']['show'] = true;
        $bos_str[$m]['label']['normal']['position'] = "top";
        $bos_str[$m]['label']['normal']['formatter'] = "{a}";

            for ($n = 0; $n < count($bar_king); $n++) {
                if($result_king[$m]['keywords']==$bar_king[$n]['name'])
                {
                    $bos_str[$m]['data'][0][0] = $result_king[$m]['square_pre'];
                    $bos_str[$m]['data'][0][1] = (string)$bar_king[$n]['value'];
                }
            }
        }


        $bos_str[0]['markLine']['data'][0]['xAxis'] = 10;
        $bos_str[0]['markLine']['data'][0]['label']['normal']['show'] = true;
        $bos_str[0]['markLine']['data'][0]['label']['normal']['position'] = 'start';
        $bos_str[0]['markLine']['data'][0]['label']['normal']['formatter'] = '';
        $bos_str[0]['markLine']['data'][0]['lineStyle']['normal']['color'] = 'red';
        $bos_str[0]['markLine']['symbol'] = 'none';
        $bos_str[0]['markLine']['silent'] = true;

        $bos_king = array_column($result_king, 'square_pre');

        $bos_max = array_search(max(($bos_king)), ($bos_king));

        $bos_min = array_search(min(($bos_king)), ($bos_king));

        $bos_max_num1 = $bos_king[$bos_max] + 10;

        $bos_min_num1 = $bos_king[$bos_min] - 10;

//        $result['x'][0]['girdIndex'] = 0;
        $result_bos['x'][0]['min'] = $bos_min_num1;
        $result_bos['x'][0]['max'] = $bos_max_num1;

        $bos_king = array_column($bar_king, 'value');

        $bos_max = array_search(max(($bos_king)), ($bos_king));

        $bos_min = array_search(min(($bos_king)), ($bos_king));

        $bos_max_num1 = $bos_king[$bos_max] + 10;

        $bos_min_num1 = $bos_king[$bos_min] - 10;

//        $result['x'][0]['girdIndex'] = 0;
        $result_bos['y'][0]['min'] = $bos_min_num1;
        $result_bos['y'][0]['max'] = $bos_max_num1;


        $bos_avg = ($bos_min_num1+$bos_max_num1)/2;

        $bos_str[1]['markLine']['data'][0]['yAxis'] = $bos_avg;
        $bos_str[1]['markLine']['data'][0]['label']['normal']['show'] = true;
        $bos_str[1]['markLine']['data'][0]['label']['normal']['position'] = 'start';
        $bos_str[1]['markLine']['data'][0]['label']['normal']['formatter'] = '';
        $bos_str[1]['markLine']['data'][0]['lineStyle']['normal']['color'] = 'red';
        $bos_str[1]['markLine']['symbol'] = 'none';
        $bos_str[1]['markLine']['silent'] = true;


        $result_bos['data']=$bos_str;


        $bos_tagname = array_column($bar_king, 'name');

        $result_bos['tagname']=$bos_tagname;


        $result['bos'] = $result_bos;
        $this->ajaxReturn($result);
    }


    public function businss_assessment_upload()
    {
        if (!empty($_FILES['photo']['name'])) {
            $upload = new \Think\Upload();
            $upload->maxSize = 93145728;
            $upload->allowExts = array('xls', 'xlsx');
            $upload->saveRule = 'uniqid';
            $info = $upload->upload();
            if (!$info) {
                $this->error($upload->getError());
            } else {
                foreach ($info as $file) {
                };
            }
            import("Org.Util.PHPExcel");
            $ex = M("report_display_shanghai.st_10_5_20160719_test_list");
            $ex->execute('delete from report_display_shanghai.st_10_5_20160719_test_list;');
            $file_name = 'D:/wamp/www/Uploads/' . $file['savepath'] . $file['savename'];                  //'/Uploads/'.$file['savepath'].$file['savename'];
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();
            for ($i = 1; $i <= $highestRow; $i++) {
                $data['keywords'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
//                $data['product'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                $rs = $ex->add($data);
            }
            $this->success('恭喜你,已经成功导入');
            exit;
        } else {
            $this->error("请选择上传的文件");
        }
    }


    public function businss_assessment_status()
    {
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $result = $user->query("select keywords from report_display_shanghai.st_10_5_20160719_test_list");
        $this->ajaxReturn($result);
    }

    public function area_rose_pie_port(){

        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $tagname = $_GET['tagname'];
        $typename = $_GET['typename'];
        $key = $_GET['keywords'];
        $type = $_GET['type'];
        $levname = $_GET['levname'];
        $typename = $_GET['typename'];

        $result_king = $User->query("select district as 'name',sum(view_count) as 'value' from new_subscribe.dw_basic_user_converge_buildings_day where tagname
        in (select name from dmp_server.subscribe_orders_content where id=$key and type='jingp') and district is not null
        group by district order by value desc limit 17;");

        shuffle($result_king);

        $tagname = array_column($result_king, 'name');

        $result['tagname'] = $tagname;
        $result['data'] = $result_king;

        $this->ajaxReturn($result);
    }




}
