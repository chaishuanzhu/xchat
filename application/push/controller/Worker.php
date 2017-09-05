<?php

namespace app\push\controller;

use think\worker\Server;

class Worker extends Server
{
//public    $socket = 'tcp://0.0.0.0:2346';
    protected $socket = 'tcp://0.0.0.0:2346';
public    $global_uid = 0;
    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        global $socket;
        foreach($socket->connections as $conn)
        {
            $conn->send("user[{$connection->uid}] said: $data\n");
        }
        echo "senddata : $data";
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
      var_dump($socket);
        global $socket, $global_uid;
        // 为这个连接分配一个uid
        $connection->uid = ++$global_uid;

        echo "connect success! uid = $connection->uid";
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        global $socket;
        foreach($socket->connections as $conn)
        {
            $conn->send("user[{$connection->uid}] logout");
            echo "close! uid = $connection->uid";
        }

    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {

    }
}
