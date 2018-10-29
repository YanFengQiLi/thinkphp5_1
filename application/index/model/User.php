<?php
namespace app\index\model;

use think\Model;

class User extends Model{

    /**
     * @param $userId
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author zhenhong~
     * 查询单个用户
     */
    public function findUser($userId){
        return self::find($userId);
    }
}