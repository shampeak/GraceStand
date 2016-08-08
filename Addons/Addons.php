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




    public  function uriRun()
    {
        Addons::getInstance()->Router($routerstr,$request)->Run();
    }




    public function Router($routerstr,$request = [])
    {
        return $this;
    }


}

/*
## Addons的调用接口
### 实例化
Addons\Addons::getInstance();
Addons\Addons::getInstance()->Router($router,$request)->uriRun();;

### 两种执行方法
Addons\Addons::getInstance()->Run();   //地址栏进行路由
//      ->Router($router)->uriRun();;

Addons\Addons::getInstance()->Run($router);;     //手动路由
//      ->Router($router)->uriRun();;


### 中间参数查看
```
//config
Addons\Addons::getInstance()->getConfig();;
//router
Addons\Addons::getInstance()->getRouter();;
//setup
Addons\Addons::getInstance()->getSetup();;
//可以被返回的数据
Addons\Addons::getInstance()->getData();;
```
*/