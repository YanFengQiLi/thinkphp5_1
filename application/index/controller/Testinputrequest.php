<?php

namespace app\index\controller;

use think\Controller;

use think\facade\Request;

/**
 * Class Testinputrequest
 * @package app\index\controller
 *
 */
class Testinputrequest extends Controller
{

    /**
     *  获取当前请求的变量，官方推荐使用
     */
    public function testParam()
    {
        //  若不传递参数，也不会接受到，上传文件的传值
        $param1 = Request::param();

        //  获取当前请求的所有变量（原始数据）: 不通过过滤方法、且不会接受到上传文件
        $param2 = Request::param(false);

        //  获取当前请求的所有变量（包含上传文件）
        $param3 = Request::param(true);

        //  使用 php 内置的过滤函数，第三个参数：存在多个，可以使用字符串 或 数组 ！例如：'str1,str2,str3'或 [1,2,3]
        $param4 = Request::param('','',['trim']);

        //  使用 php 内置的过滤常量
        $param5 = Request::param('','','FILTER_VALIDATE_INT');
        return json($param5);
    }

    /**
     *  获取当前请求的HTTP请求头信息
     */
    public function myHeader(){
        $info = Request::header();
        return json($info);
    }

}