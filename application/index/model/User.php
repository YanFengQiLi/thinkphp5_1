<?php
namespace app\index\model;

use think\Model;

class User extends Model{

    /**
     * @param $query
     * 定义当前模型的全局的查询范围
     * 注意：
     *      1、方法名必须为base
     *      2、所谓的全局查询，指的是，你的所有方法中都会被加上 base 方法里，定义的查询条件
     */
    protected function base($query)
    {
        $query->where('status',1);
    }


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


    /**
     * @param $query
     * @return mixed
     * 范围查询-无参数：
     *      1、格式：scope + 驼峰式数据表字段名
     *      2、链式操作结尾处：不要加select() / find() 查询方法
     *      3、查询范围后面只能调用Db类的查询方法 不能调用模型的查询方法
     */
    public function scopeUserName($query){
        return $query->where('user_name','admin')->field('real_name');
    }

    /**
     * @param $query
     * @return mixed
     * 范围查询-无参数
     */
    public function scopeStatus($query){
        return $query->where('status',1)->field('real_name')->limit(10);
    }

    /**
     * @param $query
     * @param $roleId
     * @return mixed
     * 范围查询-有参数
     */
    public function scopeRoleId($query,$roleId){
        return $query->where('role_id','=',$roleId);
    }

    /**
     * @param $query
     * @param $time
     * @return mixed
     * 范围查询-有参数
     */
    public function scopeLastLoginTime($query,$time){
        return $query->whereTime('last_login_time',$time);
    }
}