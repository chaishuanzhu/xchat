<?php
namespace app\index\controller;
use think\Db;
class User
{
    public function getusers()
    {
        $users = Db::table('user')->select();
        return json_encode(['code' => '200', 'message' => 'success!', 'users' => $users]);
    }


    public function hello()
    {
        return 'hello';
    }
}
