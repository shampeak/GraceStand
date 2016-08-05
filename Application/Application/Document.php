<?php
namespace Application\Application;

class Document
{

    /*
    |--------------------------------------------------------------------------
    | 执行
    |--------------------------------------------------------------------------
    */
    public $path   = '';

    public $indextpl   = '';        //索引页模板
    public $artpl      = '';        //文章页模板

    //所有的资料库
    public $booklist   = [];        //
    public $booklistInfo   = [];        //

    public $lmlist     = [];        //
    public $arlist     = [];        //
    public $arlistInfo     = [];        //

//    //接收到的参数
    public $book        = '';        //
    public $lm          = '';        //
    public $ar          = '';        //
    public $arnr        = '';        //

    public function Depends()
    {
        return [
            'Application::Application\Application\Document'=>[
                'Server::Parsedown'
            ]
        ];
    }

    public function Run($path = '')
    {
        //初始化path
        if(empty($path))return false;
        $path = rtrim($path,'/').'/';
        $this->path     = $path;


        /**
        //设置基础信息
         * 包括 indextpl artpl
         * booiklist booklistinfo
         */
        $this->Ini();

        $this->book = strtolower(trim($_GET['book']));
        $this->doBook();          //对book参数进行判断和处理   //获取下面的lmlist

        //三个参数 book lm ar
        $this->lm   = strtolower(trim($_GET['lm']));
        $this->doLm();          //对lm参数进行判断和处理   //获取下面的arlist
        $this->doArlistInfo();          //arlist 读取文章的标题和内容

        $this->ar   = trim($_GET['ar']);
        $this->doAr();          //对lm参数进行判断和处理   //获取下面的arlist

        $this->Views();
    }

    public function Views()
    {
        /**
            1 : 有内容 ,则 内容模板
            2 : 没有内容 有lmlist 则lm模板
            3 : 其他 则book模板
         */
        $data = [
            'booklist'      => $this->booklist,
            'booklistInfo'  => $this->booklistInfo,
            'book'  => $this->book,
            'lm'    => $this->lm,
            'ar'    => $this->ar,
            'lmlist'=> $this->lmlist,
            'arlist'=>$this->arlist,
            'arlistInfo'=>$this->arlistInfo,
            'arnr'=>$this->arnr,
        ];

        extract($data);

        $entrancefile = $_SERVER['PHP_SELF'];

        if(!empty($data['ar']) || !empty($data['lm'])){
            $tpl =$this->path.'Lm.php';     //定位到文章显示和栏目显示
        }elseif(!empty($data['book'])){
            //定位到书籍列表
            $tpl =$this->path.'Book.php';     //定位到文章显示和栏目显示
        }else{
            $tpl =$this->path.'Index.php';     //定位到文章显示和栏目显示
        }

        if($_GET['tpl'] == 'oplist'){
            $tpl =$this->path.'Oplist.php';     //定位到文章显示和栏目显示
        }
        if($_GET['tpl'] == 'map'){
            $tpl =$this->path.'Map.php';     //定位到文章显示和栏目显示
        }
        if($_GET['tpl'] == 'depends'){
            $tpl =$this->path.'Depends.php';     //定位到文章显示和栏目显示
        }


        //print_r($data);
        include $tpl;

        exit;
    }


    public function doAr()
    {
        if(empty($this->ar))return false;
        $arpath =$this->path.$this->book.'/'.$this->lm.'/'.$this->ar;
        if(is_file($arpath)){
            $nr = file_get_contents($arpath);
            $nr = \Grace\Server\Server::getInstance()->make('Parsedown')->text($nr);
        }else{
            $this->ar = '';
            $nr = '';
        }
        $this->arnr = $nr;
    }

    public function doArlistInfo()
    {
        if(empty($this->arlist))return false;
        $lmpath =$this->path.$this->book.'/'.$this->lm.'/';


        //有具体文章,读取出文章标题,描述 和内容
        $arlistnr =  [];
        foreach($this->arlist as $value){
            $arfile     =  $lmpath.'/'.$value;
            $nr         = file_get_contents($arfile);
            $ar         = explode("\n",$nr);
            $arlistnr[strtolower($value)]['title'] = trim($ar[0],'#>');
            $arlistnr[strtolower($value)]['des'] = trim($ar[1],'#>');
        }
        $this->arlistInfo = $arlistnr;
        return true;
    }

    /**
     * 判断lm是否合理
     * 不合理 置空 合理 则 读取下面的文章列表
     */
    public function doLm()
    {
        if(empty($this->lm))return false;
        if(in_array($this->lm,$this->lmlist)){
            //读取lm下面的arlist 和 内容
            $lmpath =$this->path.$this->book.'/'.$this->lm.'/';
            //读取该目录下的文章列表

            $arlist = [];
            if(is_dir($lmpath)){
                $dirall = scandir($lmpath);
                foreach($dirall as $v) {
                    if ($v != '.' && $v != '..') {
                        if(strtolower(substr($v,-3)) == '.md')   $arlist[] = $v;
                    }
                }
            }
            $this->arlist = $arlist;

        }else{
            $this->lm = '';
        }
        return true;
    }

    /**
     * @return bool
     * 判断book是否合理 不合理 置空
     * 合理 读取下面的lmlist;
     */
    public function doBook()
    {
        if(empty($this->book))return false;
        if(in_array($this->book,$this->booklist)){
            //zhaodao
            //检索book下的lmlist 和lmlistinfo
            $bookpath = $this->path.$this->book.'/';        //OK,获取到book路径

            //扫描下面的文件夹
            $list = [];
            if(is_dir($bookpath)){
                $dirall = scandir($bookpath);
                foreach($dirall as $v) {
                    if ($v != '.' && $v != '..') {
                        if(is_dir($bookpath.$v))    $list[] = $v;
                    }
                }
            }
            $this->lmlist = $list;
        }else{
            $this->book = '';
        }
        return true;
    }

    public function Ini()
    {

        $this->booklist     = $this->booklist();
        $this->booklistInfo = $this->booklistInfo();        //读取title / description

    }

    /**
     * @return array
     * 读取目录下的index.json
     * 获取book信息
     */
    public function booklistInfo()
    {
        $list = [];
        foreach($this->booklist as $value){
            $file = $this->path.$value.'/index.json';
            $info = file_get_contents($file);
            $info = json_decode($info,true);
            $list[$value]['title'] = $info['title'];
            $list[$value]['description'] = $info['description'];
        }
        return $list;
    }

    /**
     * @return array
     * 读取目录下的文件夹,生成book列表
     */
    public function booklist()
    {

        //扫描下面的文件夹
        $list = [];
        if(is_dir($this->path)){
            $dirall = scandir($this->path);
            foreach($dirall as $v) {
                if ($v != '.' && $v != '..') {
                    if(is_dir($this->path.$v))    $list[] = $v;
                }
            }
        }
        return $list;
    }

}


