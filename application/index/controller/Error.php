<?php

namespace app\index\controller;

use think\Request;

/**
 * Class Error
 * @package app\index\controller
 *
 * 测试空控制器：作用就是用来处理找不到控制器
 *
 * 注意：
 *      1、这个控制器的名称：系统名称默认是Error,若要想改在 app.php 的配置文件中 empty_controller => '空控制器名称'
 *
 *      2、因为框架默认 访问的 controller---index  action---index ,所以在找不到控制器时，会走我们预先定义好的空控制器！
 *         再走类内部，默认访问的方法：index
 */
class Error
{
    /**
     * @param $name
     * @return string
     * 处理类内部的，空操作
     */
    public function _empty($name)
    {
        return $this->showCity($name);
    }

    /**
     * @param Request $request
     * @return string
     * 处理控制器
     */
    public function index(Request $request)
    {
        //  根据当前控制器来判断要执行 哪个城市的操作
        $cityName = $request->controller();

        return $this->city($cityName);
    }

    /**
     * @param $name
     * @return string
     * 注意： 这个方法必须是受保护的
     */
    protected function city($name)
    {
        return '对不起！无法找到' . $name . '控制器';
    }

    /**
     * @param $name
     * @return string
     * 调用处理空操作的空
     */
    protected function showCity($name)
    {
        return '对不起！找不到' . $name . '方法';
    }
}