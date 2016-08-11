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
    | ִ��
    | ����ִ��ģʽ
    | ������ �� ��������
    |--------------------------------------------------------------------------
    */
    public static function Run($routerstr = '',$request = [])
    {
        if(empty($routerstr)){
            $routerar = \Grace\Req\Uri::getInstance()->getar();
            $routerar[0] = $routerar[0]?:'Welcome';
            $routerar[1] = $routerar[1]?:'Home';
            $routerar[2] = $routerar[2]?:'Index';
            $routerstr = implode('/',$routerar);
        }
        $request = $request?:array_merge($_GET, $_POST);
        if(!Model('RouterAdd')->isAddonsstr($routerstr))    die("error!!");
        //���������ֶκ�request���е���
        $res = self::getInstance()->routerRun($routerstr,$request)->RouterRunController();
        return $res;
    }

    /**
     * @param       $routerstr  ·���ֶ�
     * @param array $request    request����
     */
    public function routerRun($routerstr,$request = [])
    {
        dc(server()->Config('Config')['Config']);   //����dc������
        $this->approot = $approot =  __DIR__.'/';

        //��·���ֶν��н���
        $routerstr = explode('/',trim($routerstr,'/'));
        $module     = $routerstr[0]?:'Welcome';
        $controller = $routerstr[1]?:'Home';
        $mothed     = $routerstr[2]?:'Index';
        $params     = $routerstr[3];

        $req = server('req');
        req([                   //req ����ģ��
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

        return $this;
    }

    public function RouterRunController()
    {
        $router = req('Router');

        //��������Ŀ¼
        $basepath =        $this->approot.$router['module'].'/Controller/';

//·�����ݺϷ��Լ��
        if (!preg_match('/^[0-9a-zA-Z]+$/',$router['controller']) || !preg_match('/^[0-9a-zA-Z]+$/',$router['mothed']))
        {
            halt('router error1');
        }
        if (!preg_match('/^[a-zA-Z]+$/',substr($router['controller'],0,1)) || !preg_match('/^[a-zA-Z]+$/',substr($router['mothed'],0,1)))
        {
            halt('router error2');
        }
        $params = $router['params'];                                              //����

        /*
         * �������п��ܳ�Ϊ�ļ���������,���Ҽ���
         * */
//�������� just
        $_controller    = $router['controller'];

//������ just
        $_mothed       = $router['mothed'];

//����_ִ��
        $__mothedAction     = ($router['type'] == 'GET')?($router['Prefix'].$router['mothed']):($router['Prefix'].$router['mothed'].ucfirst(strtolower($router['type'])));
        $__mothedActionbk   = ($router['type'] == 'GET')?($router['Prefix'].$router['mothed'].'_'.$params):($router['Prefix'].$router['mothed'].'_'.$params.ucfirst(strtolower($router['type'])));

//������_ִ��
        $__controllerAction = '\Addons\Controller\\'.$router['controller'];

//���ػ��� - ����������,�����
        $file = $basepath.$_controller.'/BaseController.php';
        includeIfExist($file);

        //controller/action.php
        $file = $basepath.$_controller.'/'.$_mothed.'.php';
        includeIfExist($file);
        $_file[] = $file;

        if(!method_exists($__controllerAction, $__mothedActionbk) && !method_exists($__controllerAction, $__mothedAction)) {
            //û��Ѱ�ҵ�,���� controller/controller.php
            $file = $basepath.$_controller.'/'.$_controller.'.php';
            $_file[] = $file;
            includeIfExist($file);
        }

//�����û��
//������
        if(!method_exists($__controllerAction, $__mothedActionbk) && !method_exists($__controllerAction, $__mothedAction)) {
            //û���ҵ�ִ�з���
            //ִ��404;
            echo 'Miss file : <br>',$__controllerAction,'::'.$__mothedAction;
            echo '<br>or : ',$__controllerAction,'::'.$__mothedActionbk;
            D($_file);
        }

//ʵ����
        $controller = new $__controllerAction();

        if(method_exists($__controllerAction, $__mothedActionbk)) {
            return $controller->$__mothedActionbk($params);         //ִ�з���
        }else{
            return $controller->$__mothedAction($params);         //ִ�з���
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
