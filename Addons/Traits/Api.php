<?php
namespace App\Addons\Traits;

/**
 * Created by PhpStorm.
 * User: shampeak
 * Date: 2016/7/17
 * Time: 3:51
 * 通用部件
 */

trait Api{


    public function doApi(){
        //api 显示api


//非常好
//        $classname = '\App\Addons\BaseController';
//        $reflection = new \ReflectionClass($classname);
//        $doc = $reflection->getDocComment();
//        D($doc);


        //document 显示文档

        //获取help内容
        $dir = req('addonsRouter')['addonsroot'].'Api/';
        $list = $this->Model('scan')->getFile($dir);        //获取目录下的文件
        sort($list);        //排序

        //循环读取,分析
        $rs = array();
        foreach($list as $keyt=>$value){
            $res['file'] = $value;
//            $rcs = explode('-',$value);
//            if(count($rcs) ==1 ){
//                $res['chr'] = $rcs[0];
//            }else{
//                $res['chr'] = $rcs[1];
//            }
            //OK,huode chr

            $file = $dir.$value;
            $_nr = @file_get_contents($file);
            //获取第一行,第二行
            $nrs = explode("\n",$_nr);
            $res['title'] = str_replace("\r",'',$nrs[0]);
            $res['title'] = trim($res['title'],'#');
            //$res['description'] = str_replace("\r",'',$nrs[1]);
            //$res['nr'] = app('Parsedown')->text($nr);

            $rs[] = $res;
        }
        //D($rs);

        //根据file 读取文件
        if(req('Get')['adfile']){
            $file = $dir.req('Get')['adfile'];
            $nr = @file_get_contents($file);
            $nr = app('Parsedown')->text($nr);

        }


        $this->display('../../../Traits/Views/Api',[
            'rs' => $rs,
            'nr' => $nr
        ]);

    }


}