<?php

namespace app;

class Controllers
{
    //申明smarty变量
    private $smarty;

    public function __construct()
    {
        //引入smarty
        require ROOT_PATH . 'vendor/smarty/smarty/libs/Smarty.class.php';
        //实例smarty对象
        $this->smarty = new \Smarty();
        //是否使用缓存(项目在调试期间,不建议启用缓存)
        $this->smarty->caching = config('SMARTY_CACHE');
        //设置模板目录
        $template_dir = APP_PATH . MODULE_NAME . '/views/';
        if (!is_dir($template_dir)) mkdirs($template_dir);
        $this->smarty->template_dir = $template_dir;
        //设置编译目录
        $compile_dir = ROOT_PATH . 'runtime/templates/' . MODULE_NAME . '/';
        if (!is_dir($compile_dir)) mkdirs($compile_dir);
        $this->smarty->compile_dir = $compile_dir;
        //缓存文件夹
        $cache_dir = ROOT_PATH . 'runtime/smarty_cache/' . MODULE_NAME . '/';
        if (!is_dir($cache_dir)) mkdirs($cache_dir);
        $this->smarty->cache_dir = $cache_dir;

        //$this->smarty->setConfigDir(config('TPL_PARSE_VAL'));
    }

    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $tpl = '';
        //判断有没有默认模板后缀
        if (strpos($template, config('DEFAULT_TPL_SUFFIX'))) {
            $tpl = $template;
        } else {
            //拼接后缀
            $tpl = $template . config('DEFAULT_TPL_SUFFIX');
        }
        if (is_null($template)) {
            //判断是否为空 默认文件拼接后缀
            $tpl = ACTION_NAME . config('DEFAULT_TPL_SUFFIX');
        }

        $this->smarty->display($tpl, $cache_id, $compile_id, $parent);
    }

    public function assign($tpl_var, $value = null, $nocache = false)
    {
        $this->smarty->assign($tpl_var, $value, $nocache);
    }

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