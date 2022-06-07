<?php

//配置文件

return [
    //调试模式
    'APP_DEBUG' => true,
    //是否使用缓存(项目在调试期间,不建议启用缓存)
    'SMARTY_CACHE' => true,
    //默认url模式 default|path_info 默认 path_info
    'DEFAULT_URL_MODE' => 'path_info',
    //smarty模板后缀名
    'DEFAULT_TPL_SUFFIX' => '.html',

    'PROVIDERS' => [
        'db' => helpers\kernel\orm\Db::class,
    ]
];