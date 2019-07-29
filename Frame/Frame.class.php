<?php
//定义命名空间
namespace Frame;

/**
 * 框架初始类
 */
Final class Frame
{
    /**
     * 框架初始化方法
     */
    static public function run()
    {
        self::initCharSet();    //初始化字符集
        self::initConfig();     //读取配置文件
        self::initRoute();      //初始化路由参数
        self::initCount();      //初始化常量
        self::initAutoLoad();   //初始化自动加载
        self::initDispatch();   //初始化请求分发
    }

    /**
     * 初始化字符集
     */
    static private function initCharSet()
    {
        header("Content-Type:text/html;charset=utf-8");
    }

    /**
     * 初始化配置文件
     */
    static private function initConfig()
    {
        $GLOBALS['config'] = require_once(ROOT_PATH."Config".DS."Config.php");
    }

    /**
     * 初始化路由参数
     */
    static private function initRoute()
    {
        $p = isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['default_platform'];
        $c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
        $a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];

        /**
         * 平台参数
         * 前台Home
         * 后台Admin
         */
        define("PLANT",$p);

        /**
         * 控制器
         */
        define("CONTROLLER",$c);

        /**
         * 方法
         */
        define("ACTION",$a);
    }

    /**
     * 初始化常量
     */
    static private function initCount()
    {
        /**
         * 框架目录
         */
        define("FRAME_PATH",ROOT_PATH."Frame".DS);
    }

    /**
     * 初始化自动加载
     */
    static private function initAutoLoad()
    {
        //检测类名,若没有则调用函数
        spl_autoload_register(function($className){
            /*
                结合命名空间
                传递的类名 = 空间\类名
                $className = "App\Controller"
                真实的文件路径 $filename = "./App/Controller.class.php"
            */
            $fileName = ROOT_PATH.str_replace('\\',DS,$className).".class.php";
            //若类文件存在,则包含
            if(file_exists($fileName))
            {
                require_once($fileName);
            }
        });
    }

    /**
     * 请求分发
     */
    static private function initDispatch()
    {
        //(1)构建动态控制器类名称
        $controllerClassName = "App"."\\".PLANT."\\"."Controller"."\\".CONTROLLER."Controller";
        //(2)创建控制器类对象
        $controllerObj = new $controllerClassName;
        //(3)构建动态方法名称
        $actionName = ACTION;
        //(4)调用控制器方法
        $controllerObj->$actionName();
    }

}