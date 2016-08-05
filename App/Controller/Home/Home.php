<?php
namespace App\Controller;


class Home extends BaseController {
    use \App\Traits\ViewSmarty;

    public function __construct(){
        parent::__construct();
    }

//    public function doIndex_ex()
//    {
//        echo 'ex';
//    }

    public function doIndex()
    {
        /*
         * 1 : йсм╪
         */
        view();
        exit;

    }

}
