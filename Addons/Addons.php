<?php
namespace Addons;

/**
 * Class Addons
 * @package Addons
 * 调用
 *
 */
class Addons
{
    private static $_instance = null;

    /*
    |------------------------------------------------------------
    | 单例调用
    |------------------------------------------------------------
    //基础流程,执行条件 router , request , Config / Setup
    */
    public static function getInstance($config = []){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }


    public  function Run()
    {
        Addons::getInstance()->router()->Run();
    }

    public function Router()
    {
        return $this;
    }


}