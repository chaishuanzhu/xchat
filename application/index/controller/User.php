<?php
namespace app\index\controller;
use think\Db;
class User
{
    public function getusers()
    {
        $users = Db::table('xc_user')->field('password,token',true)->select();
        return json_encode(['code' => '200', 'message' => 'success!', 'users' => $users]);
    }


    public function hello()
    {
        return 'hello';
    }

    public function register()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $devicetoken = $_POST["devicetoken"];
        $result = Db::table('xc_user')->where('email',$email)->find();
        if ($result) {
          # code...
          return json_encode(['code' => '400', 'message' => '用户已存在!']);
        }else{
          $uid = Db::table('xc_user')->insertGetId(array('email' => $email, 'password' => $password, 'devicetoken' => $devicetoken, 'createIp' => $_SERVER["REMOTE_ADDR"], 'createDate' => time()));
          return json_encode(['code' => '200', 'message' => '注册成功!', 'uid' => $uid]);
        }
    }

    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $result = Db::table('xc_user')->where('email',$email)->value('password');
        if ($result) {
          if ($password == $result) {
            # code...
            $result = Db::table('xc_user')->field('password',true)->where('email',$email)->find();
            return json_encode(['code' => '200', 'message' => '登录成功!', 'userInfo' => $result]);
          }else {
            # code...
            return json_encode(['code' => '400', 'message' => '密码错误!']);
          }
          # code...
        }else {
          # code...
          return json_encode(['code' => '500', 'message' => '用户不存在!']);
        }
    }

    public function uploadHeadImage()
    {
      $uid = $_POST["uid"];
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file('image');
      // 移动到框架应用根目录/public/uploads/ 目录下
      $info = $file->validate(['ext'=>'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'headimages');
      if($info){
          // 成功上传后 获取上传信息
          $savePath = $info->getSaveName();
          $filePath = config('ROOT_URL') .'headimages' . DS . $savePath;
          $result = Db::table('xc_user')->where('id', $uid)->update(['headimage' => $filePath]);
          if ($result) {
            # code...
            return json_encode(['code' => '200', 'message' => '上传成功!', 'userInfo' => $filePath]);
          }else {
            # code...
            return json_encode(['code' => '400', 'message' => '上传失败，请重试!']);
          }
      }else{
          // 上传失败获取错误信息
          return json_encode(['code' => '500', 'message' => '上传失败!']);
      }
    }

    public function updateInfo()
    {
      $uid = $_POST["uid"];
      $phone = $_POST["phone"];
      $nickname = $_POST["nickname"];
      $result = Db::table('xc_user')->update(['phone' => $phone, 'nickname' => $nickname, 'id' => $uid]);
      if($result){
          $result = Db::table('xc_user')->field('password,token',true)->where('id',$uid)->find();
          return json_encode(['code' => '200', 'message' => '修改成功!', 'userInfo' => $result]);
      }else {
            # code...
            return json_encode(['code' => '500', 'message' => '修改出错']);
      }
    }

    public function updatePassword()
    {
      $uid = $_POST["uid"];
      $oldpassword = $_POST["password"];
      $newpassword = $_POST["newpassword"];
      $password = Db::table('xc_user')->where('id',$uid)->value('password');
      if ($password == $oldpassword) {
        # code...
        $result = Db::table('xc_user')->where('id', $uid)->setField(['password' => $newpassword]);
        if ($result) {
          # code...
          return json_encode(['code' => '200', 'message' => '修改成功!']);
        }else {
          return json_encode(['code' => '500', 'message' => '修改失败!']);
        }
      }else {
        # code...
        return json_encode(['code' => '400', 'message' => '原始密码错误，请尝试其它方式']);
      }
    }

}



// http://localhost/xchat/public/index/user/getusers
// http://localhost/xchat/public/index/user/register
// http://localhost/xchat/public/index/user/uploadHeadImage
// http://localhost/xchat/public/index/user/updateInfo
// http://localhost/xchat/public/index/user/updatePassword
