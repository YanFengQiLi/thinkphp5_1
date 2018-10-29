<?php

namespace app\common;

/**
 * Class Show
 * @package app\common
 * 不通过 getFacadeClass 显式定义要代理的类，而是通过 公共的应用函数文件统一进行绑定
 * (绑定代码写在 app/common.php)
 */
class Show
{

    public function showMyAge($age)
    {
        return 'My age is' . $age;
    }
}