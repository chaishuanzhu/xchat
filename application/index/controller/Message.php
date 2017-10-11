<?php
namespace app\index\controller;
//加载GatewayClient。安装GatewayClient参见本页面底部介绍
require_once ROOT_PATH.'vendor/workerman/gatewayclient/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use GatewayClient\Gateway;
use think\Db;
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
class Message
{

    public function index () {
        return ROOT_PATH.'vendor/workerman/gatewayclient/Gateway.php';
    }

    public function test (){
      $groups = Db::table('xc_group')->where('uid',1000000000)->column('id');
      var_dump($groups);
      foreach ($groups as $gid) {
        # code...
        echo $gid;
      }

      $devicetokens = Db::table('xc_user')
      ->alias('a')
      ->join('xc_user_has_xc_group b', 'a.id = b.xc_user_id')->where('b.xc_group_id',10000)->column('a.devicetoken');

      var_dump($devicetokens);
    }
    public function bind () {

        Gateway::$registerAddress = '127.0.0.1:1238';

        // 假设用户已经登录，用户uid和群组id在session中
        $uid      = $_POST["uid"];
        $client_id = $_POST["client_id"];
        // client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
        // 加入某个群组（可调用多次加入多个群组）

        $groups = Db::table('xc_group')->where('uid',$uid)->column('id');
        foreach ($groups as $group_id) {
          # code...
          Gateway::joinGroup($client_id, $group_id);
        }
        return json_encode(['code' => 200, 'message' => 'success!']);
    }

    function send_message() {
        // //加载GatewayClient。安装GatewayClient参见本页面底部介绍
        // require_once '/your/path/GatewayClient/Gateway.php';
        // // GatewayClient 3.0.0版本开始要使用命名空间
        // use GatewayClient\Gateway;
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值

        $from_uid = $_POST['from_uid'];
        $content = $_POST['content'];
        $type = $_POST['type'];

        Gateway::$registerAddress = '127.0.0.1:1238';

        if (isset($_POST['to_uid'])) {
          # code...
          $to_uid = $_POST['to_uid'];
          $data = array(
            'from_uid' => $from_uid,
            'to_uid' => $to_uid,
            'content' => $content,
            'sendTime' => time(),
            'type' => $type
          );
          // 向任意uid的网站页面发送数据
          Gateway::sendToUid($to_uid, json_encode($data));

          Db::table('xc_message')->insert(array('xc_user_id' => $from_uid, 'to_uid' => $to_uid, 'content' => $content, 'sendTime' => time(), 'type' => $type));

          $devicetoken = Db::table('xc_user')->where('id',$to_uid)->value('devicetoken');

          $this -> post('http://xchat.chaisz.xyz/push/push/ios',array('devicetoken' => $devicetoken, 'msg' => $content));
          return json_encode(['code' => 200, 'message' => 'success!']);
        }elseif (isset($_POST['to_group_id'])) {
          # code...
          $to_group_id = $_POST['to_group_id'];
          $data = array(
            'from_uid' => $from_uid,
            'to_group_id' => $to_group_id,
            'content' => $content,
            'sendTime' => time(),
            'type' => $type
          );
          // 向任意群组的网站页面发送数据
          Gateway::sendToGroup($to_group_id, json_encode($data));

          Db::table('xc_gmessage')->insert(array('xc_user_id' => $from_uid, 'xc_group_id' => $to_group_id, 'content' => $content, 'sendTime' => time(), 'type' => $type));

          $devicetokens = Db::table('xc_user')
          ->alias('a')
          ->join('xc_user_has_xc_group b', 'a.id = b.xc_user_id')->where('b.xc_group_id',$to_group_id)->column('a.devicetoken');

          foreach ($devicetokens as $devicetoken) {
            # code...
            $this -> post('http://xchat.chaisz.xyz/push/push/ios',array('devicetoken' => $devicetoken, 'msg' => $content));
          }
          return json_encode(['code' => 200, 'message' => 'success!']);
        }else {
          # code...
          return json_encode(['code' => 500, 'message' => 'fail!']);
        }
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


// http://localhost/xchat/public/index/message/send_message
