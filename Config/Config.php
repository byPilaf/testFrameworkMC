<?php
/**
 * 配置文件
 */
return array (
    /**
     * 数据库配置
     */
    'db_type' => 'mysql',
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_user' => 'root',
    'db_pass' => 'root',
    'db_name' => 'test',
    'db_charSet' => 'utf8mb4',

    /**
     * 默认路由参数
     */
    'default_platform' => 'Home',        //默认平台
    'default_controller' => 'Index',    //默认控制器
    'default_action' => 'index',        //默认方法
);