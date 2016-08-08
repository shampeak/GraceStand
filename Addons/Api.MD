







## Api ##

>调用Api

//通过index.php进行调用
```
Addons\Bootstrap::run();
```

//程序内部进行调用
```
Addons\Bootstrap::routerRun('user/home/index',['user'=>'irones']);
```

入口控制
```
if(Model('RouterAdd')->isAddons()){
    Addons\Bootstrap::run();
}else{
    App\Bootstrap::run();
}
```


## Addons的调用接口










 - 调用


- addons('demo)->view();    //显示 根据路由进行相应
- addons('demo)->widget();  //显示 根据路由进行显示






