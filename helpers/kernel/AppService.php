<?php

namespace app\helpers\kernel;

class AppService
{
    /**
     * 配置后缀
     * @var string
     */
    protected $configExt = '.php';

    /**
     * App初始化
     * @return void
     */
    public static function run()
    {
        //注册一个自动加载函数方法
        spl_autoload_register('static::autoload');

        //获取请求方式
        $request_method = $_SERVER['REQUEST_METHOD'];

        //判断是否有ajax请求
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $ajax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
        } else {
            $ajax = false;
        }

        //请求类型常量的设置
        //POST常量
        define('IS_POST', ($request_method == 'POST') ? true : false);
        //GET常量
        define('IS_GET', ($request_method == 'GET') ? true : false);
        //AJAX常量
        define('IS_AJAX', ($ajax == 'xmlhttprequest') ? true : false);

        //路由规则处理
        static::router($_GET);

        //执行app中的应用
        static::load();
    }

    /**
     * 自动加载文件
     * @param $class
     * @return array|void
     */
    public static function autoload($class){
        //组合成一个完整的文件路径
        $file =  APP_PATH . str_replace('\\','/',$class) . (new AppService())->configExt;

        //判断这个文件是否存在,若存在就加载该文件
        if(is_file($file)){
            require $file;
        }else{
			return apiReturn(500, $file . '文件不存在！');
		}
    }

    /**
     * 测试
     * @return mixed
     */
    public static function test()
    {
        //命名空间的类名的拼装 'app\\index\\controllers\\Index';
        $class =  APP_NAME . '\\' . MODULE_NAME . '\\controllers\\' . CONTROLLER_NAME;
        $obj = new $class();
        $action = ACTION_NAME;
        return $obj->$action();
    }

    /**
     * 反射类
     * @return array|mixed
     * @throws \ReflectionException
     */
    public static function load()
    {
        //命名空间的类名的拼装 'app\\index\\controllers\\Index';
        $class =  APP_NAME . '\\' . MODULE_NAME . '\\controllers\\' . CONTROLLER_NAME;

        //使用反射类去执行这个类
        $ref = new \ReflectionClass($class);

        //判断控制器类中有没有方法,$_GET中的action所对应的名字的方法
        if ($ref->hasMethod(ACTION_NAME)) {
            //得到一个方法对象
            $method = $ref->getMethod(ACTION_NAME);

            //判断方法有没有参数
            if (count($method->getParameters()) > 0) {
                $args = [];
                //处理参数
                foreach ($method->getParameters() as $key => $val) {
                    if (!empty($_GET[$val->name])) {
                        $args[] = $_GET[$val->name];
                    }
                }
                //执行这个方法
                return $method->invokeArgs(new $class(), $args);
            } else {
                //直接执行类中的方法
                return $method->invoke(new $class());
            }
        } else {
            return apiReturn(500, $class . '方法不存在！');
        }
    }

    /**
     * 处理PATH_INFO路由
     * @param $get
     * @return void
     */
    public static function router($get)
    {
        //处理PATH_INFO
        if (isset($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
            $pathInfo = explode('/', trim($pathInfo, '/'));

            //模块名
            $get['module'] = array_shift($pathInfo);
            //控制器名
            $get['controller'] = array_shift($pathInfo);
            //方法名
            $get['action'] = array_shift($pathInfo);
        }

        //默认index
        define('MODULE_NAME', strtolower(empty($get['module']) ? 'index' : $get['module']));
        define('CONTROLLER_NAME', ucfirst(strtolower(empty($get['controller']) ? 'index' : $get['controller'])));
        define('ACTION_NAME', strtolower(empty($get['action']) ? 'index' : $get['action']));
    }
}