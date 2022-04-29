<?php

namespace app;

class Controllers
{
    /**
     * 输出
     * @param $data
     * @return void
     */
    public function response($data)
    {
        echo is_string($data) ? $data : json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}