<?php

namespace app\index\controllers;
use app\Controllers;
use app\index\models\User;

class Index extends Controllers {
    public function index()
    {
        $this->response(apiReturn());
        //$res = User::test();dd($res);
        //echo 111;
        //return User::test();
    }
}