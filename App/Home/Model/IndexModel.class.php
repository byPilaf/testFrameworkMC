<?php
namespace App\Home\Model;
use Frame\Libs\BaseModel;

class IndexModel extends BaseModel
{
    /**
     * 获取所有数据
     */
    public function getAllData()
    {
        $sql = "SELECT * FROM manager";
        return  $this->pdo->fetchRows($sql);
    }
}