<?php
namespace app\index\controller;
use think\Db;
class User
{
    public function getusers()
    {
        $users = Db::table('user')->field('password,token',true)->select();
        return json_encode(['code' => '200', 'message' => 'success!', 'users' => $users]);
    }


    public function hello()
    {
        return 'hello';
    }

    public function register()
    {
        $account = $_POST["account"];
        $password = $_POST["password"];
        $result = Db::table('user')->where('account',$account)->find();
        if ($result) {
          # code...
          return json_encode(['code' => '400', 'message' => '用户已存在!']);
        }else{
          $uid = Db::table('user')->insertGetId(array('account' => $account, 'password' => $password));
          return json_encode(['code' => '200', 'message' => '注册成功!', 'uid' => $uid]);
        }
    }

    public function login()
    {
        $account = $_POST["account"];
        $password = $_POST["password"];
        $result = Db::table('user')->where('account',$account)->value('password');
        if ($result) {
          if ($password == $result) {
            # code...
            $result = Db::table('user')->field('password',true)->where('account',$account)->find();
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
          $result = Db::table('user')->where('uid', $uid)->update(['headimage' => $filePath]);
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
      $sex = $_POST["sex"];
      $result = Db::table('user')->update(['phone' => $phone, 'nickname' => $nickname, 'sex' => $sex, 'uid' => $uid]);
      if($result){
          $result = Db::table('user')->field('password,token',true)->where('uid',$uid)->find();
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
      $password = Db::table('user')->where('uid',$uid)->value('password');
      if ($password == $oldpassword) {
        # code...
        $result = Db::table('user')->where('uid', $uid)->setField(['password' => $newpassword]);
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
