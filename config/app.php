<?php

//配置文件

return [
    //调试模式
    'app_debug' => true,
    //是否使用缓存(项目在调试期间,不建议启用缓存)
    'smarty_cache' => false,
    //默认url模式 default|path_info 默认 path_info
    'default_url_mode' => 'path_info',
    //smarty模板后缀名
    'default_tpl_suffix' => '.html',

    //服务提供者
    'providers' => [
        'db' => helpers\kernel\orm\Db::class,
    ],

    //数据库配置 目前暂只支持pdo方式连接
    'database' => [
        'mysql' => [
            'default' => [
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => 'root',
                'port' => '3306'
            ],

            //其他配置...
        ],
        'pdo' => [
            'default' => [
                'dsn' => 'mysql:dbname=blog;host=127.0.0.1;charset=utf8mb4;port=3306;',
                'username' => 'root',
                'password' => 'root',
                'options' => []
            ],

            //其他配置...
        ]
    ]
];