<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

/**
 * Class Testmiddleware
 * @package app\index\controller
 * 此控制器，用于测试路由中间件
 */
class Testmiddleware extends Controller
{
    /**
     * @var array
     * 使用控制器中间件 与 模块中间件：
     *  1、控制器必须继承 Controller,
     *  2、在当前控制器定义属性 $middleware = ['中间件名称']
     *      2.1、可以为专门的方法，绑定中间件，而不是全部方法
     *  3、在对应模块下，定义 middleware.php 文件，他的优先级最高------叫做模块中间件
     *
     * 特别注意：
     *      1、如果在当前控制器，设置了 $middleware = [
     *             '中间件名称' => [
     *                  'only' => ['方法名'], //  only 代表此中间件，只作用于这些方法上
     *                  'expect' => ['方法名'] //  expect 代表此中间件，除了以下几种方法，全部执行
     *              ],
     *             '中间件名称' //  作用在整个控制器当中
     *      ]
     *      2、查找路径：app\http\middleware\中间件名称！  如果找不到文件报错，控制器不存在
     *      3、方法名注意大小写：
     *                  查看 controller 源码得知，在 think\Request->action() 方法时，将我们的自定义的驼峰式方法名，全部转换成小写了，
     *                  所以，无论如何，也执行了控制器中间件。为防止此类事情的发生，我们直接将方法名小写并以下划线分隔就不会出错了
     */
    protected $middleware = [
        'TestControllerMid' => [
            'only' => ['test_controller_mid'],
            'expect' => ['testmymid,testhiddenroute']
        ]
    ];

    /**
     * @param $name
     * @param $age
     * @return string
     * 测试路由中间件
     */
    public function testMyMid($name, $age)
    {
        return 'My name is ' . $name . ', My age is ' . $age;
    }


    /**
     * @param $name
     * @return string
     * 测试控制器中间件
     */
    public function test_controller_mid($name)
    {
        return '这是' . $name . '控制器中间件';
    }


    /**
     * @param Request $request
     * @return string
     * 测试路由的额外参数---隐藏参数,此参数不会再 url 中显示
     *
     * 并且接受时只能使用 param() 或者 input() 去接受
     */
    public function testHiddenRoute(Request $request)
    {
        $params = $request->param();
        return '我接受到的额外参数是' . $params['read'] . '实际传递的参数是：' . $params['name'];
    }

    /**
     * @return string
     * 捕获异常后，中间件的错误，跳转地址
     */
    public function hasErrorFuc()
    {
        return '抱歉找不到，您请求的地址';
    }

}