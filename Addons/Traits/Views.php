<?php
namespace App\Addons\Traits;

/**
 * Created by PhpStorm.
 * User: shampeak
 * Date: 2016/7/17
 * Time: 3:39
 * 视图部件
 */
trait Views{

    public $Views = null;

    public function gv()
    {
        if(empty($this->Views))$this->Views = new \App\Addons\Views();
        return $this;
    }

    public function assign($key=null,$value = array()){
        $this->gv();
        $this->Views->assign($key,$value);
    }

    public function display($tpl = '',$data=array()){
        $this->gv();
        $this->Views->display($tpl,$data);
    }

    public function fetch($tpl = '',$data=array()){
        $this->gv();
        $this->Views->fetch($tpl,$data);
    }


}