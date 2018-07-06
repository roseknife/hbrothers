<?php

namespace RoseKnife\Hbrothers;
/**
 * Created by PhpStorm.
 * User: RoseKnife Hua
 * Date: 2018/6/29 0029
 * Time: 11:07
 */
class Lite
{

    private $merchantCode;
    private $appKey;
    private $apiUrl;

    public function __construct($config)
    {
        $this->merchantCode = $config['merchantCode']; //ota编码
        $this->apiUrl = $config['apiUrl']; //接口请求URL
        $this->appKey = $config['appKey']; //景区私钥

    }

    /**
     * @desc 获取某日可售产品信息
     * @param $parameters JSON参数 data日期 type类型00门票 03剧场票
     */
    public function getProducts($parameters)
    {
        $data = [
            'merchantCode' => $this->merchantCode,
            'parameters' => json_encode($parameters),
            'signature' => $this->sign($parameters)
        ];
        echo $this->appKey."<hr />";
        print_r($data);echo "<hr />";
        return $this->postData($this->apiUrl . '/GetProducts?', $data);
    }


    /**
     * @desc 获取签名字符串
     * @param $parameters
     * @return string
     */
    private function sign($parameters)
    {
        $parametersStr = json_encode($parameters);
        return base64_encode(md5($this->merchantCode . $this->appKey . $parametersStr));
    }


    /**
     * 发送请求
     * @param $url
     * @param $data
     * @return mixed
     */
    private function postData($url, $data = null)
    {
        $postUrl = $url . http_build_query($data);
        echo $postUrl."<hr />";
        //初始化
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $this->xmlToArray($result);
    }

    /**
     * @param $xml
     * @return mixed
     */
    private function xmlToArray($xml)
    {
        libxml_disable_entity_loader(true);//禁止引用外部xml实体
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values[0]; //降维处理
    }
}