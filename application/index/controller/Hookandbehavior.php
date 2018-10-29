<?php
namespace app\index\controller;

use think\Controller;

use think\facade\Hook;

/**
 * Class HookAndBehavior
 * @package app\index\controller
 *
 * 此控制器说明，钩子与行为
 *
 * 两者思想的理解：
 * 在框架执行过程中，例如一个路由的检测、用户权限检测等这些都成为行为，
 * 而不同的行为之间也具有位置共同性，比如，有些行为的作用位置都是在应用执行前，有些行为都是在模板输出之后，
 * 我们把这些行为发生作用的位置称之为钩子，当应用程序运行到这个钩子的时候，就会被拦截下来，统一执行相关的行为，
 * 类似于AOP编程中的“切面”的概念，给某一个钩子绑定相关行为就成了一种类AOP编程的思想。
 *
 * 注意：
 *  一个钩子可以注册多个行为，执行到某个钩子位置后，会按照注册的顺序依次执行相关的行为。
 * 但在某些特殊的情况下，你可以设置某个钩子只能执行一次行为，
 * 又或者你可以在一个钩子的某个行为中返回false来强制终止后续的行为执行；一个行为可以同时注册到多个不同的
 *
 * AOP编程思想:----变相的来讲就是，观察者的设计模式
 *      AOP:这种在运行时，动态地将代码切入到类的指定方法、指定位置上的编程思想就是面向切面的编程。
 *
 *
 *      通俗的理解：
 *          把逻辑代码和琐碎事务分开         这样我们要加一个其他的琐碎事务就非常方便
 *            (面,配菜及酱料分开)                        (加一个配菜很简单)
 *           拌好的5碗杂酱面,口味无法改变就这5种
 *           分开的5份面,配菜,酱料.  想怎么换口味就怎么换口味.
 *
 *      关键词解释：
 *         1、切面：切入到指定类指定方法的代码片段
 *         2、切入点：切入到哪些点、哪些方法
 *
 */
class Hookandbehavior extends Controller{


    public function index(){

        Hook::add('test_1','app\\index\\behavior\\Test');
        Hook::add('test_2','app\\index\\behavior\\Test');

        // 调用设置了钩子的函数来触发钩子，进行测试
        $this->test_1();
        $this->test_2();
    }

    public function test_1(){
        // 设置钩子test_1
        Hook::listen('test_1',['name'=>'test_1']);
    }

    public function test_2(){
        // 设置钩子test_1
        Hook::listen('test_2',['name'=>'test_2']);
    }
}