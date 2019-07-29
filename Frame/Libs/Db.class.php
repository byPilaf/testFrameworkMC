<?php
namespace Frame\Libs;

/**
 * 封装的数据库类
 * 单例模式
 */
final class Db
{
    /**
     * 存储建立的对象
     * 私有的 静态的
     */
    static private $obj;

    /**
     * 数据库链接对象
     */
    private $db_conn;

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

    /**
     * 初始化数据库
     * 构造方法
     * @param arrray $config 数据库信息
     */
    private function __construct($config = array())
    {
        $this->db_host = $config['db_host'];
        $this->db_port = $config['db_port'];
        $this->db_user = $config['db_user'];
        $this->db_pass = $config['db_pass'];
        $this->db_name = $config['db_name'];
        $this->db_charSet = $config['db_charSet'];
        $this->db_conn = $this->dbConnect();
        if(!$this->db_conn)
        {
            echo '数据库连接失败';
        }
    }

    /**
     * 关闭数据库
     * 析构方法
     */
    public function __destruct()
    {
        $this->dbClose();
    }

    /**
     * 防止克隆
     */
    private function __clone(){}
    
    /**
     * 连接数据库
     */
    private function dbConnect()
    {
        return mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name,$this->db_port);
    }
    
    /**
     * 关闭数据库连接
     */
    private function dbClose()
    {
        return mysqli_close($this->db_conn);
    }

    /**
     * 创建数据库连接
     * @param string $db_host 数据库主机地址
     * @param string $db_port 数据库端口
     * @param string $db_user 数据库用户名
     * @param string $db_pass 数据库密码
     * @param string $db_name 数据库名
     * @param string $db_charSet 数据库字符集
     * @return object 数据库连接单例对象
     */
    static public function setDbInstance($db_host = '127.0.0.1',$db_port = '3306',$db_user = 'root',$db_pass = 'root',$db_name = 'test',$db_charSet = 'utf8mb4')
    {
        $config = array(
            'db_host' => $db_host,
            'db_port' => $db_port,
            'db_user' => $db_user,
            'db_pass' => $db_pass,
            'db_name' => $db_name,
            'db_charSet' => $db_charSet,
        );

        //判断当前数据库类是否存在
        if(!self::$obj instanceof self)
        {
            //不存在则创建
            self::$obj = new self($config);
        }
        //返回对象
        return self::$obj;
    }

    /**
     * 重新设置数据库
     * @param string $db_name
     */
    public function setDbName($db_name)
    {
        $this->db_name = $db_name;
        return mysqli_select_db($this->db_conn,$this->db_name);
    }

    /**
     * 判断是否是查询类sql语句
     * @param string $sql 查询sql语句
     * @return bool 
     * true 是查询sql
     * false 不是查询sql
     */
    private function isSelectSql($sql)
    {
        $sql = strtolower($sql);
        if(substr($sql,0,6) === 'select')
        {
            //如果是查询语句
            return true;
        }
        else 
        {
            //不是查询语句
            return false;
        }
    }

    /**
     * 执行非查询sql语句
     * @param string $sql 非查询的sql语句
     * @return bool 执行结果
     */
    public function query(string $sql)
    {
        if($this->isSelectSql($sql))
        {
            //是查询sql
            return false;
        }
        else 
        {
            //不是查询sql
            return mysqli_query($this->db_conn,$sql);
        }        
    }

    /**
     * 执行的查询sql语句
     * @param string $sql 执行的查询sql语句
     * @return object 查询语句执行的结果集
     */
    private function getSelectResult($sql)
    {
        if($this->isSelectSql($sql))
        {
            //是查询sql
            return mysqli_query($this->db_conn,$sql);
        }
        else
        {
            //不是查询sql
            return false;
        }
    }

    /**
     * 获取一条数据
     * @param string $sql 查询数据sql语句
     * @param int $type 要返回的数据格式
     * @return array|null 查询的数据
     */
    public function getOneRow($sql,$type = MYSQLI_ASSOC)
    {
        return mysqli_fetch_array($this->getSelectResult($sql),$type);
    }

    /**
     * 获取多条数据
     * @param string $sql 查询数据的sql语句
     * @param int $type 要返回的数据格式
     * @return array|null 查询的数据
     */
    public function getRows($sql,$type = MYSQLI_ASSOC)
    {
        return mysqli_fetch_all($this->getSelectResult($sql),$type);
    }

    /**
     * 获取sql查询的条目数
     * @param string $sql 查询的sql语句
     * @return int 查询到的数据条目数
     */
    public function getCount($sql)
    {
        return mysqli_num_rows($this->getSelectResult($sql));
    }
}