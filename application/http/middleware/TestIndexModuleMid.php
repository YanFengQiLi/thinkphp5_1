<?php

namespace app\http\middleware;

/**
 * Class TestIndexMid
 * @package app\http\middleware
 * 测试 模块中间件
 */
class TestIndexModuleMid
{

    public function handle($request, \Closure $next)
    {
        if ($request->param('name') != 'index') {
            return redirect('index/Testmiddleware/hasErrorFuc');
        }

        return $next($request);
    }
}