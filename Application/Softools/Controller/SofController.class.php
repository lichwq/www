<?php
namespace Softools\Controller;

use Think\Controller;
use Think;

ignore_user_abort();
set_time_limit(0);

class SofController extends Controller
{
    public function index()
    {
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎来到上富工具集合 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>', 'utf-8');
    }

    public function mapapi()
    {
        $isAjax = $_GET['isajax'];

//        echo date('y-m-d h:i:s', time());

        $Form = M('changzhou_dim_c_x_c_y_detail');

//            $myfile = fopen("sqlupdate.txt", "w") or die("Unable to open file!");

        // 读取数据
        $zuobiao = $Form->query("select distinct c_x,c_y from dmp_server.changzhou_dim_c_x_c_y_detail where province is null limit 5000");

        $Form->execute("update dmp_server.mapapi_counts_tools set status=1 where product='$isAjax'");

        foreach ($zuobiao as $value) {
            $ch = curl_init();

// 设置URL和相应的选项
            curl_setopt($ch, CURLOPT_URL, "http://api.map.baidu.com/geocoder/v2/?ak=3c0e5fed39c5e64f6effefa1e1f54e0a&location=$value[c_x],$value[c_y]&output=json&pois=1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// 抓取URL并把它传递给浏览器
            $data = json_decode(curl_exec($ch), true);
//                $res = $data[result][addressComponent];
            $res[business] = $data[result][business];
            $res[c_x] = $value[c_x];
            $res[c_y] = $value[c_y];

            $res[city] = $data[result][addressComponent][city];
            $res[province] = $data[result][addressComponent][province];
            $res[district] = $data[result][addressComponent][district];
            $res[street] = $data[result][addressComponent][street];
            $business = $data[result][addressComponent][business];
            if (empty($business)) {
                $business = "null";
            }
            $res[details] = $data[result][addressComponent][province] . $data[result][addressComponent][city] . $data[result][addressComponent][district] . $data[result][addressComponent][street];
//                $Form2 = M('suzhou_dim_c_x_c_y_detail_test_20160125');
            $Form->where("c_x ='$res[c_x]' and c_y = '$res[c_y]' ")->save($res);

//                $myfile = fopen("sqlupdate.txt", "a") or die("Unable to open file!");
//                $txt = "update dmp_server.suzhou_dim_c_x_c_y_detail_test_20160125
//               set city='$res[city]',province='$res[province]',district='$res[district]',street='$res[street]',business=" . $business . ",details='$res[details]'
//               where c_x=$res[c_x] and c_y=$res[c_y]; \n";
//                fwrite($myfile, $txt);
//                fclose($myfile);

//                $Form2->execute("update dmp_server.suzhou_dim_c_x_c_y_detail_test_20160125
//                set city='$city',province='$province',district='$district',street='$street',business=" . $business . ",details='$details'
//                where c_x=$res[c_x] and c_y=$res[c_y]");

            curl_close($ch);
//            sleep(0.5);
//            echo $value[c_y].$city;
//                print_r($res);
//            $this->display();

        }


        $Form->execute("update dmp_server.mapapi_counts_tools set status=0 where product='$isAjax'");
//            $Form2 = M('suzhou_dim_c_x_c_y_detail_test_20160125');
//
//
//            $Form2->execute();

//            unset($zuobiao);
//            unset($Form);
//            sleep(5);
//        echo '好了!';
//        echo date('y-m-d h:i:s', time());
//        $this->display();
    }


    function mapapi_counts_tools()
    {
        $isAjax = $_GET['isajax'];
        $m = M('hangzhou_dim_c_x_c_y_detail');
        $data1 = $m->query("select count(*) count from changzhou_dim_c_x_c_y_detail where province is not null");
        $data2 = $m->query("select count(*) total_count from changzhou_dim_c_x_c_y_detail");
        $data3 = $m->query("select status from dmp_server.mapapi_counts_tools where product='$isAjax'");

        $result[count] = $data1;
        $result[total_count] = $data2;
        $result[status] = $data3;
        $this->ajaxReturn($result);
    }

    function sof_map_tools()
    {
        $isAjax = $_GET['mm'];
        $isAjax1 = $_GET['nn'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        if ($isAjax == '含竞品') {
            $data2 = $m->query("select distinct project as district,substr(project,1,2) p_name from test_backup.values_people where substr(project,1,2)='$isAjax1';");
            $this->ajaxReturn($data2);
        } else if ($isAjax == '仅本案') {
            $data3 = $m->query("select distinct keywords as district,substr(project,1,2) p_name from test_backup.people_event_plus_test_map_201602  where substr(project,1,2)='$isAjax1';");
            $this->ajaxReturn($data3);
        } else if ($isAjax == '投放项目') {
            $data4 = $m->query("select distinct projectname as district,substr(projectname,1,2) p_name from dmp_server.st_hangzhou_put_report_data  where substr(projectname,1,2)='$isAjax1';");
            $this->ajaxReturn($data4);
        } else {
            $data2 = $m->query("select distinct project as district,substr(project,1,2) p_name from test_backup.values_people where substr(project,1,2)='$isAjax1';");
            $data3 = $m->query("select distinct keywords as district,substr(project,1,2) p_name from test_backup.people_event_plus_test_map_201602  where substr(project,1,2)='$isAjax1';");
            $this->assign('list', $data2);
            $this->assign('list2', $data3);
            if(cookie('isdenglu')==3306)
            {
                $this->display();

            }else{
                $this->error("账号或者密码不正确!", '/sof/sof_login', 2);
            }
        }
    }

    function sof_map_tools_special()
    {
        $isAjax = $_GET['mm'];
        $isAjax1 = $_GET['nn'];

        $keywords=cookie('keywords');

        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        if ($isAjax == '含竞品') {
            $data2 = $m->query("select distinct project as district,substr(project,1,2) p_name from test_backup.values_people where substr(project,1,2)='$isAjax1' and project in ($keywords);");
            $this->ajaxReturn($data2);
        } else if ($isAjax == '仅本案') {
            $data3 = $m->query("select distinct keywords as district,substr(project,1,2) p_name from test_backup.people_event_plus_test_map_201602  where substr(project,1,2)='$isAjax1';");
            $this->ajaxReturn($data3);
        } else if ($isAjax == '投放项目') {
            $data4 = $m->query("select distinct projectname as district,substr(projectname,1,2) p_name from dmp_server.st_hangzhou_put_report_data  where substr(projectname,1,2)='$isAjax1';");
            $this->ajaxReturn($data4);
        } else {
            $data2 = $m->query("select distinct project as district,substr(project,1,2) p_name from test_backup.values_people where substr(project,1,2)='$isAjax1';");
            $data3 = $m->query("select distinct keywords as district,substr(project,1,2) p_name from test_backup.people_event_plus_test_map_201602  where substr(project,1,2)='$isAjax1';");
            $this->assign('list', $data2);
            $this->assign('list2', $data3);
            if(cookie('isdenglu_special')==3305)
            {
//                echo "select distinct project as district,substr(project,1,2) p_name from test_backup.values_people where project in ($keywords);";
                $this->display();

            }else{
                $this->error("账号或者密码不正确!", '/sof/sof_login_special', 2);
            }
        }
    }


    function map_sales_points(){
        $project = $_GET['project'];
        $hot = $_GET['ishot'];
        $m = M('hangzhou_dim_c_x_c_y_detail');
        $result=$m->query("SELECT * FROM test_backup.hot_area_ex where project='$project' ORDER BY usercnt desc limit $hot;");
        $this->ajaxReturn($result);
    }

    function ajax1()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)*'$isAjax1'/1.5 count from test_backup.people_event_plus where project = '$isAjax' group by c_x,c_y order by count(*) desc limit 3000 ;");
        $this->ajaxReturn($data1);
    }


