<?php

require __DIR__ . '/../vendor/autoload.php';

//应用版本号
const APP_VERSION = 'v1.0';

//应用名称
define('APP_NAME', 'app');

//项目根目录
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../') . '/');

//应用目录
define('APP_PATH', ROOT_PATH . 'app/');

//引入核心服务
require ROOT_PATH . 'helpers\kernel\AppService.php';

//运行框架
app\helpers\kernel\AppService::run();