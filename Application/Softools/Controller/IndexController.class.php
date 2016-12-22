<?php
/**
 * 阿里大鱼API接口（短信接口）范例
 *
 * @author Flc <2016-02-18 23:18:10>
 * @link http://flc.ren
 * @link https://code.csdn.net/flc1125/alidayu
 */
namespace Softools\Controller;

use Think\Controller;
use Alidayu\AlidayuClient as Client;
use Alidayu\Request\SmsNumSend;

class IndexController extends Controller
{
    /**
     * 阿里大雨demo
     * @return [type] [description]
     */
    public function index()
    {
        $client  = new Client;
        $request = new SmsNumSend;

        // 短信内容参数
        $smsParams = [
            'code'    => $this->randString(),
            'product' => '测试的'
        ];

        // 设置请求参数
        $req = $request->setSmsTemplateCode('SMS_5053601')
            ->setRecNum('13312341234')
            ->setSmsParam(json_encode($smsParams))
            ->setSmsFreeSignName('活动验证')
            ->setSmsType('normal')
            ->setExtend('demo');

        print_r($client->execute($req));
    }

    /**
     * 获取随机位数数字
     * @param  integer $len 长度
     * @return string
     */
    protected static function randString($len = 6)
    {
        $chars = str_repeat('0123456789', $len);
        $chars = str_shuffle($chars);
        $str   = substr($chars, 0, $len);
        return $str;
    }
}