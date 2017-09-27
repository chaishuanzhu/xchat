<?php

namespace app\push\controller;

//加载GatewayClient。安装GatewayClient参见本页面底部介绍
require_once __DIR__ . 'vendor/workerman/gatewayclient/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use GatewayClient\Gateway;
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
Gateway::$registerAddress = '127.0.0.1:1236';

class Events
{
  // 当有客户端连接时，将client_id返回，让mvc框架判断当前uid并执行绑定
  public static function onConnect($client_id)
  {
      Gateway::sendToClient($client_id, json_encode(array(
          'type'      => 'init',
          'client_id' => $client_id
      )));
  }

  // GatewayWorker建议不做任何业务逻辑，onMessage留空即可
  public static function onMessage($client_id, $message)
  {

  }
}
