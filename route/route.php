<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//use think\Route;


//  容器的自动注入
Route::get('autoUser/:id', 'index/Index/autoUser')->model('\app\index\model\User');

/**
 *  向单条路由中添加中间件
 *  1、可以是1个/多个
 *  2、执行顺序，就是数组的先后顺序
 *  3、可以是全局中间件
 */
Route::get('testMyMid/:name/:age', 'index/Testmiddleware/testMyMid')->middleware([
    'GlobalCheck', 'testMyMid_1', 'testMyMid_2'
]);

//  添加控制器中间件
Route::get('testControllerMid/:name','index/Testmiddleware/test_controller_mid');


//  路由跳转时的隐式传入参数--注意这种传参是不会再我们的 url 看到的
Route::get('testHiddenRoute/:name','index/Testmiddleware/testHiddenRoute?read=5');


/**
 *  定义资源控制器的路由
 *  注意：
 *      我的路由规则是：模块名/控制器名，并没有精确到方法名，
 *      这就代表着我可以通过这一条路由，来访问该控制器中的所有方法
 */
Route::resource('myRestFul','index/TestRestFul');


//  获取当前请求的变量
Route::post('testParam','index/Testinputrequest/testParam');


Route::get('myHeader','index/Testinputrequest/myHeader');

return [

];
