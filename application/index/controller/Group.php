<?php
namespace app\index\controller;
use think\Db;
class Group
{
    public function getinfo()
    {
        $users = Db::table('xc_group')->select();
        return json_encode(['code' => '200', 'message' => 'success!', 'users' => $users]);
    }


    public function hello()
    {
        return 'hello';
    }

    public function create()
    {

        $uid = $_POST["uid"];
        $groupName = $_POST["groupName"];
        $introduction = $_POST['introduction'];

        $message = array(
          'uid' => $uid,
          'groupName' => $groupName,
          'introduction' => $introduction,
          'createDate' => time()
        );

        $result = Db::table('xc_group')
        ->insert(array(
          'uid' => $uid,
          'groupName' => $groupName,
          'introduction' => $introduction,
          'createDate' => time()
        ));
        if ($result) {
          # code...
          return json_encode(['code' => '200', 'message' => '创建成功!']);
        }else{
          return json_encode(['code' => '500', 'message' => '创建失败!']);
        }
    }

    public function uploadImage()
    {
      $id = $_POST["id"];
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file('image');
      // 移动到框架应用根目录/public/uploads/ 目录下
      $info = $file->validate(['ext'=>'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'headimages');
      if($info){
          // 成功上传后 获取上传信息
          $savePath = $info->getSaveName();
          $filePath = config('ROOT_URL') .'headimages' . DS . $savePath;
          $result = Db::table('xc_group')->where('id', $id)->update(['image' => $filePath]);
          if ($result) {
            # code...
            return json_encode(['code' => '200', 'message' => '上传成功!', 'Info' => $filePath]);
          }else {
            # code...
            return json_encode(['code' => '400', 'message' => '上传失败，请重试!']);
          }
      }else{
          // 上传失败获取错误信息
          return json_encode(['code' => '500', 'message' => '上传失败!']);
      }
    }

    public function apply()
    {

        $uid = $_POST["uid"];
        $group_uid = $_POST["group_uid"];
        $content = $_POST['content'];

        $message = array(
          'from_uid' => $uid,
          'to_uid' => $group_uid,
          'content' => $content,
          'type' => 'group_apply'
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
        $group_id = $_POST["group_id"];
        $result = Db::table('xc_user_has_xc_group')->insert(array('xc_user_id' => $uid, 'xc_group_id' => $group_id));
        if ($result) {
            return json_encode(['code' => '200', 'message' => '添加成功!']);
        }else {
          # code...
          return json_encode(['code' => '500', 'message' => '添加失败!']);
        }
    }

    public function remove()
    {
        $uid = $_POST["uid"];
        $group_id = $_POST["group_id"];
        $result = Db::table('xc_user_has_xc_group')->where(array('xc_user_id' => $uid, 'xc_group_id' => $group_id))->delete();
        if ($result) {
            return json_encode(['code' => '200', 'message' => '移出成功!']);
        }else {
          # code...
          return json_encode(['code' => '500', 'message' => '移出失败!']);
        }
    }

    public function delete()
    {
      $id = $_POST["id"];
      $result = Db::table('xc_group')->where('id',$id)->delete();
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
