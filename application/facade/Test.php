<?php
namespace app\facade;

use think\Facade;

/**
 * Class Test
 * @package app\facade
 * 说明：
 * 1、此类是为了提供给 common/Test.php 作为一个静态代理类，
 * 2、这个类名不一定要和Test类一致，但通常为了便于管理，建议保持名称统一
 * 3、只要这个类，继承了 think\Facade ,就可以使用静态方式调用动态方法
 *
 * 总结：说的直白一点，Facade功能可以让类无需实例化而直接进行静态方式调用。
 */
class Test extends Facade{

    protected static function getFacadeClass()
    {
        return 'app\common\Test';
    }

}