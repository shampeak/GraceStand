<?php
namespace App\Addons\Traits;

/**
 * Created by PhpStorm.
 * User: shampeak
 * Date: 2016/7/17
 * Time: 3:51
 * 通用部件
 */

trait Help{


    public function doHelp(){


        //获取help内容
        $file = req('addonsRouter')['addonsroot'].'Help/Index.md';
        if(!is_file($file)){
            halt('miss file :'.$file);
        }
        $nr = @file_get_contents($file);
        $nr = app('Parsedown')->text($nr);
//D($nr);

        $this->display('../../../Traits/Views/help',[
            'nr'        => $nr
        ]);

    }


}