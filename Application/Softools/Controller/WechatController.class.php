<?php
namespace Softools\Controller;

use Think\Controller;
use Think;

ignore_user_abort();
set_time_limit(0);

class WechatController extends Controller
{

    public function wechat_access_token(){
        $url = "http://mobile.fangsir007.com/wechat/token.do";
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
//        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);//运行curl
//        echo $data;
        return $data;
    }


    function wechat_group()
    {
//        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=8hmLCtI0OoIEwPABnDmoYl-RCd-zu2mQ2Rn4jVkGNwTX1InsX6xjOYmnieu5h2ewQ3hEhDf5pAUMxu05UorG-pdAgms3U9jzOMEa1T_4S-U_61JMwiM-A1Ov6S1MRnJAGUBcABAPDK";
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        $openid = $result["openid"];
        file_put_contents('wechat_group.txt',$data);
        curl_close($ch);
    }

    function wechat_all_user($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token."&next_openid=";
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        $openid = $result["openid"];
//        file_put_contents('wechat_all_user.txt',$result);
        curl_close($ch);
        $kk = M('report_display.goufang_sls_wechat_users');
        $kk->execute("truncate table report_display.goufang_sls_wechat_users;");
        foreach ($result["data"]["openid"] as $value) {
            $kk->execute("insert into report_display.goufang_sls_wechat_users(openid) values('$value');");
        }
        $this->tag_user($access_token);
    }

    function tag_user($access_token)
    {
        $json = '{
  "tagid" : 104,
  "next_openid":
}';

        $url = "https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=".$access_token;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
        $openid = $result["openid"];
//        file_put_contents('tag_user.txt',$data);
        curl_close($ch);
        print_r($data);
        $kk = M('report_display.goufang_sls_wechat_users');

        $groupname = '上富工单组';

        foreach ($result["data"]["openid"] as $value) {
            $kk->execute("update report_display.goufang_sls_wechat_users set groupname='$groupname',groupid=104 WHERE openid='$value'");
        }
    }


    function fa_start_message($keywords){
        $kk = M('report_display.goufang_sls_wechat_users');

        $access_token = $this->wechat_access_token();

        $resutl=$kk->query("select openid from report_display.goufang_sls_wechat_users where groupid=104");

        $title = "工单:'$keywords'开始执行,预计时间一小时!";

        $this->wechat_all_user($access_token);


        $i=0;

        $pircure='start_message.jpg';

        foreach($resutl as $value){
            $king=$value["openid"];
            $this->kfmessage_gongdan($king,$access_token,$pircure,$title);
            $i=$i+1;
        }
    }

    function fa_end_message($keywords){
        $kk = M('report_display.goufang_sls_wechat_users');

        $access_token = $this->wechat_access_token();

        $resutl=$kk->query("select openid from report_display.goufang_sls_wechat_users where groupid=104");

        $this->wechat_all_user($access_token);

        $i=0;
        $title = "工单:'$keywords'已经结束,请联系相关人员取出!";

        $pircure='zhongbangxiaoxi.jpg';

        foreach($resutl as $value){
            $king=$value["openid"];
            $this->moban_message($king,$keywords,$access_token);
            $i=$i+1;
        }
    }

    function kfmessage_gongdan($openid,$access_token,$picture,$title)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
        $json ='{
        "touser":"'.$openid.'",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"'.$title.'",
             "description":"详情请点击-_-!",
             "url":"http://softools.richest007.com/index.php/wechat/wechat_report_click",
             "picurl":"http://softools.richest007.com/public/images/'.$picture.'"
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
        $result = json_decode($data, true);
        curl_close($ch);
//        file_put_contents('tag_user.txt',$data);
    }

    function wechat_workorder_list()
    {
        $keywords = $_GET['res'];
        $m = M('suzhou_dim_c_x_c_y_detail_test_20160125');
        $data1 = $m->query("select time as date,concat(project,' : ',tags) project,status part from test.products_owner_qiantai;");
        $this->ajaxReturn($data1);
    }


    function moban_message($openid,$keywords,$access_token){

        $json = '{
           "touser":"'.$openid.'",
           "template_id":"yl-KUwr7Ngd8Y4cp7bWk-iSImK-nt-wA5cfkNqEQbUY",
           "url":"http://softools.richest007.com/index.php/wechat/wechat_report_click",
           "data":{
                   "first": {
                       "value":"上富大数据工单任务组",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"'.$keywords.'",
                       "color":"#FF0000"
                   },
                   "keyword2": {
                       "value":"已经完成!请相关人员处理!",
                       "color":"#173177"
                   },
                   "keyword3": {
                       "value":"最高优先级!",
                       "color":"#173177"
                   },
                   "keyword4":{
                       "value":"上富科技",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"详情可以点击工单查看!",
                       "color":"#173177"
                   }
           }
       }';

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $data = curl_exec($ch);//运行curl
        $result = json_decode($data, true);
