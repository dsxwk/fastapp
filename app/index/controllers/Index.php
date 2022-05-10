<?php

namespace app\index\controllers;
use app\Controllers;
use app\index\models\User;

class Index extends Controllers {
    /**
     * 首页
     * @return void
     */
    public function index()
    {
        $test = User::test();
        $this->assign('test', $test);
        $this->display('index');

        //dd(config('DEFAULT_TPL_SUFFIX'));
        //$this->response(apiReturn());
        //$res = User::test();dd($res);
        //echo 111;
        //return User::test();
    }
}