<?php
namespace Softools\Controller;

use Think\Controller;
use Think;


class CardapiController extends Controller

{

    public function giftlist()
    {
        $m = M('wechat.users');
        $result = $m->query("select type,type_name as gift_name,abs(points) as gift_points from wechat.dim_type_points_details where points like '-%' and status = '1'");
        $this->ajaxReturn($result);
    }

    public function giftpoints()
    {
        header("content-type:application/json;");
        $openid = $_POST['openid'];
        $type = $_POST['type'];
//        $type=json_decode($_POST["type"],true);
//        $openid=json_decode($_POST["openid"],true);
//        $openid = $_POST["openid"];
//        $type = $_POST["type"];
//        $data = json_decode(file_get_contents("php://input"));
//       $openid = $data->openid;
//       $type = $data->type;

        $m = M('wechat.users');
        $dim_type_points_details = $m->query("select * from wechat.dim_type_points_details where type='$type'");
        $type_name = $dim_type_points_details[0][type_name];
        $points = $dim_type_points_details[0][points];
        $u_points = abs($points);

        $user_points = $m->query("select openid,sum(points) total_points from wechat.user_points where openid='$openid'");
        $total_points = $user_points[0][total_points];


        $users = $m->query("select openid from wechat.users where openid='$openid'");
        $type_is_have = $m->query("select type from wechat.dim_type_points_details where type='$type'");

        $isopenid = $users[0][openid];
        $istype = $type_is_have[0][type];

        if (!isset($openid) || !isset($type) || !isset($isopenid) || !isset($istype)) {
            $this->ajaxReturn(null);

        } else {

            if ($total_points + $points >= 0) {
                $m->execute("insert into wechat.user_points (openid,points,createdat,type,source,remark) values('$openid','$points',now(),'$type','$type',null);");
                $data1 = $m->query("select openid,sum(points) total_points from wechat.user_points where openid='$openid'");
                $now_points = $data1[0][total_points];
                $result_lang = "兑换成功,扣减您 $u_points 分,获得:$type_name,您的积分剩余:$now_points 分";
                $result['istrue'] = true;
                $result['message'] = $result_lang;
                $result['gift'] = $type_name;
                $result['now_points'] = $now_points;
                $this->ajaxReturn($result);
            } else {
                $result_lang = "抱歉,您的积分不够,请努力赚取积分!";
                $result['istrue'] = false;
                $result['message'] = $result_lang;
                $this->ajaxReturn($result);
            }
        }
    }


    public function gifthistory(){
        header("content-type:application/json;");
        $openid = $_GET['openid'];
        $m = M('wechat.users');
        $data = $m->query("select a.openid,a.createdat,b.type_name giftname from wechat.user_points a INNER JOIN wechat.dim_type_points_details b on a.type=b.type where a.points like '-%' and openid='$openid' order by a.createdat desc");
        $this->assign("rs", $data);
        $this->display();
    }

    public function personal_center(){
        header("content-type:application/json;");
        $openid = $_POST["openid"];
        $m = M('wechat.users');
        $data = $m->query("SELECT a.openid,ifnull(a.telephone,'未知') as 'telephone',case when b.employee_telephone is not null then b.employee_name else ifnull(a.username,'未知') end as 'username',
        case when a.telephone is not null or a.telephone <> '' then '已认证' else '未认证' end as 'identification',
        case when b.employee_telephone is not null then '工作人员' else '客户' end role,
        case when c.points<=300 then '铜牌'
        when c.points>300 and c.points<=800 then '银牌'
        when c.points>800 and c.points<=2000 then '金牌'
        when c.points>2000 then '钻石' end as 'level',
        case when a.telephone is not null or a.telephone <> '' then '已认证' else '未认证' end as 'identification',
        case when b.employee_telephone is not null then '工作人员' else '客户' end role,
        case when c.points<=300 then '1'
        when c.points>300 and c.points<=800 then '2'
        when c.points>800 and c.points<=2000 then '3'
        when c.points>2000 then '4' end as 'level_code',
        c.points,
        ifnull(d.child_count,0) child_count FROM wechat.users a
        left JOIN wechat.employees b on a.telephone=b.employee_telephone
        left join (select openid,ifnull(sum(points),0) as 'points' from wechat.user_points group by openid) c
        on a.openid=c.openid
        left join (select old_openid,ifnull(count(distinct new_openid),0) as 'child_count' from wechat.users_match group by old_openid) d
        on a.openid=d.old_openid where a.openid = '$openid'");
        $user_details=$data[0];
        $this->ajaxReturn($user_details);
    }

    public function award_fun(){
//        header("content-type:application/json;");
        $openid = $_GET["openid"];
        $command = $_GET["command"];
        $m = M('wechat.users');
        if($command=='list'){
            $result_tmp = $m -> query("select type_name from wechat.dim_type_points_details where type like '%jp%' order by type");
            $this->ajaxReturn($result_tmp);
        } else if($command=='award')
        {
            $result_tmp = $m -> query("call wechat.award_fun('$openid')");
            $result=$result_tmp[0];
            $this->ajaxReturn($result);
        }
    }
}