<?php
/**
 * ���ŷ���
 *
 * @author Flc <2016-02-18 21:18:19>
 * @link http://flc.ren Ҷ�ӿ�
 *
 * @link http://open.taobao.com/doc2/apiDetail.htm?spm=0.0.0.0.tjoIzd&apiId=25450 �����ĵ�
 */
namespace Alidayu\Request;

class SmsNumSend
{

    /**
     * API�������
     * @var array
     */
    protected $params = array(
        'method' => 'alibaba.aliqin.fc.sms.num.send',
    );

    /**
     * [��ѡ]���ù����ش��������ڡ���Ϣ���ء��л�͸���ظò������������û����Դ����Լ��¼��Ļ�ԱID������Ϣ����ʱ���û�ԱID��������ڣ��û����Ը��ݸû�ԱIDʶ������λ��Աʹ�������Ӧ��
     *
     * @param string $value
     */
    public function setExtend($value)
    {
        $this->params['extend'] = $value;
        return $this;
    }

    /**
     * [����]���ö������ͣ�����ֵ����дnormal
     *
     * @param string $value
     */
    public function setSmsType($value)
    {
        $this->params['sms_type'] = $value;
        return $this;
    }

    /**
     * [����]���ö���ǩ��������Ķ���ǩ���������ڰ�����㡰��������-����ǩ�������еĿ���ǩ�����硰������㡱���ڶ���ǩ��������ͨ����ˣ���ɴ��롱������㡰������ʱȥ�����ţ���Ϊ����ǩ��������Ч��ʾ������������㡿��ӭʹ�ð���������
     *
     * @param string $value
     */
    public function setSmsFreeSignName($value)
    {
        $this->params['sms_free_sign_name'] = $value;
        return $this;
    }

    /**
     * [��ѡ]���ö���ģ����������ι���{"key":"value"}��key�������������ģ���еı�����һ�£��������֮���Զ��Ÿ�����ʾ�������ģ�塰��֤��${code}�������ڽ���${product}�����֤��������Ҫ���߱���Ŷ����������ʱ�贫��{"code":"1234","product":"alidayu"}
     *
     * @param json $value
     */
    public function setSmsParam($value)
    {
        $this->params['sms_param'] = $value;
        return $this;
    }

    /**
     * [����]���ö��Ž��պ��롣֧�ֵ��������ֻ����룬�������Ϊ11λ�ֻ����룬���ܼ�0��+86��Ⱥ�������贫�������룬��Ӣ�Ķ��ŷָ���һ�ε�����ഫ��200�����롣ʾ����18600000000,13911111111,13322222222
     *
     * @param string $value
     */
    public function setRecNum($value)
    {
        $this->params['rec_num'] = $value;
        return $this;
    }

    /**
     * [����]���ö���ģ��ID�������ģ��������ڰ�����㡰��������-����ģ������еĿ���ģ�塣ʾ����SMS_585014
     *
     * @param string $value
     */
    public function setSmsTemplateCode($value)
    {
        $this->params['sms_template_code'] = $value;
        return $this;
    }

    /**
     * �������в���
     * @return [type] [description]
     */
    public function getParams()
    {
        return $this->params;
    }
}