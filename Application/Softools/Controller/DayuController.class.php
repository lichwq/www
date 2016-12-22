<?php
namespace Softools\Controller;

use Think\Controller;

class DayuController extends Controller
{
    public function code_msg_put()
    {
        header("content-type:application/json;");
        $telephone = $_POST["telephone"];
//        $data = json_decode(file_get_contents("php://input"));
//        $telephone = $data->telephone;


        date_default_timezone_set('Asia/Shanghai');
        $m = M('wechat.users');
        $appkey = "23346135";//你的App key
        $secret = "1b9e500207a89f561ee6d34e9e0c94d6";//你的App Secret:
        import('Org.Taobao.top.TopClient');
        import('Org.Taobao.top.ResultSet');
        import('Org.Taobao.top.RequestCheckUtil');
        import('Org.Taobao.top.TopLogger');
        import('Org.Taobao.top.request.AlibabaAliqinFcSmsNumSendRequest');
//将需要的类引入，并且将文件名改为原文件名.class.php的形式
        $c = new \TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
//        $req->setExtend("123456");//确定发给的是哪个用户，参数为用户id
        $req->setSmsType("normal");
        /*
        进入阿里大鱼的管理中心找到短信签名管理，输入已存在签名的名称，这里是身份验证。
        */
        $sof_code = rand(1000, 9999);
        $req->setSmsFreeSignName("身份验证");
        $req->setSmsParam("{'code':'$sof_code','product':'御上海:青橙 实名认证'}");
//这里设定的是发送的短信内容：验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！”
//        $telephone = "18217281963";
        $req->setRecNum($telephone);//参数为用户的手机号码
        $req->setSmsTemplateCode("SMS_7740338");
        $resp = $c->execute($req);
        $resp = json_encode($resp);
        $resp = json_decode($resp, true);
        $result = $resp['result']['err_code'];
        if ($result == '0') {
            $m->execute("insert into wechat.users_msg_code(telephone,msg_code) values('$telephone','$sof_code')");
            $result1['istrue'] = true;
            $result1['message'] = '发送成功';
            $this->ajaxreturn($result1);
        } else {
            $result1['istrue'] = false;
            $result1['message'] = '验证码发送失败,请重新尝试';
            $this->ajaxreturn($result1);
            #king
        }
    }

    public function code_msg_confirm()
    {
        header("content-type:application/json;");
        $code = $_POST['code'];
        $username = $_POST['username'];
        $openid = $_POST['openid'];
        $telephone = $_POST['telephone'];

//            $data = json_decode(file_get_contents("php://input"));
//            $code = $data->code;
//            $username = $data->username;
//            $openid = $data->openid;
//            $telephone = $data->telephone;

        $m = M('wechat.users');
        $mysql_result = $m->query("select b.msg_code as msg_code from
        (SELECT telephone,max(createat) as createat FROM wechat.users_msg_code where telephone='$telephone') a
         INNER JOIN
         wechat.users_msg_code b on a.telephone=b.telephone and a.createat=b.createat;");

        $my_code = $mysql_result[0]['msg_code']; //取出验证码
        if ($my_code == $code) {
            $m->execute("UPDATE wechat.users SET telephone='$telephone', username='$username' WHERE openid='$openid';");
            $m->execute("insert into wechat.user_points (openid,points,createdat,type,source,remark) values('$openid','50',now(),'rz11','rz11',null);");
            $result['istrue'] = true;
            $result['message'] = '认证成功,恭喜您获得50积分!';
            $this->ajaxreturn($result);
        } else {
            $result['istrue'] = false;
            $result['message'] = '验证失败!';
            $this->ajaxreturn($result);
        }
    }


    public function user_reg_message()
    {
        header("content-type:application/json;");
        $telephone = $_GET["telephone"];
//        $data = json_decode(file_get_contents("php://input"));
//        $telephone = $data->telephone;


        date_default_timezone_set('Asia/Shanghai');
        $m = M('wechat.users');
        $appkey = "23346135";//你的App key
        $secret = "1b9e500207a89f561ee6d34e9e0c94d6";//你的App Secret:
        import('Org.Taobao.top.TopClient');
        import('Org.Taobao.top.ResultSet');
        import('Org.Taobao.top.RequestCheckUtil');
        import('Org.Taobao.top.TopLogger');
        import('Org.Taobao.top.request.AlibabaAliqinFcSmsNumSendRequest');
//将需要的类引入，并且将文件名改为原文件名.class.php的形式
        $c = new \TopClient;
        $c->appkey = $appkey;
        $c->secretKey = $secret;
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
//        $req->setExtend("123456");//确定发给的是哪个用户，参数为用户id
        $req->setSmsType("normal");
        /*
        进入阿里大鱼的管理中心找到短信签名管理，输入已存在签名的名称，这里是身份验证。
        */
        $sof_code = rand(1000, 9999);
        $req->setSmsFreeSignName("活动验证");
        $req->setSmsParam("{'msg':'新南山房产返利活动!','phone':'4008226686转8061'}");
//这里设定的是发送的短信内容：验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！”
//        $telephone = "18217281963";
        $req->setRecNum($telephone);//参数为用户的手机号码
        $req->setSmsTemplateCode("SMS_10360785");
        $resp = $c->execute($req);
        $resp = json_encode($resp);
        $resp = json_decode($resp, true);
        $result = $resp['result']['err_code'];
        if ($result == '0') {
//            $m->execute("insert into wechat.users_msg_code(telephone,msg_code) values('$telephone','$sof_code')");
            $result1['istrue'] = true;
            $result1['message'] = '发送成功';
            $this->ajaxreturn($result1);
        } else {
            $result1['istrue'] = false;
            $result1['message'] = '验证码发送失败,请重新尝试';
            $this->ajaxreturn($result1);
        }
    }
}
