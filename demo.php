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



//这里是业务逻辑
$para = [
    'date' => '2018-07-10',
    'type' => '00',
    'parkCode' => 'dx'
];

$lite = new \RoseKnife\Hbrothers\Lite($config);
print_r($lite->getProducts($para));


