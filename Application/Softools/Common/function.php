<?php
/*
    File: functions.php
 */

function media($content) //多媒体转换
{
	if(strstr($content,'murl')){//音乐
		$a=array();
		foreach (explode('#',$content) as $content)
		{
			list($k,$v)=explode('|',$content);
			$a[$k]=$v;
		}
		$content = $a;
	}              
	elseif(strstr($content,'pic'))//多图文回复
	{
		$a=array();
		$b=array();
		$c=array();
		$n=0;
		$contents = $content;
		foreach (explode('@t',$content) as $b[$n])
		{
			if(strstr($contents,'@t'))
			{
			$b[$n] = str_replace("itle","title",$b[$n]);
			$b[$n] = str_replace("ttitle","title",$b[$n]);
			}
			
			foreach (explode('#',$b[$n]) as $content)
			{
				list($k,$v)=explode('|',$content);
				$a[$k]=$v;
				$d.= $k;
			}
		$c[$n] = $a;
		$n++;
		
		}
		$content = $c ;
	}
	return $content;
}

function get_utf8_string($content)  //  将一些字符转化成utf8格式   
{    
	//  将一些字符转化成utf8格式   
	$encoding = mb_detect_encoding($content, array('ASCII','UTF-8','GB2312','GBK','BIG5'));  
	return  mb_convert_encoding($content, 'utf-8', $encoding);
}


function xiaojo($key,$from,$to) //小九接口函数，该函数可通用于其他程序
{
	global $yourdb,$yourpw;
	//取全局变量
	$yourdb = XIAOJO_DB ;
	$yourpw = XIAOJO_PW ;
	//转换编码格式
	$key=urlencode($key);
	$yourdb=urlencode($yourdb);
	$from=urlencode($from);
	$to=urlencode($to);
	//调用小九API接口得到回复结果
	$post= "chat=".$key."&db=".$yourdb."&pw=".$yourpw."&from=".$from."&to=".$to;
	$api = "http://www.xiaojo.com/api5.php";
	$replys = http_post($api,$post);
	$reply = media(urldecode( $replys));//多媒体转换
	return $reply;	
}
	
//有道翻译
function youdaoDic($word){
	$keyfrom = "zhuojin";	//申请APIKEY时所填表的网站名称的内容
	$apikey = "304804921";  //从有道申请的APIKEY
	
	/*/有道翻译-xml格式
	$url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=xml&version=1.1&q='.$word;	
	$xmlStyle = simplexml_load_file($url_youdao);	
	$errorCode = $xmlStyle->errorCode;
	$paras = $xmlStyle->translation->paragraph;
	if($errorCode == 0){
		return $paras;
	}else{
		return "无法进行有效的翻译";
	}
	*/
		
	//有道翻译-json格式
	$url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=json&version=1.1&q='.$word;	
	$jsonStyle = http_get($url_youdao);
	$result = json_decode($jsonStyle,true);	
	$errorCode = $result['errorCode'];	
	$trans = '';
	if(isset($errorCode)){
		switch ($errorCode){
			case 0:
				$trans = $result['translation']['0'];
				break;
			case 20:
				$trans = '要翻译的文本过长';
				break;
			case 30:
				$trans = '无法进行有效的翻译';
				break;
			case 40:
				$trans = '不支持的语言类型';
				break;
			case 50:
				$trans = '无效的key';
				break;
			default:
				$trans = '出现异常';
				break;
		}
	}
	return $trans;
	
}

//百度翻译
function baiduDic($word,$from="auto",$to="auto"){	
	//首先对要翻译的文字进行 urlencode 处理
	$word_code=urlencode($word);	
	//注册的API Key
	$appid="O1IyaDAfnLPAIemNuG9kSdwq";	
	//生成翻译API的URL GET地址
	$baidu_url = "http://openapi.baidu.com/public/2.0/bmt/translate?client_id=".$appid."&q=".$word_code."&from=".$from."&to=".$to;	
	$text=json_decode(http_get($baidu_url));
	$text = $text->trans_result;
	return $text[0]->dst;
}
	


/**
 * GET 请求
 * @param string $url
 */
function http_get($url){
	//初始化一个cURL对象 
	$oCurl = curl_init();
	if(stripos($url,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
	}
	//设置需要抓取的URL
	curl_setopt($oCurl, CURLOPT_URL, $url);
	//设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
	//在发起连接前等待的时间，如果设置为0，则无限等待。微信的一次连接最长为5秒	
	$timeout = 5;   		
	curl_setopt ($oCurl, CURLOPT_CONNECTTIMEOUT, $timeout);
	//运行cURL，请求网页
	$sContent = curl_exec($oCurl);
	$aStatus = curl_getinfo($oCurl);
	//关闭URL请求
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		return false;
	}
}

/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @return string content
 */
function http_post($url,$param){
	//初始化curl  
	$oCurl = curl_init();
	if(stripos($url,"https://")!==FALSE){
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
	}
	if (is_string($param)) {
		$strPOST = $param;
	} else {
		$aPOST = array();
		foreach($param as $key=>$val){
			$aPOST[] = $key."=".urlencode($val);
		}
		$strPOST =  join("&", $aPOST);
	}
	//在发起连接前等待的时间，如果设置为0，则无限等待。微信的一次连接最长为5秒	
	$timeout = 5;   		
	curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($oCurl, CURLOPT_URL, $url);  //抓取指定网页  
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );  //要求结果为字符串且输出到屏幕上 
	curl_setopt($oCurl, CURLOPT_POST,true);           //post提交方式  
	curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
	$sContent = curl_exec($oCurl);      //运行curl  
	$aStatus = curl_getinfo($oCurl);
	curl_close($oCurl);
	if(intval($aStatus["http_code"])==200){
		return $sContent;
	}else{
		return false;
	}
}


?>