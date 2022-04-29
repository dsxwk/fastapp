<?php

//公共函数

if (!function_exists('dd')) {
    /**
     * 自定义打印输出
     * @param ...$val
     * @return void
     */
    function dd(...$val)
    {
        // 定义样式
        $str = '<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';

        // 如果是boolean或者null直接显示文字；否则print
        if (is_bool($val)) {
            $data = $val ? 'true' : 'false';
        } elseif (is_null($val)) {
            $data = 'null';
        } else {
            $data = print_r($val, true);
        }

        $str .= $data;
        $str .= '</pre>';
        echo $str;

        exit;
    }
}

if (!function_exists('pe')) {
    /**
     * 自定义打印输出
     * @return void
     */
    function pe()
    {
        $numargs = func_num_args();
        $arg_list = func_get_args();

        echo '<div style="border-bottom:1px solid gray;">';
        echo '<pre style="padding:10px;font-size:12px;color:gray;background:black;margin:0px;">';
        if ($numargs == 1) {
            print_r($arg_list[0]);
        } else {
            print_r($arg_list);
        }

        echo '</pre>';
        echo '</div>';
        exit;
    }
}

if (!function_exists('pr')) {
    /**
     * 自定义打印输出
     * @return void
     */
    function pr()
    {
        $argsNum = func_num_args();
        $argList = func_get_args();

        if ($argsNum == 1) {
            echo "\n", is_string($argList[0]) ? $argList[0] : json_encode($argList[0], JSON_UNESCAPED_UNICODE);
        } else {
            echo "\n", is_string($argList) ? $argList : json_encode($argList, JSON_UNESCAPED_UNICODE);
        }

        exit;
    }
}

if (!function_exists('apiReturn')) {
    /**
     * 自定义api返回 code = 0 成功 其他失败 默认0|1
     * @param $statusCode
     * @param string $message
     * @param $data
     * @param $code
     * @return array
     */
    function apiReturn($statusCode = 200, string $message = '', $data = [], $code = 0)
    {
        http_response_code($statusCode);
        return [
            'code' => ($statusCode != 200 && $code == 0) ? 1 : $code,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ];
    }
}

if (!function_exists('argsError')) {
    /**
     * 自定义参数错误返回
     * @param string $argsName
     * @return array
     */
    function argsError(string $argsName)
    {
        return apiReturn(400, '参数错误 ' . $argsName . '必传！', []);
    }
}

if (!function_exists('getFieldMax')) {
    /**
     * 获取指定字段最大值
     * @param $data
     * @param $field
     * @return mixed
     */
    function getFieldMax($data, $field)
    {
        $temp = [];
        foreach ($data as $k => $v) {
            $temp[] = $v[$field];
        }
        return max($temp);
    }
}

if (!function_exists('getFieldMin')) {
    /**
     * 获取指定字段最小值
     * @param $data
     * @param $field
     * @return mixed
     */
    function getFieldMin($data, $field)
    {
        $temp = [];
        foreach ($data as $k => $v) {
            $temp[] = $v[$field];
        }
        return min($temp);
    }
}

if (!function_exists('mkdirs')) {
    /**
     * 递归创建目录
     * @param $dir
     * @param string $mode
     */
    function mkdirs($dir, $mode = '0777')
    {
        mkdir($dir, $mode, true);
    }
}