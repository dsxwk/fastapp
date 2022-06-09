<?php

declare (strict_types=1);

namespace helpers\kernel\service;

use helpers\exception\Exception;
use Closure;
use ReflectionClass;
use helpers\kernel\Run;

class App
{
    //应用版本号
    const APP_VERSION = 'v1.0';

    //注册映射
    private $binds = [];

    //缓存类反射对象
    private $reflections = [];

    //类依赖缓存
    private $dependents = [];

    /**
     * 容器绑定标识
     * @var array
     */
    protected $bind = [];

    /**
     * 构造函数绑定容器
     * @throws \ReflectionException
     */
    public function __construct()
    {
        //把配置文件中的配置信息写入config()函数中去
        config(require ROOT_PATH . 'config/app.php');

        if (!empty(config('providers'))) {
            $providers = config('providers');
            foreach ($providers as $k => $v) {
                $this->bind($k, $v);
            }
        }
    }

    /**
     * 运行框架
     * @return void
     */
    public function run()
    {
        Run::start();
    }

    /**
     * 注册类声明
     * @param string $name 类别名
     * @param string|array|Closure $declaration 类声明定义
     * @param array $params 参数数组
     * @return void
     * @throws \ReflectionException
     */
    public function bind($name, $declaration)
    {
        $this->binds[$name] = $declaration;

        //获取类构造函数的参数列表，即实例化对象的依赖关系
        $this->setDependents($name);
    }

    /**
     * 获取类的实例化对象
     * @param $name
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function get($name, $params = null)
    {
        //确保已注册了类声明信息
        if (isset($this->binds[$name])) {

            //解决依赖,用于把构造函数里面的依赖对象进行实例化
            $this->resolveDependents($name);

            //DI(依赖注入):把准备好的构造函数的参数列表数组通过反射的方法注入到类的构造函数中,进行对象实例化IOC(控制反转): 通过容器来实例化对象,并返回
            $ref = $this->reflections[$name];

            return $ref->newInstanceArgs($this->dependents[$name]);
        } else {
            //Code：当未注册到容器，则直接实例化对象
            throw new Exception("Not found " . $name . " from container", 500);
        }
    }

    /**
     * 设置类的依赖,并保存ReflectionClass对象
     * @param $name
     * @return void
     * @throws \ReflectionException
     */
    public function setDependents($name)
    {
        if (!isset($this->dependents[$name])) {
            $ref = new ReflectionClass($this->binds[$name]);

            //缓存类的ReflectionClass对象
            $this->reflections[$name] = $ref;

            //通过反射获取类的构造函数参数信息列表,简称为依赖,并缓存依赖信息
            $constructor = $ref->getConstructor();
            if (!is_null($constructor)) {
                $params = $constructor->getParameters();
                $this->dependents[$name] = $params;
            } else {
                $this->dependents[$name] = [];
            }
        }
    }

    /**
     * 解析依赖
     * @param $name
     * @return void
     * @throws Exception
     */
    public function resolveDependents($name)
    {
        if (isset($this->dependents[$name])) {
            $dependents = $this->dependents[$name];
            foreach ($dependents as $k => $v) {
                //如果不为NULL，则表示这个参数是一个类,接口,则进行实例化
                if ($v->getClass() != null) {
                    $this->dependents[$name][$k] = $this->get($v->getName());
                }
            }
        }
    }
}