<?php

//定义常量
/**
 * 动态斜线
 */
define("DS",DIRECTORY_SEPARATOR);

/**
 * 网站根目录
 */
define("ROOT_PATH",getcwd().DS);

/**
 * 应用目录
 */
define("APP_PATH",ROOT_PATH."App".DS);

//包含框架初始类文件
require_once(ROOT_PATH."Frame".DS."Frame.class.php");

//调用框架初始化方法
Frame\Frame::run();