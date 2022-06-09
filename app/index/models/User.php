<?php

namespace app\index\models;
use helpers\kernel\orm\Model;

class User extends Model{
    protected $dbConfig = 'default';
    protected $type = 'pdo';
    protected $table = 'user';

    /**
     * 测试
     * @return mixed
     * @throws \helpers\exception\Exception
     */
    public static function test()
    {
        $_this = new self();
        echo 'model user test' . PHP_EOL;
        //return app('db')->first();
        $result = $_this->first();
        return $result;
    }
}