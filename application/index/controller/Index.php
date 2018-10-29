<?php

namespace app\index\controller;

/**
 *  使用 think\facade 下配置类(5.1开始引入了 外观设计模式)
 *  Facade只负责静态代理 只要实例化的对象在容器里面 就只会实例化一次
 *
 *  此控制器，专门演示 容器与依赖注入
 */

//  使用 show 的静态代理类
use app\facade\Show;

//  facade 类库的 config类
use think\facade\Config;

//  使用 extend 目录下的 第三方类库
use myClassLib\testLibOne;

//  引入 user 模型
use app\index\model\User;

//  引入日志记录接口
use think\LoggerInterface;


class Index
{

    protected $user;

    /**
     * Index constructor.
     * @param User $user
     * 注意：
     *      1、这种写法就是利用---依赖注入的思想：使用正确的命名空间，引入对象的类，为此对象类起变量名，直接作为方法的参数
     *      2、依赖注入的对象参数支持多个，并且和顺序无关
     *      3、在使用依赖注入的时候，请不要使用 Facade 类作为类型约束，而是要使用其被代理的动态类
     *      {
     *          错误写法：
     *              use think\facade\App;
     *              public function index(App $app){}
     *
     *          正确写法：
     *              use think\App;
     *              public function index(App $app){}
     *      }
     * 使用场景：
     *      1、控制器架构方法
     *      2、控制器操作方法
     *      3、数据库和模型事件方法
     *      4、路由的闭包定义
     *      5、行为类的方法
     *
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \think\response\Json
     * 读取全部配置
     */
    public function index()
    {
        $config = Config::get();
        return json($config);
    }

    /**
     * @return string
     * 测试根目录下 extend 存放第三方类库
     */
    public function demo1()
    {
        $demo = new testLibOne();
        return $demo->testMyClassLibFuc();
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     * 测试 依赖注入，应用于构造方法
     */
    public function demo2()
    {
        $userInfo = $this->user->findUser(1);
        return json($userInfo);
    }


    /**
     *  容器概念的引入
     *
     *  1、绑定：
     *      依赖注入的类统一由容器进行管理，大多数情况下是在自动绑定并且实例化的。不过你可以随时进行手动绑定类到容器中，支持多种绑定方式
     *      (1)、绑定类标识（对已有的类库绑定一个唯一标识，便于快速调用），注意调用和绑定的标识必须一致
     *      (2)、绑定闭包
     *      (3)、绑定类的实例
     *      (4)、绑定至接口实现(对于依赖注入使用接口类的情况，我们需要告诉系统使用哪个具体的接口实现类来进行注入，这个使用可以把某个类绑定到接口)
     *      (5)、批量绑定(应用或者模块目录下面定义provider.php文件（返回一个数组），系统会自动批量绑定类库到容器中)
     *
     *  注意：
     *      (1)、系统已经内置绑定了核心常用类库，无需重复绑定
     *      (2)、绑定标识符，严格区分大小写，且要保证唯一性
     */
    public function demoContainerBind()
    {
        /**
         *  绑定类标识-法1:对已有类库绑定('类标识-自定义只要不冲突','要绑定类的命名空间')
         */
        //  绑定类库标识
        bind('cache', 'think\Cache');
        //  快速调用(自动实例化)
        $cache = app('cache');

        /**
         * 绑定类标识-法2：绑定类到容器(传入类的命名空间)
         */
        bind('myClassLib\testLibOne');

        $my = app('myClassLib\testLibOne');

        //dump($my->name);


        /**
         *  绑定闭包
         */
        bind('sayHello', function ($name) {
            return 'Hello,' . $name;
        });

        echo app('sayHello',['李四']);


        /**
         *  绑定类的实例
         */
        bind('myCache',new \think\facade\Cache());
        $myCache = app('myCache');


        /**
         *  绑定至接口实现--未成功
         */
        bind('think\LoggerInterface','think\Log');


        /**
         *  批量绑定
         */
        app('session_mine')->set('myName','李四');
        $name = app('session_mine')->get('myName');
        dump($name);
    }

    /**
     * @param LoggerInterface $log
     * @return mixed
     * 测试绑定至接口实现--未成功
     */
    public function demoBindInterFace(LoggerInterface $log){
       return $log->record('hello world');
    }

    /**
     *  对象化调用，容器中的实例
     *  可以在任何地方，使用 app() 助手函数，调用容器中的任何类
     */
    public function demoObjectRegister(){
        /**
         *  例1
         */
       /*$app = app();
       if(isset($app->cache)){
           echo '存在该对象实例';
       }else{
           echo '对象实例不存在';
       }
       //   注册容器对象实例
       $app->cache = \think\Cache::class;
       //   获取容器中的对象实例
       dump($app->cache);*/


       /**
        * 例2
        */
       // 绑定类到容器
       /*app()->test = new Test();
       //   实例调用
       $test = app()->test;
       dump($test);*/


       /**
        * 例3
        */
       $appName = app()->config->get('default_return_type');
       dump($appName);
    }

    /**
     *  自动注入:
     *  类的绑定操作不再使用Request对象而是直接注册到容器中，
     *  并且支持模型事件和数据库事件的依赖注入，
     *  依赖注入会首先检查容器中是否注册过该对象实例，
     *  如果有的话就会自动注入
     *
     *  通过 route.php 定义路由,将路由绑定到模型对象实例。
     *  注意：
     *      虽然路由中定义了必传参数，但是我不需要去在该方法的形参中去设置，
     *      也不需要在模型中设置查询
     */
    public function autoUser(){
        return  json($this->user);
    }


    /**
     *  添加静态代理后，调用 common/test 中的动态方法
     */
    public function hasFacadeClass(){
        echo \app\facade\Test::helloWorld('张三');
    }


    /**
     *  将静态代理，添加到公共函数文件中
     */
    public function noFacadeClass(){
        echo Show::showMyAge(16);
    }



}
