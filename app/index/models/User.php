<?php

namespace app\index\models;

class User {
    /**
     * 测试
     * @return mixed
     * @throws \helpers\exception\Exception
     */
    public static function test()
    {
        echo 'model user test' . PHP_EOL;
        return app('db')->first();
    }
}