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
     * @return array 商品列表
     */
    public function getProducts($parameters)
    {
        $data = [
            'merchantCode' => $this->merchantCode,
            'parameters' => json_encode($parameters),
            'signature' => $this->sign($parameters)
        ];

        return json_decode($this->postData($this->apiUrl . '/GetProducts?', $data), true);
    }

    /**
     * @desc 下单
     * @param  array $order
     * @return array
     */
    public function placeOrder($order)
    {
        $data = [
            'merchantCode' => $this->merchantCode,
            'postOrder' => json_encode($order),
            'signature' => $this->sign($order)
        ];


        return json_decode($this->postData($this->apiUrl . '/OrderOccupies?', $data), true);
    }


    /**
     * @desc 关闭未支付的预订单 订单释放
     * @param string $orderNo
     * @param array $parameters
     * @return array
     */

    public function orderRelease($orderNo, $parameters)
    {

        $data = [
            'otaCode' => $this->merchantCode,
            'otaOrderNO' => $orderNo,
            'parameters' => json_encode($parameters),
            'signature' => $this->sign($orderNo . json_encode($parameters), true)
        ];

        return json_decode($this->postData($this->apiUrl . '/OrderRelease?', $data), true);

    }

    /**
     * @desc 确认订单 会从OTA账户中扣除  金额 并返回电子串码
     * @param string $orderNo
     * @param array $parameters
     * @param int $platformSend
     * @return array
     */
    public function orderFinish($orderNo, $platformSend, $parameters)
    {

        $data = [
            'otaCode' => $this->merchantCode,
            'otaOrderNO' => $orderNo,
            'platformSend' => $platformSend,
            'Parameters' => json_encode($parameters),
            'signature' => $this->sign($orderNo . $platformSend . json_encode($parameters), true)
        ];
        return json_decode($this->postData($this->apiUrl . '/OrderFinish?', $data), true);
    }

    /**
     * @desc 对整单或者部分订单，进行申请退票时调用
     * @param array $postOrder
     * @return array
     */

    public function changeOrderEdit($postOrder)
    {
        $data = [
            'otaCode' => $this->merchantCode,
            'postOrder' => json_encode($postOrder),
            'signature' => $this->sign($postOrder)
        ];
        return json_decode($this->postData($this->apiUrl . '/ChangeOrderEdit?', $data), true);
    }

    /**
     * desc 回调信息 解析 验证
     * @param array $data
     * @return array
     */

    public function noticeOrder($data)
    {

        $res = $this->xmlToArray($data);
        if ($this->sign($res['OrderID'] . $res['ECode'] . $res['OrderNum'] . $res['NoticeType'], true) == $res['signature']) {
            return $res;
        } else {

            return false;
        }
    }


    /**
     * @desc 获取签名字符串
     * @param $parameters
     * @param $str bool 参数是否是 字符串
     * @return string
     */
    private function sign($parameters, $str = false)
    {
        $parametersStr = $str == true ? $parameters : json_encode($parameters);
        return base64_encode(strtoupper(md5($this->merchantCode . $this->appKey . $parametersStr)));
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