<?php

namespace app\http\middleware;
/**
 * Class CheckTestMiddleware
 * @package app\http\middleware
 * 这个类文件是使用：php think make:middleware CheckTestMiddleware 指令生成的
 * 此类说明中间件的使用：
 *      1、中间件的入口执行方法必须是handle方法，而且第一个参数是Request对象，第二个参数是一个闭包。
 *      2、handle 方法的返回值必须是一个 response 对象
 */
class CheckTestMiddleware_1
{
    public function handle($request, \Closure $next)
    {
        $params = $request->param();

        if ($params['age'] != 10) {
            return redirect('index/Testmiddleware/hasErrorFuc');
        }

        return $next($request);
    }
}
