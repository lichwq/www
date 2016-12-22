<?php
/**
 * �������API�ӿڣ����Žӿڣ�����
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
     * �������demo
     * @return [type] [description]
     */
    public function index()
    {
        $client  = new Client;
        $request = new SmsNumSend;

        // �������ݲ���
        $smsParams = [
            'code'    => $this->randString(),
            'product' => '���Ե�'
        ];

        // �����������
        $req = $request->setSmsTemplateCode('SMS_5053601')
            ->setRecNum('13312341234')
            ->setSmsParam(json_encode($smsParams))
            ->setSmsFreeSignName('���֤')
            ->setSmsType('normal')
            ->setExtend('demo');

        print_r($client->execute($req));
    }

    /**
     * ��ȡ���λ������
     * @param  integer $len ����
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