<?php
namespace Frame\Vendor;
use PDO;
use Exception;
use PDOException;

/**
 * 封装PDO类
 */
final class PDOWrapper
{
     /**
     * 建立的pdo对象
     */
    private $pdo = NULL;

    /**
     * 数据库类型
     */
    private $db_type;

    /**
     * 数据库链接地址
     */
    private $db_host;

    /**
     * 数据库端口
     */
    private $db_port;

    /**
     * 数据库用户名
     */
    private $db_user;

    /**
     * 数据库密码
     */
    private $db_pass;

    /**
     * 数据库名称
     */
    private $db_name;

    /**
     * 数据库字符集
     */
    private $db_charSet;

    public function __construct()
    {
        $this->db_type = $GLOBALS['config']['db_type'];
        $this->db_host = $GLOBALS['config']['db_host'];
        $this->db_port = $GLOBALS['config']['db_port'];
        $this->db_user = $GLOBALS['config']['db_user'];
        $this->db_pass = $GLOBALS['config']['db_pass'];
        $this->db_name = $GLOBALS['config']['db_name'];
        $this->db_charSet = $GLOBALS['config']['db_charSet'];

        $this->createPDO();
        $this->setErrorMode();
    }

    /**
     * 创建PDO对象
     */
    private function createPDO()
    {
        try{
            $dsn = "{$this->db_type}:host={$this->db_host};port={$this->db_port};dbname={$this->db_name};charset={$this->db_charSet}";
            $this->pdo = new PDO($dsn,$this->db_user,$this->db_pass);
        }
        catch (Exception $e){
            echo "<h2>创建PDO对象失败<h2>";
            echo "code:".$e->getCode()."<br>";
            echo "line:".$e->getLine()."<br>";
            echo "file:".$e->getFile()."<br>";
            echo "msg:".$e->getMessage()."<br>";
        }
    }

    /**
     * 设置PDO报错方式
     */
    private function setErrorMode()
    {
        //设置PDO报错模式为异常模式
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 显示错误方法
     * @param object $e 错误对象
     */
    private function showError($e)
    {
        echo "<h2>执行sql语句失败<h2>";
        echo "code:".$e->getCode()."<br>";
        echo "line:".$e->getLine()."<br>";
        echo "file:".$e->getFile()."<br>";
        echo "msg:".$e->getMessage()."<br>";
    }

    /**
     * 执行非查询sql语句
     * @param string $sql 要执行的非查询sql语句
     * @return bool 执行结果
     */
    public function exec($sql)
    {
        try{
            return $this->pdo->exec($sql);
        }
        catch(PDOException $e){
            $this->showError($e);
        }
    }

    /**
     * 获取单行数据
     * @param string $sql 查询的sql语句
     * @return array 数据结果
     */
    public function fetchOneRow($sql)
    {
        try{
            $PDOStatement = $this->pdo->query($sql);
            return $PDOStatement->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $this->showError($e);
        }
    }

    /**
     * 获取多行数据
     * @param string $sql 查询的sql语句
     * @return array 数据结果
     */
    public function fetchRows($sql)
    {
        try{
            $PDOStatement = $this->pdo->query($sql);
            return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $this->showError($e);
        }
    }

    /**
     * 获取记录数
     * @param string $sql 获取记录数
     * @return int 获取记录数
     */
    public function rowsCount($sql)
    {
        try{
            $PDOStatement = $this->pdo->query($sql);
            return $PDOStatement->rowCount();
        }
        catch(PDOException $e){
            $this->showError($e);
        }
    }
}