<?php
namespace App\Home\Controller;
use Frame\Libs\BaseController;
use App\Home\Model\IndexModel;

final class IndexController extends BaseController
{
    public function index()
    {
        //用db对象获取数据
        // $sql = "SELECT * FROM manager";
        // $data = $this->dbObj->getRows($sql);

        //用model获取数据
        $model = IndexModel::getInsetance();
        $data = $model->getAllData();
        
        echo json_encode($data);
    }
}