//        $openid = $result["openid"];
//        file_put_contents('tag_user.txt',$data);
        curl_close($ch);
        echo $data;

    }


    function ceshi(){
$url_code =  $_GET['code'];

$code = preg_replace('/[^0-9A-Za-z_-]/', '', $url_code);
if($code == '76bb454f83b6779286c5920a01d68d90') {
    $code = 'nansyg_urlxf';
}else if($code == 'b55774dff14776ef06adfc2d76695188') {
    $code = 'yanggptgg_urlxf';
}
if(isset($code)) {
    $fileFolde = split("_", $code);
    $config = file_get_contents("./phoneConfig/".$fileFolde[0].".txt");
    if( $config != '' ) {
        $content = explode( "\n", $config );
        while( list( $key,$val ) = each($content) ) {
            $row = explode("\t", $val);
            if( $row[0] == $code ) {
                $phoneimg = $row[1];
            }
        }
    }

    $con = mysql_connect("127.0.0.1:3305", "developer", 'gdas.developer');
    //$con = mysql_connect("127.0.0.1:8899", "developer", 'gdas.developer');
    if (!$con)
    {
        //die('Could not connect: ' . mysql_error());
        $split_list = array();
        $split_list[0] = '/vendor\//';
        $split_list[1] = '/<%=sof-arrival%>/';
        $split_list[2] = '/<%=cnzz-arrival%>/';
        $split_list[3] = '/<%=guid%>/';
        $split_list[4] = '/<%=pname%>/';
        $split_list[5] = '/<%=desc%>/';
        $split_list[6] = '/<%=title%>/';
        $target_list= array();
        $target_list[0] = $fileFolde[0]."/vendor/";
        $target_list[1] = '7';
        $target_list[2] = '';
        $target_list[3] = '';
        $target_list[4] = $fileFolde[0];
        $target_list[5] = $fileFolde[1];
        $target_list[6] = $code;

        $file = file_get_contents($fileFolde[0].'/index.html');

        $re_contents = preg_replace($split_list, $target_list, $file);
        echo $re_contents;
    }

    mysql_select_db("gdas_adv", $con);

    $result = mysql_query("select id,cnzz_arrival from policy_detail_cnzz where concat(projectcode,'_',policycode)='".$code."';");

    $row = mysql_fetch_row($result);
    if(isset($row[0])) {
        $split_list = array();
        $split_list[0] = '/vendor\//';
        $split_list[1] = '/<%=sof-arrival%>/';
        $split_list[2] = '/<%=cnzz-arrival%>/';
        $split_list[3] = '/<%=guid%>/';
        $split_list[4] = '/<%=pname%>/';
        $split_list[5] = '/<%=desc%>/';
        $split_list[6] = '/<%=title%>/';
        $target_list= array();
        $target_list[0] = $fileFolde[0]."/vendor/";
        $target_list[1] = '7'.$row[0];
        $target_list[2] = $row[1];
        $target_list[3] = $_SERVER['REQUEST_TIME'].'-'.$_SERVER["REMOTE_ADDR"].'-'.$fileFolde[0].'-'.$fileFolde[1];
        $target_list[4] = $fileFolde[0];
        $target_list[5] = $fileFolde[1];
        $target_list[6] = $code;

        if( isset($phoneimg) ) {
            $split_list[7] = '/<%=phoneimg%>/';
            $target_list[7] = "/sofspace/phoneimg/".$fileFolde[0]."/".$phoneimg.".jpg";
            $split_list[8] = '/<%=phoneno%>/';
            $target_list[8] = $phoneimg;
        }else {
            $split_list[7] = '/<%=phoneimg%>/';
            $target_list[7] = "/sofspace/$fileFolde[0]/vendor/img/tel.jpg";
            $split_list[8] = '/<%=phoneno%>/';
            $target_list[8] = '8061';
        }
        $file = file_get_contents($fileFolde[0].'/index.html');

        $re_contents = preg_replace($split_list, $target_list, $file);
        echo $re_contents;
        fclose($file);
    }else {
        echo '404';
    }

    mysql_close($con);
}else {
    echo 404;
}
}

}