<?php
namespace app\index\behavior;

/**
 * Class Test
 * @package app\index\behavior
 * 定义行为的入口方法:
 *      1、直接使用默认的方法名称: run() 方法
 *
 *      2、如果要变更，默认的入口方法名称，需要在 application/common.php 应用函数公共文件下
 *         添加如下代码： Hook::portal('自定义的方法名称');
 */
class Test{

    public function run($params){
        //  行为逻辑
        echo $params['name'].'钩子执行了方法'."<br>";
    }
}