<?php
namespace Addons\Traits;

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

       //$approot
        if(empty($this->Views))$this->Views = server('Smarty')->path(\Addons\Bootstrap::getInstance()->approot.req('Router')['module'].'/Views/')->router(req('Router'));
        return $this;
    }

    public function assign($key=null,$value = array()){
        $this->gv();
        $this->Views->assign($key,$value);
    }

    public function display($tpl = '',$data=array()){
        $this->gv();
        return $this->Views->display($tpl,$data);
    }

    public function fetch($tpl = '',$data=array()){
        $this->gv();
        return $this->Views->fetch($tpl,$data);
    }


}