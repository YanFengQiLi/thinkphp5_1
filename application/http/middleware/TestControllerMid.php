<?php

namespace app\http\middleware;

/**
 * Class TestIndexMid
 * @package app\http\middleware
 * 测试 控制器中间件
 */
class TestControllerMid
{

    public function handle($request, \Closure $next)
    {
        if ($request->param('name') != 'controller') {
            return redirect('index/Testmiddleware/hasErrorFuc');
        }

        return $next($request);
    }
}