    function ajax1_1()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)*'$isAjax1'/1.5 count from dmp_server.st_hangzhou_put_report_data  where projectname = '$isAjax' group by c_x,c_y order by count(*) desc");
        $this->ajaxReturn($data1);
    }


    function ajax2()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)*'$isAjax1'/1.5 count from test_backup.people_event_plus where project = '$isAjax' group by c_x,c_y  order by count(*) desc limit 3000;");
        $this->ajaxReturn($data1);
    }

    function ajax3()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)*'$isAjax1'/1.5 count from test_backup.people_event_plus_test_map_201602 where keywords = '$isAjax' group by c_x,c_y order by count(*) desc limit 3000 ;");
        $this->ajaxReturn($data1);
    }

    function ajax4()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)/1.5*'$isAjax1' count from test_backup.people_event_plus_test_map_201602 where keywords = '$isAjax' group by c_x,c_y  order by count(*) desc  limit 3000;");
        $this->ajaxReturn($data1);
    }

    function ajax5()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $isAjax2 = $_GET['res2'];
        $isAjax3 = $_GET['res3'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)/1.5 count from test_backup.people_event_plus_test_map_201602 where hour>='$isAjax1' and hour<='$isAjax2' and keywords = '$isAjax' group by c_x,c_y  order by count(*) desc  limit 3000;");
        $data2 = $m->query("select c_x as lat,c_y lng ,count(*)/1.5 count from test_backup.people_event_plus_test_map_201602 where (hour>='$isAjax1' or hour<='$isAjax2') AND keywords = '$isAjax' group by c_x,c_y  order by count(*) desc  limit 3000;");
        if ($isAjax3 == '办公室') {
            $this->ajaxReturn($data1);
        } else {
            $this->ajaxReturn($data2);
        }
    }

    function ajax6()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $isAjax2 = $_GET['res2'];
        $isAjax3 = $_GET['res3'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count(*)/1.5 count from test_backup.people_event_plus_test_map_201602 where hour>='09' and hour<='18' and keywords = '$isAjax' group by c_x,c_y  order by count(*) desc  limit 2000;");
        $data2 = $m->query("select c_x as lat,c_y lng ,count(*)/1.5 count from test_backup.people_event_plus_test_map_201602 where (hour>='19' or hour<='08') AND keywords = '$isAjax' group by c_x,c_y  order by count(*) desc  limit 2000;");
        $result['data1'] = $data1;
        $result['data2'] = $data2;
        $this->ajaxReturn($result);
    }


    function search_keywords_ajax()
        {
            $keywords = $_GET['res'];
            $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
            if ($keywords <> '') {
                $data1 = $m->query(
                    "select * from (select distinct dick as keywords from report_display.st_soc_people_event_analysis_total
union all select distinct dick as keywords from report_display_shanghai.st_soc_people_event_analysis_total) a where keywords
 like '%$keywords%';");
            }
            $this->ajaxReturn($data1);

    }



    function search_hangzhou_keywords()
    {
        $keywords = $_GET['res'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        if ($keywords <> '') {
            $data1 = $m->query("select distinct substring_index(projectname,'-',-1) as 'keywords'
            from gdas_adv.policy_detail where projectname like '%杭州%' and projectname like '%$keywords%';");
        }
        $this->ajaxReturn($data1);

    }

    function test_sheet_ajax()
    {
        $keywords = $_GET['res'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select time as date,concat(project,' : ',tags) project,status part from test.products_owner_qiantai;");
        $this->ajaxReturn($data1);
    }


    function ajax_map_area()
    {
        $isAjax = $_GET['res'];
        $isAjax1 = $_GET['res1'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select c_x as lat,c_y lng ,count from dmp_server.test_hangzhou_ceshi_20160309 where district='$isAjax' limit 500;");
        $data2 = $m->query("select count(*) as users_count from dmp_server.test_hangzhou_ceshi_20160309 where district='$isAjax';");
        $result['points'] = $data1;
        $result['users_count'] = $data2;
        $this->ajaxReturn($result);
    }

    function ajax_xiaowu()
    {
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select * from test.hadoop_status");
        $this->ajaxReturn($data1);
    }

    function ajax_xiaowu_gai()
    {
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->execute("update test.hadoop_status set status = 1;");
        $r = '小吴牛逼';
        $this->ajaxReturn($r);
    }

    function gongdanzhuangtai()
    {
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select case when b.status=1 then '高芒正在跑数据!'
when a.status=0 then '目前系统空闲 ! '
when a.status=1 then '工单上传完成' when a.status=2 then '正在按顺序执行工单...'
when a.status=3 then '正在格式化工单列表,制作流程...'
when b.status=1 then '高芒正在跑数据!' end status
from test.hadoop_status a INNER JOIN test.hadoop_status2 b on 1=1;");
        $this->ajaxReturn($data1);
    }

    function gogndanlichwq()
    {
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select * from test.report");
        $this->ajaxReturn($data1);
    }


    function hangzhou_6_bianxing()
    {
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select * from dmp_server.2016_03_14_hangzhou_lingxing_copy where keywords='杭州世茂华家池天宸住宅及竞品' limit 300");
        $this->ajaxReturn($data1);
    }


    function baidu_echart1()
    {
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select firstday,count(*) count from test.values_people group by firstday");
        $this->ajaxReturn($data1);
    }


    public function sites_6_points()
    {
        $list = M("dim_weilan_2016_list");
        $rs = $list->select();
        $this->assign("rs", $rs);
        if(cookie('isdenglu')==3306)
        {
            $this->display();

        }else{
            $this->error("账号或者密码不正确!", '/sof/sof_login', 2);
        }
    }


    public function gongdanshangchuan()
    {
        $list = M("test.products_owner");
        $rs = $list->select();
        $this->assign("rs", $rs);
        if(cookie('isdenglu')==3306)
        {
            $this->display();

        }else{
            $this->error("账号或者密码不正确!", '/sof/sof_login', 2);
        }
    }


    public function gongdanshangchuan_status()
    {
        $list = M("test.hadoop_status2");
        $rs = $list->query("select * from test.hadoop_status
        union all
        select * from test.hadoop_status1
        union all
        (select project from test.products_owner limit 1);");
        $this->ajaxReturn($rs);
    }

    public function sites_6_points_weilan()
    {
        $list = M("dim_weilan_2016_list");
        $list->execute('delete from dmp_server.20160315_hangzhou_userinfo_base;');
        $list->execute("insert into dmp_server.20160315_hangzhou_userinfo_base
select c_x,c_y,b.project,details,count(*) kk from gdas_data_processing_new.hangzhou_userinfo_base a INNER JOIN
dmp_server.dim_weilan_2016_list b on a.keywords=b.product where details<>'NULL' group by c_x,c_y,b.project having count(*)>2 order by b.project,count(*) desc;");
        $list->execute("call dmp_server.20160314_hangzhou_6sites_first");
    }

    public function upload()
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
            $ex = M("dim_weilan_2016_list");
            $ex->execute('delete from dmp_server.dim_weilan_2016_list;');
            $file_name = 'D:/wamp/www/Uploads/' . $file['savepath'] . $file['savename'];                  //'/Uploads/'.$file['savepath'].$file['savename'];
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();
            for ($i = 2; $i <= $highestRow; $i++) {
                $data['project'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                $data['product'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                $rs = $ex->add($data);
            }
            $this->success('Excel数据导入成功');
            exit;
        } else {
            $this->error("请选择上传的文件");
        }
    }


    /**方法**/
    public function exportExcel($expTitle, $expCellName, $expTableData)
    {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = '围栏坐标数据' . date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        import("Org.Util.PHPExcel");

        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');

//        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    /**
     *
     * 导出Excel
     */
    function expUser()
    {//导出Excel
        $xlsName = "User";
        $xlsCell = array(
            array('keywords', '项目'),
            array('details', '热区'),
            array('x_original', '热区中心点-x'),
            array('y_original', '热区中心点-y'),
            array('hot_level', 'hot_level'),
            array('x', '热区-x'),
            array('y', '热区-y')
        );
        $xlsModel = M('2016_03_14_hangzhou_6ites');
        $xlsData = $xlsModel->Field('x_original,y_original,keywords,hot_level,details,x,y')->select();
        foreach ($xlsData as $k => $v) ;
        $this->exportExcel($xlsName, $xlsCell, $xlsData);
    }


    public function upload_gongdan()
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
            $ex = M("test.products_owner");
            $ex->execute('delete from test.products_owner;');
            $file_name = 'D:/wamp/www/Uploads/' . $file['savepath'] . $file['savename'];                  //'/Uploads/'.$file['savepath'].$file['savename'];
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();
            for ($i = 2; $i <= $highestRow; $i++) {
                $data['productor'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                $data['project'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                $data['product'] = $objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue();
                $data['isowner'] = $objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue();
                $data['biaoqian'] = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getValue();
                $rs = $ex->add($data);
            }
           $ex ->execute("update test.hadoop_status set status = '1'");
            $this->success('Excel数据导入成功');
            exit;
        } else {
            $this->error("请选择上传的文件");
        }
    }

    function checkSignature()
    {
        if (IS_POST) {
            $m = M('wechat.users');

            $poststr = $GLOBALS["HTTP_RAW_POST_DATA"];
            $kk = simplexml_load_string($poststr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $wechatid = $kk->ToUserName;
            $openid = $kk->FromUserName;
            $Event = $kk->Event;
            $EventKey = $kk->EventKey;
            $MsgType = $kk->MsgType;
            $Recognition = $kk->Recognition;

            file_put_contents('ceshi.txt',$poststr);


            #判断用户的关注动作
            $openidisalive = $m->query("select * from wechat.lichwq_users where openid = '$openid'");

            if (isset($openidisalive[0]['openid']) && ($openidisalive[0]['status'] == '0')) {
                $m->execute("update wechat.lichwq_users set status = '1' where openid = '$openid'");
            } else if ($Event == 'subscribe') {
                $m->execute("insert into wechat.lichwq_users(openid,status) values('$openid','1')");
            } else if ($Event == 'unsubscribe') {
                $m->execute("update wechat.lichwq_users set status = '0' where openid = '$openid'");
            }


            if ($Event == 'subscribe') {
                $str2 = substr($EventKey, 8);
                echo "<xml>
            <ToUserName><![CDATA[$openid]]></ToUserName>
            <FromUserName><![CDATA[$wechatid]]></FromUserName>
            <CreateTime>1348831860</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <EventKey><![CDATA[V1001_TODAY_MUSIC]]></EventKey>
            <Content><![CDATA[被推荐关注本微信号,推荐人openid:'$str2']]></Content>
            </xml>";
                $this->kfmessage($str2, $openid);

                $filename = 'kk0428.txt';//双引号会换行 单引号不换行
                file_put_contents($filename, $str2);


            } else if ($Event == 'SCAN') {
                echo "<xml>
            <ToUserName><![CDATA[$openid]]></ToUserName>
            <FromUserName><![CDATA[$wechatid]]></FromUserName>
            <CreateTime>1348831860</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[您通过扫他人的二维码关注了王强的测试公众号!]]></Content>
            </xml>";
                $this->kfmessage($EventKey);
            }

            else if ($MsgType == 'voice') {
                echo "<xml>
            <ToUserName><![CDATA[$openid]]></ToUserName>
            <FromUserName><![CDATA[$wechatid]]></FromUserName>
            <CreateTime>1348831860</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[$Recognition]]></Content>
            </xml>";
                $this->kfmessage_voice($openid);
            }

            $this->erweima_shengcheng($openid);

        } else {

            $access_token = $this->access_token();

            define("TOKEN", "lichwq");
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $echostr = $_GET["echostr"];

            $token = TOKEN;
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode($tmpArr);
            $tmpStr = sha1($tmpStr);

            if ($tmpStr == $signature) {
                echo $echostr;
            } else {
                return false;
            }
        }
    }


    function access_token()
    {
        #验证access_token是否过期,如果过期就重新申请一个
        $m = M('wechat.users');
        $result = $m->query("select a.access_token from wechat.lichwq_token a INNER JOIN
        (select max(expires_in) expires_in from wechat.lichwq_token) b
        on a.expires_in=b.expires_in where now() <= DATE_ADD(b.expires_in,INTERVAL 7200 SECOND)");

        if ($result) {
            return $result[0]['access_token'];
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb30758ded991fa7e&secret=a1323e5743fe981a8a3dd8ab7b6b244b";
            $atjson = json_decode(file_get_contents($url));
            $access_token = $atjson->access_token;
            $expires_in = $atjson->expires_in;
            $m->execute("insert into wechat.lichwq_token(access_token,expires_in) values('$access_token',now())");
            $result = $m->query("select a.access_token from wechat.lichwq_token a INNER JOIN
            (select max(expires_in) expires_in from wechat.lichwq_token) b
            on a.expires_in=b.expires_in where now() <= DATE_ADD(b.expires_in,INTERVAL 7200 SECOND)");
            return $result[0]['access_token'];
        }
    }

    function erweima_shengcheng($openid)
    {
        header("Content-Type: Application/json; charset=utf-8");
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $this->access_token();
        $json = '{
    "action_name": "QR_LIMIT_STR_SCENE",
    "action_info": {
        "scene": {
            "scene_str": "' .
            $openid . '"
        }
    }
}';

        $m = M('wechat.users');
        $mysqlresult = $m->query("select * from wechat.lichwq_users where openid = '$openid'");
        if (isset($mysqlresult[0]['openid']) && !isset($mysqlresult[0]['ticket'])) {
            //        $headers = array("Content-Type: Application/json; charset=utf-8");
            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_HEADER, $headers);//设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $data = curl_exec($ch);//运行curl
            $result = json_decode($data, true);
            $kk = $result['ticket'];
            $m->execute("update wechat.lichwq_users set ticket='$kk' where openid = '$openid'");
            curl_close($ch);
        };
        $this->erweima_zhanshi($openid);
    }

    function erweima_zhanshi($openid)
    {
        header("Content-type: image/jpeg");
        $m = M('wechat.users');
        $mysqlresult = $m->query("select * from wechat.lichwq_users where openid = '$openid'");
        $ticket_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $mysqlresult[0]['ticket'];
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $ticket_url);//抓取指定网页
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);//运行curl
        curl_close($ch);
    }

    function huichuanceshi()
    {
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxb30758ded991fa7e&secret=a1323e5743fe981a8a3dd8ab7b6b244b&code=$code&grant_type=authorization_code ";
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        $openid = $result["openid"];
        file_put_contents('ceshi20160523.txt',$result);
        curl_close($ch);

        $this->erweima_shengcheng($openid);
    }


    function kfmessage($yaoqing_openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $this->access_token();
        $json = '{
       "touser":"' . $yaoqing_openid . '",
       "msgtype":"text",
       "text":
        {
         "content":"您已经推fsdfdsfsdfsdfsd!"
        }
        }';
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_HEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        var_dump($result);
        curl_close($ch);
    }


    function kfmessage_voice($yaoqing_openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $this->access_token();
        $json =
        //                  '{
//                      "touser":"'.$yaoqing_openid.'",
//    "msgtype":"text",
//    "text":
//    {
//        "content":"Hello World"
//    }
//}';
            '{
    "touser":"'.$yaoqing_openid.'",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"猎豹坦克歼击车",
             "description":"Is Really A Happy Day",
             "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb30758ded991fa7e&redirect_uri=www.baidu.com&response_type=code&scope=SCOPE&state=STATE#wechat_redirect",
             "picurl":"http://softools.richest007.com/public/images/liebao.jpg"
         },
         {
             "title":"88毫米炮猎豹",
             "description":"Is Really A Happy Day",
             "url":"URL",
             "picurl":"http://softools.richest007.com/public/images/liebao.jpg"
         },
                  {
             "title":"88毫米炮猎豹",
             "description":"Is Really A Happy Day",
             "url":"URL",
             "picurl":"http://softools.richest007.com/public/images/liebao.jpg"
         },
                  {
             "title":"88毫米炮猎豹",
             "description":"Is Really A Happy Day",
             "url":"URL",
             "picurl":"http://softools.richest007.com/public/images/liebao.jpg"
         },
                  {
             "title":"88毫米炮猎豹",
             "description":"Is Really A Happy Day",
             "url":"URL",
             "picurl":"http://softools.richest007.com/public/images/liebao.jpg"
         }

         ]
    }
}';


        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_HEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $data = curl_exec($ch);//运行curl

