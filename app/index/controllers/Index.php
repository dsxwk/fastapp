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
        $result = User::test();
        $this->assign('test', $result->id);
        $this->display('index');

        //dd(config('default_tpl_suffix'));
        //$this->response(apiReturn());
        //$res = User::test();dd($res);
        //echo 111;
        //return User::test();
    }
}