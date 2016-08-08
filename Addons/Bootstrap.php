<?php
namespace Addons;

class Bootstrap
{
    private $_config              = array();
    public $middlewarelist        = array();
    public static $approot        = '';

    public static $addons        = null;

    public function __construct($config = array()){
        $this->_config = $config;
    }

    /*
    |--------------------------------------------------------------------------
    | 执行
    |--------------------------------------------------------------------------
    */
    public static function Run()
    {
        $routerar = \Grace\Req\Uri::getInstance()->getar();
        $routerar[0] = $routerar[0]?:'Welcome';
        $routerar[1] = $routerar[1]?:'Home';
        $routerar[2] = $routerar[2]?:'Index';
        $routerstr = implode('/',$routerar);
        return self::routerRun($routerstr);
    }


    /**
     * @param       $routerstr  路由字段
     * @param array $request    request参数
     */
    public static  function routerRun($routerstr,$request = [])
    {
        dc(server()->Config('Config')['Config']);   //建立dc数据流
        self::$approot = $approot =  __DIR__.'/';
        $request = $request?:array_merge($_GET, $_POST);

        //echo $routerstr;
        if(!Model('RouterAdd')->isAddonsstr($routerstr)){
            die("error!");
        }

        //对路由字段进行解析
        $routerstr = explode('/',trim($routerstr,'/'));
        $module     = $routerstr[0]?:'Welcome';
        $controller = $routerstr[1]?:'Home';
        $mothed     = $routerstr[2]?:'Index';
        $params     = $routerstr[3];

        $req = server('req');

        req([                   //req 数据模型
            'Get'   => $req->get,
            'Post'  => $req->post,
            'Env'   => $req->env,
            'Request'   => $request,
            'Router'=> [
                'type'      => $req->env['REQUEST_METHOD'],
                'module'    => ucfirst(strtolower($module)),
                'controller'=> ucfirst(strtolower($controller)),
                'mothed'    => ucfirst(strtolower($mothed)),
                'params'    => $params,
                'Prefix'    => 'do',
            ],
        ]);

        return self::RouterRunController();
    }

    public static  function Help()
    {

    }

    public static  function RouterRunController()
    {
        $router = req('Router');
        //控制器根目录
        $basepath =        self::$approot.$router['module'].'/Controller/';

//路由数据合法性检查
        if (!preg_match('/^[0-9a-zA-Z]+$/',$router['controller']) || !preg_match('/^[0-9a-zA-Z]+$/',$router['mothed']))
        {
            halt('router error');
        }
        if (!preg_match('/^[a-zA-Z]+$/',substr($router['controller'],0,1)) || !preg_match('/^[a-zA-Z]+$/',substr($router['mothed'],0,1)))
        {
            halt('router error2');
        }
        $params = $router['params'];                                              //参数

        /*
         * 这两个有可能成为文件单独存在,并且加载
         * */
//控制器名 just
        $_controller    = $router['controller'];

//方法名 just
        $_mothed       = $router['mothed'];

//方法_执行
        $__mothedAction     = ($router['type'] == 'GET')?($router['Prefix'].$router['mothed']):($router['Prefix'].$router['mothed'].ucfirst(strtolower($router['type'])));
        $__mothedActionbk   = ($router['type'] == 'GET')?($router['Prefix'].$router['mothed'].'_'.$params):($router['Prefix'].$router['mothed'].'_'.$params.ucfirst(strtolower($router['type'])));

//控制器_执行
        $__controllerAction = '\Addons\Controller\\'.$router['controller'];

//加载基类 - 如果基类存在,则加载
        $file = $basepath.$_controller.'/BaseController.php';
        includeIfExist($file);

        //controller/action.php
        $file = $basepath.$_controller.'/'.$_mothed.'.php';
        includeIfExist($file);
        $_file[] = $file;

        if(!method_exists($__controllerAction, $__mothedActionbk) && !method_exists($__controllerAction, $__mothedAction)) {
            //没有寻找到,尝试 controller/controller.php
            $file = $basepath.$_controller.'/'.$_controller.'.php';
            $_file[] = $file;
            includeIfExist($file);
        }

//如果还没有
//报错啦
        if(!method_exists($__controllerAction, $__mothedActionbk) && !method_exists($__controllerAction, $__mothedAction)) {
            //没有找到执行方法
            //执行404;
            echo 'Miss file : <br>',$__controllerAction,'::'.$__mothedAction;
            echo '<br>or : ',$__controllerAction,'::'.$__mothedActionbk;
            D($_file);
        }

//实例化
        $controller = new $__controllerAction();

        if(method_exists($__controllerAction, $__mothedActionbk)) {
            return $controller->$__mothedActionbk($params);         //执行方法
        }else{
            return $controller->$__mothedAction($params);         //执行方法
        }

    }

    public static  function customError($errno, $errstr, $errfile, $errline)
    {
        echo "<b>Custom error:</b><br> [$errno] $errstr<br />";
        echo " Error on line $errline <br>in $errfile<br />";
        echo "Ending Script";
        die();
    }

}

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