//        file_put_contents('ffffffff.txt',$json);

        $result = json_decode($data, true);
        curl_close($ch);
    }


    function medialist()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=2VDvEwGzAwu8i0k_3c8D2srMQtP8hYVvIyyjIoTY-3fGR8vrnrvQNypP7sLF_YXISlEfh-GqFAlzXdsdmaZoBXY3PiAoD6miulODm7VrFsQOH9w4rIg9BF2aChly7CK8QEYiAAACQK";
        $json = '{
         "type":"news",
         "offset":0,
         "count":10
         }';
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_HEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        var_dump($result);
        curl_close($ch);
    }


    function qunfa()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=2VDvEwGzAwu8i0k_3c8D2srMQtP8hYVvIyyjIoTY-3fGR8vrnrvQNypP7sLF_YXISlEfh-GqFAlzXdsdmaZoBXY3PiAoD6miulODm7VrFsQOH9w4rIg9BF2aChly7CK8QEYiAAACQK";
        $json = '{
   "touser":[
    "oCZAGwnQeDrpgHEyfGDWDaTgENT0",
    "oCZAGwjt4JxOlx7I5OWskJewr_6w"
   ],
   "mpnews":{
      "media_id":"CGMnleHnSC1ZFyvoh0sOTMXjvc8fegUEkMGPsGpRy_4"
   },
    "msgtype":"mpnews"
}';
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_HEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        var_dump($result);
        curl_close($ch);
    }

    function ceshi()
    {
        $kk = "qrscene_oFJwcxJ_ypr-Hw3idpuLHoDZ1ePs";
        echo substr($kk, 8);
    }


