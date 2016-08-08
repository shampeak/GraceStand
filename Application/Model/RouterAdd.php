<?php
namespace Application\Model;

class RouterAdd
{
    //$f = Model('RouterAdd')->isAddons();
    /*
    |--------------------------------------------------------------------------
    | 判断是否addons
    |--------------------------------------------------------------------------
    */
    public static function isAddons()
    {
        //配置信息
        $config = server()->Config('Config')['Addons'];
        //路由信息
        $arr = \Grace\Req\Uri::getInstance()->getar();
        $beginstr = $arr[0];
        //是否匹配
        if(in_array($beginstr,$config)){
            return true;
        }else{
            return false;
        }
    }

    public static function isAddonsstr($str = '')
    {
        //配置信息
        $config = server()->Config('Config')['Addons'];
        //路由信息
        $arr = explode('/',trim($str,'/'));
        //$arr = \Grace\Req\Uri::getInstance()->getar();
        $beginstr = ucfirst(strtolower($arr[0]));
        //是否匹配
        if(in_array($beginstr,$config)){
            return true;
        }else{
            return false;
        }
    }

}


