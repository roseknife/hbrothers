<?php
header("Content-type: text/html; charset=utf-8");
/**
 * Created by PhpStorm.
 * User: RoseKnife Hua
 * Date: 2018/6/29 0029
 * Time: 11:39
 */
include_once "src/Lite.php";

//这里配置到系统中
$config = [
    'merchantCode' => 'wstx',
    'apiUrl' => 'http://223.223.179.20:8023/Service.asmx',
    'appKey' => 'e7f8dbeebd210fca5323e129a2a17ba'
];

$lite = new \RoseKnife\Hbrothers\Lite($config);

//这里是业务逻辑
//查询
//$para = [
//    'date' => '2018-07-10',
//    'type' => '00',
//    'parkCode' => 'clota'
//];
//var_dump($lite->getProducts($para));


//下单
//$order = [
//    'Ptime' => date('Y-m-d H:i:s'),
//    'Order' =>json_encode( [
//        'OrderNO' => 'xma112233445511223446',
//        'LinkName' => '小棉袄',
//        'LinkPhone' => '18657527739',
//        'CreateTime' => date('Y-m-d H:i:s')
//    ]),
//    'Details' => json_encode([[
//        'OrderNO' => 'xma112233445511223446',
//        'ItemID' => '3231231231',
//        'ProductID'=>'00007264',
//        'ProductName'=>'7.6网商天下测试票',
//        'ProductCode' => '00000830_00007264',
//        'ProductPrice' => 0.01,
//        'ProductCount' => 1,
//        'ProductSDate' => '2018-07-10',
//        'ProductEDate' => '2018-07-10' ,
//    ]]),
//    'Type'=>'00',
//    'parkCode' => 'clota'
//];
//var_dump($lite->placeOrder($order));


//关闭未支付的预订单 订单释放

//$orderNo = "xma112233445511223445";
//$parameters =['Type'=>'00',
//            'parkCode' =>'clota'
//                ];
//var_dump($lite->orderRelease($orderNo,$parameters));



//确认订单 并支付金额

//$orderNo = "xma112233445511223446";
//$parameters =['Type'=>'00',
//            'parkCode' =>'clota'
//                ];
//$platformSend = 0;
//
//var_dump($lite->orderFinish($orderNo,$platformSend,$parameters));


//订单退款 Edittype 值为1 为改票  2为申请退票 Details中的ProductCode 为订单确认返回的串码ECode

//$postOrder = [
//    'Type'=>"00",
//    'Ptime' => date('Y-m-d H:i:s'),
//    'parkCode'=>'clota',
//    'Edittype'=>'2',
//    'Order'=>json_encode(['OrderNo'=>'xma112233445511223446','LinkName'=>'小棉袄']),
//    'Details'=>json_encode([['ProductCode'=>"832074639795","Starttime"=>date('Y-m-d H:i:s'),"Count"=>1,"Audit"=>1]])
//
//];
//var_dump($lite->changeOrderEdit($postOrder));

//回调解析  接受post参数 转换
// ResultCode 00 成功  01 失败
//$lite->noticeOrder($data);
//return json_encode(['ResultCode'=>"00","ResultMsg"=>"接收成功"]);

