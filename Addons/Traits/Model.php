<?php
namespace App\Addons\Traits;

/**
 * Created by PhpStorm.
 * User: shampeak
 * Date: 2016/7/17
 * Time: 3:39
 * 模型调用部件
 * $this->Model
 */
trait Model{

    public function Model($args = null){
        $model = new \App\Addons\Model();
        return $model->run($args);
    }

}