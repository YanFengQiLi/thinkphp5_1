<?php

namespace app\index\event;


/**
 * Class TestMyEvent
 * @package app\index\event
 * 测试事件控制器
 */
class TestMyEvent
{

    public function insert()
    {
        return '我执行了event插入';
    }

    public function update($id)
    {
        return 'update:' . $id;
    }

    public function delete($id)
    {
        return 'delete:' . $id;
    }
}