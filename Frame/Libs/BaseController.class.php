<?php
namespace Frame\Libs;
use Frame\Libs\Db;
/**
 * 基础控制器类
 */
abstract class BaseController
{
    /**
     * Db对象
     */
    protected $dbObj;
    public function __construct()
    {
        //创建Db对象
        $this->dbObj = Db::setDbInstance($GLOBALS['config']['db_host'],$GLOBALS['config']['db_port'],$GLOBALS['config']['db_user'],$GLOBALS['config']['db_pass'],$GLOBALS['config']['db_name'],$GLOBALS['config']['db_charSet']);
    }
}