//    异常处理部分.
function yichang_qushu(){
    $keywords = $_GET['keywords'];
    $beilv = $_GET['beilv'];
    $wuye = $_GET['wuye'];
    $m = M('dmp_server.st_new_unusual_20160505');
        $mysqlresult = $m->execute("call dmp_server.0505_test_all_start('$keywords','$beilv')");
        $query = $m->query("select * from dmp_server.st_new_unusual_20160505");
        $query1 = $m->query("select a.date,a.to_left_center as 'center',a.to_left_left,a.left_f_m_minus,a.left_count_day,
        a.to_right_right,a.right_f_m_minus,a.right_count_day from dmp_server.st_new_unusual_points_analysis_20160505 a
        left join dmp_server.st_new_unusual_points_analysis_step2_left_20160505 b on a.date=b.center_date
        left join dmp_server.st_new_unusual_points_analysis_step2_right_20160505 c on a.date=c.center_date where a.date is not null;");
        $query2 = $m->query("select ifnull(b.center_date,c.center_date) as center_date,b.new_center_date as left_new_date,b.left_f_m_minus,b.left_count_day,c.new_center_date as right_new_date,c.right_f_m_minus,c.right_count_day from dmp_server.st_new_unusual_points_analysis_20160505 a
        left join dmp_server.st_new_unusual_points_analysis_step2_left_20160505 b on a.date=b.center_date
        left join dmp_server.st_new_unusual_points_analysis_step2_right_20160505 c on a.date=c.center_date where ifnull(b.center_date,c.center_date) is not null;");
         $query3 = $m->query("select num,substring(date,6,5) as date,tagname,
        one_day_count,
        case when unusual = 1 then '-' else one_day_count end as one_day_count_1,
        case when unusual = 1 then one_day_count else '-' end as one_day_count_2,
        three_avg_count,m_count,percent,unusual from dmp_server.st_new_unusual_20160505;");
         $query4 = $m->query("select * from (select * from report_display_shanghai.dw_keywords_relation where keywords='$keywords' and xg_keywords like '%$wuye%'
        order by count_userid desc limit 10) a
        union all
        (select * from report_display.dw_keywords_relation where keywords='$keywords' and xg_keywords like '%$wuye%'
        order by count_userid desc limit 10)");
        $result[0] = $query;
        $result[1] = $query1;
        $result[2] = $query2;
        $result[3] = $query3;
        $result[4] = $query4;

    if (!$result[0])
    {
        $this->ajaxReturn("n");
    }

        $this->ajaxReturn($result);
    }


    function yichang_map_shuju(){
        $s_date = $_GET['res'];
        $e_date = $_GET['res1'];
        $keywords = $_GET['res2'];
        $m = M('dmp_server.st_new_unusual_20160505');
//         $query = $m->query("select * from dmp_server.zuofei_ceshi_huodongzhong_20160512;");
//        $query1 = $m->query("select * from dmp_server.zuofei_ceshi_huodongqian_20160512;");
        $query2 = $m->query("select * from dmp_server.st_hightime;");
        $query3 = $m->query("select keywords,new_c_x,new_c_y,sum(count)/(DATEDIFF('$e_date','$s_date')+1) zhong_count from temp_05_13_ods_yichang_data_1 where keywords='$keywords'
        and date>='$s_date' and date<='$e_date'
        group by new_c_x,new_c_y order by sum(count) desc limit 10;");
        $query4 = $m->query("select a.keywords,a.new_c_x,a.new_c_y,zhong_count-qian_count from (select keywords,new_c_x,new_c_y,sum(count)/(DATEDIFF('$e_date','$s_date')+1) zhong_count from temp_05_13_ods_yichang_data_1 where keywords='$keywords'
        and date>='$s_date' and date<='$e_date'
        group by new_c_x,new_c_y order by sum(count)
        ) a
        left join
        (
        select keywords,new_c_x,new_c_y,sum(count)/7 qian_count from temp_05_13_ods_yichang_data_1 where keywords='$keywords'
        and date<='$s_date' and date>=DATE_ADD('$e_date',INTERVAL -7 day)
        group by new_c_x,new_c_y order by sum(count)
        ) b on a.keywords=b.keywords and a.new_c_x=b.new_c_x and a.new_c_y=b.new_c_y order by zhong_count-qian_count desc limit 10;");
//        $result[0] = $query;
//        $result[1] = $query1;
        $result[2] = $query2;
        $result[3] = $query3;
        $result[4] = $query4;
        $this->ajaxReturn($result);
    }


    function yichang_jinpin(){
        $keywords = $_GET['res2'];
        $m = M('dmp_server.st_new_unusual_20160505');
        $result[0]=$m->query("
        select * from  (select * from report_display_shanghai.dw_keywords_relation where keywords='$keywords'
order by count_userid desc limit 10) a
union all
(select * from report_display.dw_keywords_relation where keywords='$keywords'
order by count_userid desc limit 10)
;");
        $this->ajaxReturn($result);
    }

    function yushanghai_db(){
        $User = M('users','','mysql://lichwq:198982asd@139.196.153.101:3306/wechat');
        $result1 = $User->query("select * from wechat.users;");
        $result2 = $User->query("select * from wechat_test.openid2nick;");

        $kk = M('dmp_server.yushanghai_users');
        $kk->execute("delete from dmp_server.yushanghai_users;");
        $kk->addAll($result1);
        print_r($result1);
        $kk = M('dmp_server.yushanghai_users_openid2nick');
        $kk->execute("delete from dmp_server.yushanghai_users_openid2nick;");
        $kk->addAll($result2);
    }

    function uw_data_api(){
        $s_date = $_GET['stp'];
        $sss=time();
        $filename = "$sss$s_date.txt";//双引号会换行 单引号不换行
        file_put_contents($filename, $s_date);
        $m=M("dmp_server.st_new_unusual_20160505");
        $m->execute("call gdas_develop.uw_database_tigong_1");
    }

    function yichang_biaoge(){
        $k=M("dmp_server.st_new_unusual_20160505");
        $k->execute("call dmp_server.port_yichang_biaoge");
        $kk = $k->query("select substring(date,6,5) date from dmp_server.st_new_unusual_20160505");
        $kk1 = $k->query("select substring(date,6,5) date from dmp_server.port_yichang_biaoge;");
        $result[0] =$kk;
        $result[1] =$kk1;
        $this->ajaxReturn($result);
    }

    function yichang_biaoge_data(){
        $k=M("dmp_server.st_new_unusual_20160505");
        $k->execute("call dmp_server.port_yichang_biaoge");
        $kk = $k->query("select substring(date,6,5) date from dmp_server.st_new_unusual_20160505");
        $kk1 = $k->query("select substring(date,6,5) date from dmp_server.port_yichang_biaoge;");
        $result[0] =$kk;
        $result[1] =$kk1;
        $this->ajaxReturn($result);
    }

    function yichang_biaoge_guocheng(){
        $keywords = $_GET['keywords'];
        $beilv = $_GET['beilv'];
        $m = M('dmp_server.st_new_unusual_20160505');
        $m->execute("call dmp_server.0505_test_all_start('$keywords','$beilv')");
        $m->execute("insert into dmp_server.st_new_unusual_20160505_copy select * from dmp_server.st_new_unusual_20160505");
    }

    function yichang_data_new(){
        $k=M("dmp_server.st_new_unusual_20160505");
        $kk = $k->query("select num,substring(date,6,5) date,tagname,unusual from dmp_server.st_new_unusual_20160505_total");
        $kk1 = $k->query("select tagname,substring(date,6,5) date from dmp_server.port_yichang_biaoge");
        $kk2 = $k->query("select tagname,substring(date,6,5) date from dmp_server.port_yichang_blue");
        $result[0] =$kk;
        $result[1] =$kk1;
        $result[2] =$kk2;
        $this->ajaxReturn($result);
    }

    function yichang_jinpin_new(){
        $keywords = $_GET['res2'];
        $wuye = $_GET['wuye'];
        $m = M('dmp_server.st_new_unusual_20160505');
        $result[0]=$m->query("select '$keywords' as keywords,'$keywords' as xg_keywords,null as count_userid from dual
union all
(select * from report_display_shanghai.dw_keywords_relation where keywords='$keywords' and xg_keywords like '%$wuye%'
order by count_userid desc limit 10)
union all
(select * from report_display.dw_keywords_relation where keywords='$keywords' and xg_keywords like '%$wuye%'
order by count_userid desc limit 10)
;");
        $this->ajaxReturn($result);
    }

    function yichang_jinpin_data_total(){
        $keywords = $_GET['keywords'];
        $beilv = $_GET['beilv'];
        $wuye = $_GET['wuye'];
        $m = M('dmp_server.st_new_unusual_20160505');
        $m->execute("call dmp_server.port_total_first('$keywords','$beilv','$wuye')");
        $m->execute("call dmp_server.0505_test_all_start('$keywords','$beilv')");
        $kk[0] = $m->query("select * from dmp_server.st_new_unusual_20160505");
        $key[0]='no';
        if (!$kk[0])
        {
            $this->ajaxReturn($key);
        }
    }

    function test_20160524(){
        $m = M('dmp_server.st_new_unusual_20160505');
        $result = $m->query("select * from dmp_server.st_report_dashboard;");

        foreach ($result as $value) {
            if ($value['time']>='2015-08-14'&&$value['time']<='2015-09-14'){
            echo $value['time'].'&nbsp'.$value['count'].'<br />';
//                echo $value['time'];
            }
        }
//
//        $kk = array_search("2015-08-03",$result[0]);
//        print_r($result);

    }


//    public function yichang(){
////        $key = $_GET['key'];
////        if($key=='wanghui'){
//        $this->display();
////        }
////        else {
////            echo 'You have no right to view this page!';
////        }
//    }


    public function yichang_denglu(){
        $value = cookie('isdenglu');
        if ($value==3306){
            $this->display();
        }else{
            echo 'you are wrong!';
        }

//        if ($key==1){
//            $this->display();
//        }

    }

    public function yichang(){

        if(cookie('isdenglu')==3306)
        {
            $this->yichang_denglu($_SESSION['islogin']);
        }
        else {

            $u = I('Post.username');

            $p = I('Post.password');

            $data['username'] = $u;

            $data['password'] = md5($p);   //md5加密


            $m = M('login_user_test');

            $list = $m->where($data)->find();

            $cookie_key = cookie('isdenglu');

            if ($list) {

                $_SESSION['islogin'] = 1;           //登陆状态存入session

                cookie('isdenglu', '3306', 3600 * 24 * 1);

                $_SESSION['username'] = $list['username'];  //把用户名存入session

                $_SESSION['id'] = $list['id'];   //把用户id存入session

//            $this->redirect(sof/yichang($_SESSION['islogin']));

                $this->yichang_denglu($_SESSION['islogin']);

            } else {

                $this->error("账号或者密码不正确!", '/sof/login_test', 2);
//            $this->redirect(sof/login_test.html);

            }
        }

    }

    public function login_test(){
        cookie('isdenglu',null);
        $this->display();
    }


    public function sof_login(){
        cookie('isdenglu',null);
        $this->display();
    }

    public function sof_login_special(){
        cookie('isdenglu_special',null);
        cookie('keywords',null);
        $this->display();
    }

    public function work_order_tools()
    {
        if(cookie('isdenglu')==3306)
        {
            $this->display();

        }else{
            $this->error("账号或者密码不正确!", '/sof/sof_login', 2);
        }
    }


    function check_verify($code, $id = ''){
        $config = array(
            'reset' => false // 验证成功后是否重置，这里才是有效的。
        );
        $verify = new \Think\Verify($config);
        return $verify->check($code, $id);
    }



    public function yanzhengma(){

        $Verify =  new \Think\Verify();
        $Verify->fontSize = 50;
        $Verify->length   = 4;
        $Verify->useNoise = true;
        $Verify->entry();
    }

    public function check_login() {

            $u = I('Post.username');

            $p = I('Post.password');

            $data['username'] = $u;

            $data['password'] = md5($p);   //md5加密

            $u = I('Post.code');

        $Verify = new \Think\Verify();

        $king = $Verify->check($u);

            $m = M('login_user_test');

            $list = $m->where($data)->find();

            if ($list&&$king) {

                $_SESSION['islogin'] = 1;           //登陆状态存入session

                cookie('isdenglu', '3306', 3600 * 24 * 1);

                $_SESSION['username'] = $list['username'];  //把用户名存入session

                $_SESSION['id'] = $list['id'];   //把用户id存入session

                $this->display('sof_home');

            } else {

                $this->error("账号或者密码或者验证码不正确!", '/sof/sof_login', 2);

            }
    }


    public function check_login_special(){

        $u = I('Post.username');

        $p = I('Post.password');

        $data['username'] = $u;

        $data['password'] = $p;


        $m = M('test_backup.user_permission');

        $list = $m->where($data)->find();

//            $cookie_key = cookie('isdenglu');

        if ($list) {

            $_SESSION['isdenglu_special'] = 1;           //登陆状态存入session

//            print_r($list['project']);

            cookie('isdenglu_special', '3305', 3600 * 24 * 1);

            cookie('keywords', $list['project'], 3600 * 24 * 1);

            $_SESSION['username'] = $list['username'];  //把用户名存入session

            $_SESSION['id'] = $list['id'];   //把用户id存入session

            $this->display('sof_home_special');

        } else {

            $this->error("账号或者密码不正确!", '/sof/sof_login_special', 2);
//            $this->redirect(sof/login_test.html);
        }
    }


    public function sof_register(){
        $this->display();
    }

    public function sof_register_ruku(){
        $m = M('login_user_test');
        $name = $_POST['username'];
        $passwd = $_POST['password'];
        $yaoqingma = $_POST['yaoqingma'];

        $result[0]=$m->query("select username from dmp_server.login_user_test where username='$name'");

        if($result[0]){
            $this->error("对不起,此帐号已经被注册过!请重新注册!", '/sof/sof_register', 3);
        }
       else if($yaoqingma=='sof_lichwq') {
            $m->execute("insert into dmp_server.login_user_test (username,password,details) values('$name',md5('$passwd'),'$passwd');");
           $this->success('恭喜你,注册成功!请登录!', '/sof/sof_login', 3);
        }
       else if($yaoqingma!=='sof_lichwq'){
           $this->error("对不起,邀请码不正确!请联系上富科技!", '/sof/sof_register', 3);
        }
    }



    function yush_fangsir()
    {
        $code = $_GET['code'];
//        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxb30758ded991fa7e&secret=a1323e5743fe981a8a3dd8ab7b6b244b&code=$code&grant_type=authorization_code ";
//        $ch = curl_init();//初始化curl
//        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        $data = curl_exec($ch);//运行curl
//        $result = json_decode($data, true);
//        $openid = $result["openid"];
//        file_put_contents('ceshi20160523.txt',$result);
//        curl_close($ch);
        echo $code;
    }

    function wzy_getOrderList(){
        $m = M('login_user_test');
        $result = $m->query("select distinct project from test_backup.top10;");
        $this -> ajaxReturn($result);
    }


    function wzy_getUser(){
        $m = M('login_user_test');
        $result = $m->query("select * from test_backup.user_permission;");
        $this -> ajaxReturn($result);
    }


    function wzy_createuser(){
        $m = M('login_user_test');
        $user=$_GET['name'];
        $pwd=$_GET['pwd'];
        $project=$_GET['project'];

        $m->execute("delete from test_backup.user_permission where username='$user'");

        $sql= 'insert into test_backup.user_permission
        (`username`,`password`,`project`) values ("'."$user".'"'.','.'"'."$pwd".'"'.','.'"'."$project".'"'.')';


        $king = $m->execute($sql);
        if($king)
        {
            $result['message'] = '恭喜你,用户录入成功!';
        }else{
            $result['message'] = '对不起,用户录入失败!';
        }



        $this->ajaxReturn($result);
    }

    public function shiwu_people_data(){
        $key = $_GET['keywords'];
        $m = M('login_user_test');
        $result = $m->query("(select * from report_display.st_soc_people_event_analysis_total where dick='$key')
union all (select * from report_display_shanghai.st_soc_people_event_analysis_total where dick='$key')");
        $this -> ajaxReturn($result);
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
        $result = $user->query("select a.keywords,case when b.keywords is not null then '有' else '没有' end is_trade from report_display_shanghai.st_10_5_20160719_test_list a
        left JOIN
        (select distinct keywords from report_display_shanghai.ods_trade_keywords_square where date>=DATE_ADD(now(),INTERVAL -50 day)) b
        on a.keywords=b.keywords");
        $this->ajaxReturn($result);
    }


    public function businss_assessment_ex_status()
    {
        $is_query = $_GET['is_query'];
        $beilv = $_GET['beilv'];
        $wuye = $_GET['wuye'];
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        if($is_query==1) {
            $result = $user->query("select * from report_display_shanghai.dim_status_assessment;");
            $this->ajaxReturn($result);
        }elseif($is_query==0){
            $user->execute("delete from report_display_shanghai.dim_status_assessment;");
            $user->execute("insert into report_display_shanghai.dim_status_assessment (status) select '0' from dual;");
        }
    }

    public function businss_assessment_exe_data()
    {
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $user->execute("delete from report_display_shanghai.dim_status_assessment;");
        $user->execute("insert into report_display_shanghai.dim_status_assessment (status)
        select '1' from dual;");
        $user->execute("call report_display_shanghai.20160719_new_experiment_start;");
        $user->execute("delete from report_display_shanghai.dim_status_assessment;");
        $user->execute("insert into report_display_shanghai.dim_status_assessment (status)
        select '0' from dual;");
    }


    public function workorder_count()
    {
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $result =  $user->query("select count(distinct project) count from test_backup.people_event_plus;");
        $this->ajaxReturn($result[0]);
    }

    public function queren_shanchu()
    {
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $user->execute("call test.delete_all_backup;");
    }

    public function click_data_port()
    {
        $keywords = $_GET['keywords'];
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $result = $user->query("SELECT substring_index(projectname,'-',-1) as 'keywords',policyname as 'name',count(*) 'value' from dmp_server.st_hangzhou_put_report_data
        where projectname<>'NULL' and projectname like '%$keywords%'
        GROUP BY projectname,policyname;");
        $this->ajaxReturn($result);
    }


        public function click_data_port2(){
            $keywords = $_GET['keywords'];
            $user = M("report_display_shanghai.st_10_5_20160719_test_list");
            $result = $user->query("SELECT substring_index(projectname,'-',-1),district as 'name',count(*) value from dmp_server.st_hangzhou_put_report_data
where substring_index(projectname,'-',-1) like '%$keywords%' and district<>'NULL'
GROUP BY projectname,district;");
            $this->ajaxReturn($result);

    }


    public function click_data_port3(){
        $keywords = $_GET['keywords'];
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $result_king = $user->query("SELECT substring_index(projectname,'-',-1),policyname,district as 'name',count(*) as 'value' from
dmp_server.st_hangzhou_put_report_data where substring_index(projectname,'-',-1) like '%$keywords%' and district<>'NULL'
GROUP BY substring_index(projectname,'-',-1),policyname,district;");
        $king2 = array_values(array_unique(array_column($result_king, 'policyname')));

        for ($n = 0; $n < count($king2); $n++) {
            for ($c = 0; $c < count($result_king); $c++) {
                if($king2[$n]==$result_king[$c]['policyname']){
                    $kkkk[$n][]=$result_king[$c];
                }
            }
        }
        $this->ajaxReturn($kkkk);
    }

    public function click_data_port4(){
        $keywords = $_GET['keywords'];
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $result[1] = $user->query("SELECT substring_index(project,'-',-1),sex as 'name',count(DISTINCT ad) as 'value' FROM gdas_adv.hz_click_property_data
where substring_index(project,'-',-1) like '%$keywords%' and
sex<>'' and sex is not null
GROUP BY substring_index(project,'-',-1),sex;
");

        $result[2] = $user->query("SELECT substring_index(project,'-',-1),age as 'name',count(DISTINCT ad) as 'value' FROM gdas_adv.hz_click_property_data
where substring_index(project,'-',-1) like '%$keywords%' and
age<>'' and age is not null  GROUP BY substring_index(project,'-',-1),age;");
        $this->ajaxReturn($result);
    }

    public function click_data_port5(){
        $keywords = $_GET['keywords'];
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $result = $user->query("SELECT substring_index(project,'-',-1),behavior1 as 'name',count(DISTINCT ad),sum(times), replace(format(count(DISTINCT ad)*sqrt(sqrt(sum(times))),0),',','') as 'value'
FROM gdas_adv.hz_click_tags_data
WHERE project IS NOT NULL and substring_index(project,'-',-1) like '%$keywords%'
GROUP BY substring_index(project,'-',-1),behavior1;
");
        $this->ajaxReturn($result);
    }

    public function click_data_port6(){
        $keywords = $_GET['keywords'];
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");
        $user->query("set @i=0;");
        $result = $user->query("select @i:=@i+1 as 'rank',substring_index(projectname,'-',-1) as 'projectname',details,count as 'hot',c_x,c_y from (
SELECT projectname,details,count(*) count,c_x,c_y from dmp_server.st_hangzhou_put_report_data
where substring_index(projectname,'-',-1) like '%$keywords%' and details<>'NULL' GROUP BY projectname,details
order by count(*) desc) a limit 200;");
        $this->ajaxReturn($result);
    }

    public function some_keywords_jingpin(){
        $c_x = $_GET['c_x'];
        $keywords = $_GET['keywords'];
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $result = $User->query("select rel_tagname as 'keywords' from dw_basic_user_tagname_rel_relation_converge where tagname='$keywords'
        and rel_indname='房产-新房' and rel_typename='上海楼盘'  and rel_tagname like concat('%',SUBSTR('$keywords',-2),'%')
        order by rel_count desc limit 30;");
        $this->ajaxReturn($result);
    }


    public function xq_circle_map_tools_port()
    {

        $key = $_GET['benan_loupan'];
        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $result = $User -> query("select distinct c_x,c_y,count_paixu from (select '$key' as keywords,a.* from
(select a.c_x,a.c_y,b.count_userid,SQRT( (a.c_x-b.c_x)*(a.c_x-b.c_x)+(a.c_y-b.c_y)*(a.c_y-b.c_y) )  distance,count_paixu  from (
select c_x,c_y,sum(view_count) count_paixu from new_subscribe.dw_basic_user_converge_buildings_day
where tagname='$key' and c_x is not null GROUP BY c_x,c_y order by sum(view_count) desc limit 15
) a left join
dmp_server.xy_test_20160808 b
on 1=1 ) a where  distance <=0.005) a;");
//        print_r($shuzu);
        $this->ajaxReturn($result);
    }


    public function xq_circle_map_tools_dashboard_port()
    {
        $c_x = $_GET['c_x'];
        $c_y = $_GET['c_y'];


        $shuzu = '('.substr($_GET['keywords_shuzu'],1).')';


        $keywords = $_GET['keywords'];
        $benan = $_GET['benan_key'];


        $pwd = 'gdas.developer';
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $result[0] = $User -> query("select sum(count_userid) total_user_count from (select '$benan' as keywords,a.* from
(select a.c_x,a.c_y,b.count_userid,SQRT( (a.c_x-b.c_x)*(a.c_x-b.c_x)+(a.c_y-b.c_y)*(a.c_y-b.c_y) )  distance  from (
select c_x,c_y from new_subscribe.dw_basic_user_converge_buildings_day
where tagname='$benan' and c_x is not null and c_x='$c_x' and c_y='$c_y' GROUP BY c_x,c_y order by sum(view_count) desc limit 15
) a left join dmp_server.xy_test_20160808 b on 1=1 ) a where  distance <=0.005) a;");

        $result[1] = $User -> query("select sum(count_userid) total_user_count from (
select '$benan' as keywords,a.* from
(select a.c_x,a.c_y,b.count_userid,SQRT( (a.c_x-b.c_x)*(a.c_x-b.c_x)+(a.c_y-b.c_y)*(a.c_y-b.c_y) )  distance  from (
select c_x,c_y from new_subscribe.dw_basic_user_converge_buildings_day where tagname ='$benan' and c_x is not null and c_x='$c_x' and c_y='$c_y' GROUP BY c_x,c_y order by sum(view_count) desc limit 15
) a left join
(select c_x,c_y,sum(count_userid) as 'count_userid' from dmp_server.xy_tag_test_20160808 where tagname='$benan'  group by c_x,c_y) b
on 1=1 ) a where distance <=0.005) a;");

        $result[2] = $User -> query("select sum(count_userid) total_user_count from (select '$benan' as keywords,a.* from
(select a.c_x,a.c_y,b.count_userid,SQRT( (a.c_x-b.c_x)*(a.c_x-b.c_x)+(a.c_y-b.c_y)*(a.c_y-b.c_y) )  distance  from (
select c_x,c_y from new_subscribe.dw_basic_user_converge_buildings_day where tagname ='$benan' and c_x='$c_x' and c_y='$c_y' and c_x is not null GROUP BY c_x,c_y order by sum(view_count) desc limit 15
) a left join
(select c_x,c_y,sum(count_userid) as 'count_userid' from dmp_server.xy_tag_test_20160808 where tagname<>'$benan' and tagname in $shuzu group by c_x,c_y) b
on 1=1 ) a where  distance <=0.005) a;");

        $result[3] = $User -> query("select tagname as 'name',sum(count_userid) as 'value' from
    (select a.c_x,a.c_y,tagname,b.count_userid,SQRT( (a.c_x-b.c_x)*(a.c_x-b.c_x)+(a.c_y-b.c_y)*(a.c_y-b.c_y) ) distance  from
    (select '$c_x' as 'c_x','$c_y' as 'c_y' from dual) a
left join
    (select c_x,c_y,tagname,count_userid
from dmp_server.xy_tag_test_20160808) b
on 1=1 ) a where distance <=0.005 group by tagname order by sum(count_userid) desc limit 20;");

        $result[4] = array_column($result[3], 'name');
        $user = M("report_display_shanghai.st_10_5_20160719_test_list");

        $result[5] = $user->query("call dmp_server.dim_environment('$c_x','$c_y','500')");

        $this->ajaxReturn($result);
    }

    public function new_people_select_port(){
        $pwd = 'gdas.developer';
        $benan = $_GET['chaoxiang'];
        $User = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
        $port_result =  $User->query("select count(*) count from new_subscribe.dw_basic_user_converge_day where $benan");
        $this->ajaxreturn($port_result);
    }


    public function new_people_select_dim_port(){
        $User = M("report_display_shanghai.st_10_5_20160719_test_list");
        $port_result =  $User->query("select indname,typename,tagname from dim_media_tagdic_org_ind
where typename in ('朝向','上海楼盘','单价','总价','区域','地铁','户型','面积','装修')");

        $result['typename'] =
            array_values(array_unique
            (
            array_column($port_result, 'typename')
            )
        );

        $king = [];

        for($i = 0;$i < count($result['typename']);$i++) {

            $k = 0;

            for($m = 0;$m < count($port_result);$m++) {
                if($port_result[$m]['typename'] == $result['typename'][$i]){
                    $king[$i][$k]['indname'] = $port_result[$m]['indname'];
                    $king[$i][$k]['typename'] = $port_result[$m]['typename'];
                    $king[$i][$k]['tagname'] = $port_result[$m]['tagname'];
                    $k = $k+1;
                }
            }
        }


        $this->ajaxreturn($king);
    }



    public function new_people_select_final_port(){

        $res[0] = $_GET['res'];

        $arr = explode(" and ",$res[0]);

        $result = [];

        foreach($arr as $u){

            $strarr = explode("，",$u);

            foreach($strarr as $newstr){

                $result[] = $newstr;

            }
        }

        $total_sql  = '';

        for($n=0;$n < count($result);$n++){

            $sql = 'select userid from new_subscribe.dw_basic_user_converge_day where ';

            $total_sql = $sql.$result[$n].' union all '.$total_sql ;
        }

        $kk[0] = substr($total_sql,0,strlen($total_sql)-11);




//        $pwd = 'gdas.developer';
//        $User_1 = M('dim_top8_typename', '', "mysql://developer:$pwd@127.0.0.1:3100/new_subscribe");
//        $port_result =  $User_1->query("");



        $User = M("report_display_shanghai.st_10_5_20160719_test_list");
        $port_result =  $User->query("select indname,typename,tagname from dim_media_tagdic_org_ind
where typename in ('朝向','上海楼盘','单价','总价','区域','地铁','户型','面积','装修')");

        $this->ajaxReturn($kk);

    }

}