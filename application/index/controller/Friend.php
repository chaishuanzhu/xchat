<?php
namespace app\index\controller;
use think\Db;
class Friend
{
    public function getinfo()
    {
        $users = Db::table('xc_friend')->select();
        return json_encode(['code' => '200', 'message' => 'success!', 'users' => $users]);
    }


    public function hello()
    {
        return 'hello';
    }

    public function apply()
    {

        $uid = $_POST["uid"];
        $friend_uid = $_POST["friend_uid"];
        $content = $_POST['content'];

        $message = array(
          'from_uid' => $uid,
          'to_uid' => $friend_uid,
          'content' => $content,
          'type' => 'friend_apply'
        );

        $result = $this -> post('http://xchat.chaisz.xyz/index/message/send_message',$message);

        if ($result) {
          # code...
          return json_encode(['code' => '200', 'message' => '申请已发送!']);
        }else{
          return json_encode(['code' => '500', 'message' => '申请失败!']);
        }
    }

    public function add()
    {
        $uid = $_POST["uid"];
        $friend_uid = $_POST["friend_uid"];
        $result = Db::table('xc_friend')->insert(array('xc_user_id' => $uid, 'friend_uid' => $friend_uid));
        if ($result) {
            return json_encode(['code' => '200', 'message' => '添加成功!']);
        }else {
          # code...
          return json_encode(['code' => '500', 'message' => '添加失败!']);
        }
    }

    public function delete()
    {
      $id = $_POST["id"];
      $result = Db::table('xc_friend')->where('id',$id)->delete();
      if ($result) {
          return json_encode(['code' => '200', 'message' => '删除成功!']);
      }else {
        # code...
        return json_encode(['code' => '500', 'message' => '删除失败!']);
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
          return $data;
    }
}
