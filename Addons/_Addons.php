<?php
namespace Addons;

/**
 * Class Addons
 * @package Addons
 * ����
 *
 */
class Addons
{
    private static $_instance = null;

    /*
    |------------------------------------------------------------
    | ��������
    |------------------------------------------------------------
    //��������,ִ������ router , request , Config / Setup
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
## Addons�ĵ��ýӿ�
### ʵ����
Addons\Addons::getInstance();
Addons\Addons::getInstance()->Router($router,$request)->uriRun();;

### ����ִ�з���
Addons\Addons::getInstance()->Run();   //��ַ������·��
//      ->Router($router)->uriRun();;

Addons\Addons::getInstance()->Run($router);;     //�ֶ�·��
//      ->Router($router)->uriRun();;


### �м�����鿴
```
//config
Addons\Addons::getInstance()->getConfig();;
//router
Addons\Addons::getInstance()->getRouter();;
//setup
Addons\Addons::getInstance()->getSetup();;
//���Ա����ص�����
Addons\Addons::getInstance()->getData();;
```
*/