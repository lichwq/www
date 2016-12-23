<?php
namespace Softools\Controller;

use Think\Controller;
use Think;

ignore_user_abort();
set_time_limit(0);

class Echarts360Controller extends Controller

{
    public function index()
    {
        #你好啊
        $this->ajaxReturn("fdsffs");
    }

    public function autotalk()
    {
    $msg = $_GET['text'];
    //URL中的参数：
    // sandbox.api.simsimi.com/request.p 是试用账号的API
    // key : 用户秘钥，这里是试用秘钥100次请求/天
    // ft : 是否过滤骂人的词汇
    // lc : 语言设置
    // text : 发送信息
    $url = 'http://api.douqq.com/?key=MVlYRnl4QTA9RjVCPXdsQVY1VUxmcVNQMGd3QUFBPT0&msg='.$msg;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:12.0) Gecko/20120101 Firefox/17.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
    $res = curl_exec($ch);
    curl_close($ch);
    echo $res;
    }

    public function json_test_seek(){
        header('Content-Type:text/html; charset=utf-8');
        for($ff=79;$ff<=99;$ff++) {

            unlink('20161027_test_basic_'.$ff.'.txt');
            unlink('20161027_test_edu_'.$ff.'.txt');
            unlink('20161027_test_occupations_'.$ff.'.txt');
            unlink('20161027_test_internships_'.$ff.'.txt');
            unlink('20161027_test_projects_'.$ff.'.txt');

            $file = fopen("$ff", "r");
// 读取第一行
            $basic = fopen('20161027_test_basic_'.$ff.'.txt', "a");
            $edu = fopen('20161027_test_edu_'.$ff.'.txt', "a");
            $occupations = fopen('20161027_test_occupations_'.$ff.'.txt', "a");
            $internships = fopen('20161027_test_internships_'.$ff.'.txt', "a");
            $projects = fopen('20161027_test_projects_'.$ff.'.txt', "a");

            $i = 0;

            fwrite($basic, 'version' . "\t" .
                'URL' . "\t" .
                'status_code' . "\t" .
                'status_msg' . "\t" .
                'industries' . "\t" .
                'expect_locations' . "\t" .
                'expect_salary_upper' . "\t" .
                'expect_salary' . "\t" .
                'expect_titles' . "\t" .
                'expect_salary_floor' . "\t" .
                'update_time' . "\t" .
                'skills' . "\t" .
                'mobile' . "\t" .
                'qq' . "\t" .
                'email' . "\t" .
                'certifications' . "\t" .
                'extract' . "\t" .
                'name' . "\t" .
                'id_number' . "\t" .
                'gender' . "\t" .
                'nation' . "\t" .
                'birthyear' . "\t" .
                'birthday' . "\t" .
                'work_experience' . "\t" .
                'upper' . "\t" .
                'current_salary' . "\t" .
                'floor' . "\t" .
                'province' . "\t" .
                'city' . "\t" .
                'self_evaluate' . "\t" .
                'language' . "\n");

            fwrite($edu, 'URL' . "\t" .
                'major' . "\t" .
                'degree' . "\t" .
                'not_ended' . "\t" .
                'school' . "\t" .
                'start_time' . "\t" .
                'end_time' . "\n");


            fwrite($occupations, 'URL' . "\t" .
                'title' . "\t" .
                'start_time' . "\t" .
                'not_ended' . "\t" .
                'end_time' . "\t" .
                'company' . "\t" .
                'desc' . "\t" .
                'industry' . "\n");


            fwrite($internships, 'URL' . "\t" .
                'start_month' . "\t" .
                'start_year' . "\t" .
                'description' . "\t" .
                'title' . "\t" .
                'end_year' . "\t" .
                'company' . "\t" .
                'not_ended' . "\t" .
                'end_month' . "\t" .
                'industry' . "\n");


            fwrite($projects, 'URL' . "\t" .
                'start_month' . "\t" .
                'start_year' . "\t" .
                'name' . "\t" .
                'end_year' . "\t" .
                'not_ended' . "\t" .
                'end_month' . "\t" .
                'post' . "\t" .
                'desc' . "\n");

            while (!feof($file)) {
                $str2 = fgets($file);
                $str2 = preg_replace('/,\s*([\]}])/m', '$1', $str2);

                $str2 = str_replace('\n', '', $str2);
                $str2 = str_replace("\t", '', $str2);
                $str2 = str_replace("\n", '', $str2);

                $final = json_decode(trim($str2, chr(239) . chr(187) . chr(191)), true);

                $expect_locations = '';

                for ($cc = 0; $cc < count($final['cv_parse']['job_objective']['expect_locations']); $cc++) {
//                $expect_locations = '';
                    $expect_locations = $final['cv_parse']['job_objective']['expect_locations'][$cc]['province'] .
                        $final['cv_parse']['job_objective']['expect_locations'][$cc]['city'] . ',' . $expect_locations;

                    $expect_locations = rtrim($expect_locations, ",");
                }

                $certifications = '';

                for ($cc1 = 0; $cc1 < count($final['cv_parse']['certificates']['certifications']); $cc1++) {
//                $expect_locations = '';
                    $certifications = $final['cv_parse']['certificates']['certifications'][$cc1] .
                        ',' . $certifications;

                    $certifications = rtrim($certifications, ",");
                }

                $extract = '';

                for ($cc2 = 0; $cc2 < count($final['cv_parse']['certificates']['extract']); $cc2++) {
//                $expect_locations = '';
                    $extract = $final['cv_parse']['certificates']['extract'][$cc2] .
                        ',' . $extract;

                    $extract = rtrim($extract, ",");
                }

//            echo $extract.'</br>';

//            echo $certifications.'</br>';

//            echo $expect_locations.'</br>';

                $base_info =
                    $final['version'] . "\t" .
                    $final['URL'] . "\t" .
                    $final['cv_parse']['job_objective']['status']['status_code'] . "\t" .
                    $final['cv_parse']['job_objective']['status']['status_msg'] . "\t" .
                    $final['cv_parse']['job_objective']['industries'] . "\t" .
                    $expect_locations . "\t" .
                    $final['cv_parse']['job_objective']['expect_salary_upper'] . "\t" .
                    $final['cv_parse']['job_objective']['expect_salary'] . "\t" .
                    $final['cv_parse']['job_objective']['expect_titles'] . "\t" .
                    $final['cv_parse']['job_objective']['expect_salary_floor'] . "\t" .
                    $final['cv_parse']['update_time'] . "\t" .
                    $final['cv_parse']['skills']['skills'][0] . "\t" .
                    $final['cv_parse']['contact']['mobile'] . "\t" .
                    $final['cv_parse']['contact']['qq'] . "\t" .
                    $final['cv_parse']['contact']['email'] . "\t" .
                    $certifications . "\t" .
                    $extract . "\t" .
                    $final['cv_parse']['basic_info']['name'] . "\t" .
                    $final['cv_parse']['basic_info']['id_number'] . "\t" .
                    $final['cv_parse']['basic_info']['gender'] . "\t" .
                    $final['cv_parse']['basic_info']['nation'] . "\t" .
                    $final['cv_parse']['basic_info']['birthyear'] . "\t" .
                    $final['cv_parse']['basic_info']['birthday'] . "\t" .
                    $final['cv_parse']['basic_info']['work_experience'] . "\t" .
                    $final['cv_parse']['basic_info']['current_yearsalary']['upper'] . "\t" .
                    $final['cv_parse']['basic_info']['current_yearsalary']['current_salary'] . "\t" .
                    $final['cv_parse']['basic_info']['current_yearsalary']['floor'] . "\t" .
                    $final['cv_parse']['basic_info']['location']['province'] . "\t" .
                    $final['cv_parse']['basic_info']['location']['city'] . "\t" .
                    $final['cv_parse']['self_evaluate'] . "\t" .
                    $final['cv_parse']['languages']['language'][0] . "\n";

                for ($k = 0; $k < count($final['cv_parse']['educations']); $k++) {
                    $king_2 =
                        $final['URL'] . "\t" .
                        $final['cv_parse']['educations'][$k]['major'] . "\t" .
                        $final['cv_parse']['educations'][$k]['degree'] . "\t" .
                        $final['cv_parse']['educations'][$k]['not_ended'] . "\t" .
                        $final['cv_parse']['educations'][$k]['school'] . "\t" .
                        $final['cv_parse']['educations'][$k]['start_time'] . "\t" .
                        $final['cv_parse']['educations'][$k]["end_time"] . "\n";
                    fwrite($edu, $king_2);
                }

                for ($k3 = 0; $k3 < count($final['cv_parse']['occupations']); $k3++) {
                    $king_3 =
                        $final['URL'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]['title'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]['start_time'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]['not_ended'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]['end_time'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]['company'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]['desc'] . "\t" .
                        $final['cv_parse']['occupations'][$k3]["industry"] . "\n";
                    fwrite($occupations, $king_3);
                }

//internships输出,目前有问题.

                for ($k4 = 0; $k4 < count($final['cv_parse']['internships']); $k4++) {
                    $king_4 =
                        $final['URL'] . "\t" .
                        $final['cv_parse']['internships'][$k4]['start_month'] . "\t" .
                        $final['cv_parse']['internships'][$k4]['start_year'] . "\t" .
                        $final['cv_parse']['internships'][$k4]['description'] . "\t" .
                        $final['cv_parse']['internships'][$k4]['title'] . "\t" .
                        $final['cv_parse']['internships'][$k4]['end_year'] . "\t" .
                        $final['cv_parse']['internships'][$k4]['company'] . "\t" .
                        $final['cv_parse']['internships'][$k4]["not_ended"] . "\t" .
                        $final['cv_parse']['internships'][$k4]["end_month"] . "\t" .
                        $final['cv_parse']['internships'][$k4]["industry"] . "\n";
                    fwrite($internships, $king_4);
                }

                //输出project

                for ($k5 = 0; $k5 < count($final['cv_parse']['projects']); $k5++) {
                    $king_5 =
                        $final['URL'] . "\t" .
                        $final['cv_parse']['projects'][$k5]['start_month'] . "\t" .
                        $final['cv_parse']['projects'][$k5]['start_year'] . "\t" .
                        $final['cv_parse']['projects'][$k5]['name'] . "\t" .
                        $final['cv_parse']['projects'][$k5]['end_year'] . "\t" .
                        $final['cv_parse']['projects'][$k5]['not_ended'] . "\t" .
                        $final['cv_parse']['projects'][$k5]['end_month'] . "\t" .
                        $final['cv_parse']['projects'][$k5]["post"] . "\t" .
                        $final['cv_parse']['projects'][$k5]["desc"] . "\n";
                    fwrite($projects, $king_5);
                }

//            var_dump($final['cv_parse']['certificates']);

//           echo serialize($final['cv_parse']['certificates']['certifications']);

                fwrite($basic, $base_info);
                $i = $i + 1;
            }

            fclose($file);
            fclose($basic);
            fclose($edu);
            fclose($occupations);
            fclose($internships);
            fclose($projects);
        }
        echo "转换完成!!";
    }


    public function json_test()
    {
        ini_set('memory_limit', '-1');
        header('Content-Type:text/html; charset=utf-8');
        $str2 = file_get_contents('jianli.json');

        $ex1 = explode('
',$str2);

        $filename = '20161027_test_basic.txt';
        $fh = fopen($filename, "a");
        for($i=0;$i<count($ex1);$i++){
            $str2 = $ex1[$i];

        $str2 = preg_replace('/,\s*([\]}])/m', '$1', $str2);

        $str2 = str_replace('\n', '', $str2);

            $kh = fopen('20161027_test_edu.txt', "a");


        $final = json_decode(trim($str2,chr(239).chr(187).chr(191)),true);

            //基础信息输出
            $king_1 = $final['URL']."\t".$final['cv_parse']['contact']['mobile']."\t".$final['cv_parse']['basic_info']['name']."\t".$final['cv_parse']['basic_info']['gender']."\t".$final['cv_parse']['basic_info']['birthday']."\t".$final['cv_parse']['languages']['language'][0]."\n";
//            echo  $king_1;

            if (count($final['cv_parse']['skills']['skills'])>0) {
               echo $final['cv_parse']['skills']['skills'][0].'</br>';
           };
            fwrite($fh, $king_1);

            for($k=0;$k<count($final['cv_parse']['educations']);$k++){
              $king_2  =  $final['URL']."\t".$final['cv_parse']['educations'][$k]['major']."\t".$final['cv_parse']['educations'][$k]['degree']."\t".$final['cv_parse']['educations'][$k]['school']."\t".$final['cv_parse']['educations'][$k]['start_time']."\t".$final['cv_parse']['educations'][$k]["end_time"]."\n";
                fwrite($kh, $king_2);
            }
        }

        fclose($fh);
        fclose($kh);
    }


    public function longpoll_test()
    {

        function getallheaders()
        {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers [str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }

        $request = getallheaders();
        $request_id = $request['Request-Id'];
        $ch = curl_init();

        $request_id = "Request-Id: $request_id";

// 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, "172.16.1.123/Public/graph.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        usleep(1000000*1);//1000000为1秒
        header($request_id);
        echo (curl_exec($ch));
//        $king = curl_exec($ch);
    }

    public function zechuan_demo(){

        header("Content-type:text/html;charset=utf-8");

        function getallheaders()
        {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers [str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }

        $O_json  = file_get_contents("php://input");

        $arr_json = json_decode($O_json,true);


        $arr_json['payload']['nodeName'];
        $arr_json['payload']['nodeCategory'];

        $arr_json['timestamp'];


        $request = getallheaders();
        $request_id = $request['Request-Id'];
        $request_id = "Request-Id: $request_id";

        // 创建一个新cURL资源
        $ch = curl_init();
        $data = '{"apiName":"test","caller": "core", "timestamp": "'.$arr_json['timestamp'].'", "token": "hello",
    "payload": {
    "nodeName": "'.$arr_json['payload']['nodeName'].'",
    "nodeCategory": "'.$arr_json['payload']['nodeCategory'].'"
    }
        }';

//        $data = '{"apiName":"test","caller": "core", "timestamp": 2471777659530, "token": "hello",
//"payload": {
//    "nodeName": "zhangsanfeng",
//    "nodeCategory": "PERSON"
//    }
//}';


        curl_setopt($ch, CURLOPT_URL, "http://172.16.1.123:8080/api/person/graph");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json',
            'Accept: application/json',
            $request_id]);
//        echo $request_id;
        header($request_id);
        curl_exec($ch);
//        curl_close($ch);
    }



    public function longpoll_demo()
    {
        if(empty($_POST['time'])) exit();
        set_time_limit(0);//无限请求超时时间
        $i=0;
        while (true){
            //sleep(1);
            usleep(500000);//0.5秒
            $i++;
            //若得到数据则马上返回数据给客服端，并结束本次请求
            $rand=rand(1,999);
            if($rand<=15){
                $arr=array('success'=>"1",'name'=>'xiaocai','text'=>$rand);
                echo json_encode($arr);
                exit();
            }
            //服务器($_POST['time']*0.5)秒后告诉客服端无数据
            if($i==$_POST['time']){
                $arr=array('success'=>"0",'name'=>'xiaocai','text'=>$rand);
                echo json_encode($arr);
                exit();
            }
            }
    }


}