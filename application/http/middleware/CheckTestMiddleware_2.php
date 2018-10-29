<?php

namespace app\http\middleware;

/**
 * Class CheckTestMiddleware_2
 * @package app\http\middleware
 * 测试为同一条路由绑定多个中间件
 */
class CheckTestMiddleware_2
{
    public function handle($request, \Closure $next)
    {
        $length = strlen($request->param('name'));

        if($length < 3 ){
            return redirect('index/Testmiddleware/hasErrorFuc');
        }

        return $next($request);
    }
}
