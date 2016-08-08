<?php
namespace Addons\Controller;

class Home extends BaseController {

    use \Addons\Traits\Views;
    public function __construct(){
        parent::__construct();
    }

    public function doIndex()
    {


$res =  $this->display('uuuu',['name'=>"irones"]);

    }

}
