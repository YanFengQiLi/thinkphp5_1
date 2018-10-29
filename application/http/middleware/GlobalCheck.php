<?php
namespace app\http\middleware;

/**
 * Class GlobalCheck
 * @package app\http\middleware
 * 测试全局中间件，只要在对应的路由规则里，写了该中间件名称就走该类
 */
class GlobalCheck{

    public function handle($request,\Closure $next){
        $param = $request->param();

        if($param['name'] != 'lisi'){
            return redirect('index/Testmiddleware/hasErrorFuc');
        }

        return $next($request);
    }
}