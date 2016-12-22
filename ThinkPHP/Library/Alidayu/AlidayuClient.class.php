<?php
/**
 * ���������������
 *
 * @author Flc <2016-02-18 21:18:55>
 * @link http://flc.ren Ҷ�ӿ�
 */
namespace Alidayu;

class AlidayuClient
{
    /**
     * ��ʽ����API�����ַ
     */
    const API_URI = 'http://gw.api.taobao.com/router/rest';

    /**
     * ɳ�价��API�����ַ
     */
    const SANDBOX_URI = 'http://gw.api.tbsandbox.com/router/rest';

    /**
     * App Key
     *
     * @var string
     * @link http://my.open.taobao.com/ �뵽�˴�����
     */
    protected $appKey;

    /**
     * App Secret
     *
     * @var string
     * @link http://my.open.taobao.com/ �뵽�˴�����
     */
    protected $appSecret;

    /**
     * api�����ַ
     * @var string
     */
    protected $apiURI;


    /**
     * ���췽��
     *
     * @param string $appKey    [description]
     * @param string $appSecret [description]
     */
    public function __construct($appKey = '', $appSecret = '')
    {
        $this->appKey    = $appKey ?: C('AlidayuAppKey');
        $this->appSecret = $appSecret ?: C('AlidayuAppSecret');
        $this->apiURI    = C('AlidayuApiEnv') ? self::API_URI : self::SANDBOX_URI;
    }

    /**
     * ����AppKey
     * @param string $value AppKey
     */
    public function setAppKey($value)
    {
        $this->appKey = $value;
    }

    /**
     * ����App Secret
     * @param string $value AppSecret
     */
    public function setAppSecret($value)
    {
        $this->appSecret = $value;
    }

    /**
     * ִ������
     * @param  Object $request �������
     * @return array|false
     */
    public function execute($request)
    {
        $params = $request->getParams();
        $params = array_merge($this->publicParams(), $params);

        $params['sign'] = $this->sign($params);

        $req = $this->curl($this->apiURI, $params);
        return json_decode($req, true);
    }

    /**
     * ��������
     * @return array
     */
    protected function publicParams()
    {
        return array(
            'app_key'     => $this->appKey,
            'timestamp'   => date('Y-m-d H:i:s'),
            'format'      => 'json',
            'v'           => '2.0',
            'sign_method' => 'md5'
        );
    }

    /**
     * ǩ��
     * @param  array $params ����
     * @return string
     */
    public function sign($params)
    {
        ksort($params);

        $tmps = array();
        foreach ($params as $k => $v) {
            $tmps[] = $k . $v;
        }

        $string = $this->appSecret . implode('', $tmps) . $this->appSecret;

        return strtoupper(md5($string));
    }

    /**
     * curl����
     * @param  string $url        string
     * @param  array|null $postFields �������
     * @return [type]             [description]
     */
    public function curl($url, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //https ����
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = "";
            foreach ($postFields as $k => $v) {
                $postBodyString .= "$k=" . urlencode($v) . "&";
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);

            $header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
        }

        $reponse = curl_exec($ch);
        return $reponse;
    }
}