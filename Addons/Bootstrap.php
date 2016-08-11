<?php
namespace Addons;

class Bootstrap
{
    private $_config            = array();
    public $approot             = '';
    public static $_instance   = null;

    public function __construct($config = array()){
        $this->_config = $config;
    }

    public static function getInstance($config = []){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }

    /*
    |--------------------------------------------------------------------------
    | 执行
    | 两种执行模式
    | 带参数 和 不带参数
    |--------------------------------------------------------------------------
    */
    public static function Run()
    {

        $res = self::getInstance()->routerRun();

        return $res;

    }

    /**
     * @param       $routerstr  路由字段
     * @param array $request    request参数
     */
    public function routerRun()
    {
        dc(server()->Config('Config'));   //建立dc数据流

        $this->approot = $approot =  __DIR__.'/';       //like           E:\phpleague\Grace\GraceStand\Addons/

        $routerstr =         \Grace\Req\Uri::getInstance()->getar();

        //对路由字段进行解析
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

        return $this->RouterRunController();

    }

    public function RouterRunController()
    {
        $router = req('Router');

        //控制器根目录
        $basepath =        $this->approot.$router['module'].'/Controller/';

//路由数据合法性检查
        if (!preg_match('/^[0-9a-zA-Z]+$/',$router['controller']) || !preg_match('/^[0-9a-zA-Z]+$/',$router['mothed']))
        {
            halt('router error1');
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
