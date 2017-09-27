<?php
namespace app\index\controller;
//加载GatewayClient。安装GatewayClient参见本页面底部介绍
require_once ROOT_PATH.'vendor/workerman/gatewayclient/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use GatewayClient\Gateway;
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
class Bind
{

    public function index () {
        return ROOT_PATH.'vendor/workerman/gatewayclient/Gateway.php';
    }
    public function bind () {

        Gateway::$registerAddress = '127.0.0.1:1238';

        // 假设用户已经登录，用户uid和群组id在session中
        $uid      = $_POST["uid"];
        $group_id = '1';
        $client_id = $_POST["client_id"];
        // client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
        // 加入某个群组（可调用多次加入多个群组）
        Gateway::joinGroup($client_id, $group_id);

        return json_encode(['code' => 200, 'message' => 'success!']);
    }

    public function send_message($uid = '123456', $message = '25652652', $group = '1') {
        // //加载GatewayClient。安装GatewayClient参见本页面底部介绍
        // require_once '/your/path/GatewayClient/Gateway.php';
        // // GatewayClient 3.0.0版本开始要使用命名空间
        // use GatewayClient\Gateway;
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';

        // 向任意uid的网站页面发送数据
        Gateway::sendToUid($uid, $message);
        // 向任意群组的网站页面发送数据
        Gateway::sendToGroup($group, $message);

        $this -> post('http://xchat.chaisz.xyz/push/push/ios',array('msg' => $message));
    }

    function post($url, $post_data){
          //初始化
          $curl = curl_init();
          //设置抓取的url
          curl_setopt($curl, CURLOPT_URL, $url);
          //设置头文件的信息作为数据流输出
          curl_setopt($curl, CURLOPT_HEADER, 1);
          //设置获取的信息以文件流的形式返回，而不是直接输出。
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          //设置post方式提交
          curl_setopt($curl, CURLOPT_POST, 1);
          //设置post数据
          curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
          //执行命令
          $data = curl_exec($curl);
          //关闭URL请求
          curl_close($curl);
          //显示获得的数据
          // print_r($data);
    }
}
