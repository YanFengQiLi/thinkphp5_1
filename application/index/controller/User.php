<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User as UserModel;

class User extends Controller{

    protected $model = '';

    public function initialize()
    {
        $this->model = new UserModel();
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     *  范围查询：
     *      1、单个方法，无参数
     *      2、多个方法，使用逗号隔开，无参数
     *          sql: SELECT `real_name` FROM `sn_user` WHERE `user_name` = 'admin' AND `status` = 1 LIMIT 10
     *
     *      3、多个/单个方法，有参数，方法名必须是驼峰式命名，否则报错
     *          sql：SELECT * FROM `sn_user` WHERE  `role_id` = 1  AND `last_login_time` >= 0
     */
    public function demoNoParamScope(){

//        $result = UserModel::scope('UserName')->find();


//        $result = UserModel::scope('UserName,Status')->select();


        $result = UserModel::roleId(1)->lastLoginTime(0)->select();

        return json($result);
    }

    /**
     * @return mixed
     *
     *  动态关闭/开启全局查询访问
     *  注意：
     *      1、useGlobalScope()，当参数为 false : 关闭 ，当参数为 true : 开启(默认)
     *
     *      2、useGlobalScope()，不能后只能使用 Db 类的查询方法，不能使用模型类的查询方法 或者 自定义的查询方法
     */
    public function demoGlobalSelect(){

        $result = $this->model->useGlobalScope(false)->find(1);

        return $result;
    }
}