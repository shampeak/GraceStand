<?php


class Views{ // class start

    public function fetch($tpl = '',$data = array())
    {
        $path = req('addonsRouter')['addonsroot'].'Views/';
        //D(req('addonsRouter'));
        return app('smarty')->path($path)->router([
            'controller'=> req('addonsRouter')['controller'],
            'mothed'    => req('addonsRouter')['mothed'],
            'params'    => req('addonsRouter')['params'],
        ])->fetch($tpl,$data);
    }

    public function display($tpl = '',$data = array())
    {
        $path = req('addonsRouter')['addonsroot'].'Views/';


        //D(req('addonsRouter'));
        app('smarty')->path($path)->router([
            'controller'=> req('addonsRouter')['controller'],
            'mothed'    => req('addonsRouter')['mothed'],
            'params'    => req('addonsRouter')['params'],
        ])->display($tpl,$data);
    }

    public function assign($key = null, $value = [])
    {
        if(is_array($key)){
            app('smarty')->assign($key);
        }else{
            app('smarty')->assign($key,$value);
        }
    }

}
