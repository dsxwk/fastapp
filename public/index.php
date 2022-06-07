<?php

require __DIR__ . '/../vendor/autoload.php';

//应用名称
define('APP_NAME', 'app');

//项目根目录
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../') . '/');

//应用目录
define('APP_PATH', ROOT_PATH . 'app/');

//引入核心服务
//require ROOT_PATH . 'helpers\kernel\Run.php';

//运行框架
//helpers\kernel\Run::start();

require ROOT_PATH . 'helpers\kernel\service\App.php';

//运行框架
(new helpers\kernel\service\App())->run();

//绑定容器
/*$obj = (new helpers\kernel\service\App())->bind('db', 'helpers\kernel\orm\Db');
var_dump($obj);*/

//获取容器
/*$obj = (new helpers\kernel\service\App())->get('db');
var_dump($obj->first());*/
