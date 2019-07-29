<?php
namespace Frame\Libs;
use Frame\Vendor\PDOWrapper;

/**
 * 基础模型类
 */
abstract class BaseModel
{
    /**
     * PDO对象
     */
    protected $pdo = null;

    /**
     * 保存的模型类对象
     */
    static private $modelObjArr = array();

    public function __construct()
    {
        //创建PDDWrapper对象
        $this->pdo = new PDOWrapper;
    }

    /**
     * 创建模型类
     * @return object 创建的对象
     */
    public static function getInsetance()
    {
        //获取静态方式调用的类名
        //后期静态绑定
        $className = get_called_class(); //哪个类调用此方法的名称(双冒号之前的类名,空间加类名)[IndexModel]
        //判断要创建的对象是否存在
        if(empty(self::$modelObjArr[$className]))
        {
            self::$modelObjArr[$className] = new $className;
        }
        return self::$modelObjArr[$className];
    }
}