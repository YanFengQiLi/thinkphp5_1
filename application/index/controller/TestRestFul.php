<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * Class TestRestFul
 * @package app\index\controller
 *  测试资源控制器
 * 此控制器，是使用此命令创建的：    php think make:controller index/TestRestFul
 *
 * restful理解：
 *      概念：
 *          一种软件架构风格、设计风格，而不是标准，只是提供了一组设计原则和约束条件。
 *          它主要用于客户端和服务器交互类的软件。
 *          基于这个风格设计的软件可以更简洁，更有层次，更易于实现缓存等机制。
 *
 *      特点：
 *           1.资源通过URL来指定和操作。
 *           2.对资源的操作包括获取、创建、修改和删除，正好对应HTTP协议的GET、POST、PUT 和 DELETE 方法。
 *           3.连接是无状态性的。
 *           4.能够利用Cache机制来提高性能。
 *
 *      restful风格的 URL：
 *          请求类型    生成路由规则     对应操作方法
 *           GET	    myRestFul	        index
 *           GET	    myRestFul/create	create
 *           POST	    myRestFul	        save
 *           GET	    myRestFul/:id	    read
 *           GET	    myRestFul/:id/edit	edit
 *           PUT	    myRestFul/:id	    update
 *           DELETE	    myRestFul/:id	    delete
 *
 *      注意：
 *          这里的6个方法名称，必须叫这几个名字，否则会报错方法不存在
 */
class TestRestFul extends Controller
{
    /**
     * 显示资源列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $user = Db::name('huser')->field('huser_id,huser_name')->select();

        return json($user);
    }

    /**
     * 显示创建资源表单页.
     * @return string
     */
    public function create()
    {
        return '这是我创建资源列表的页面';
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->post();

        $num = Db::name('huser')->insert($data);

        if($num > 0){
            return json('创建成功');
        }else{
            return json('创建失败');
        }
    }


    /**
     * 显示指定的资源
     * @param $id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function read($id)
    {

        $details = Db::name('huser')->find($id);

        return json($details);
    }

    /**
     * 显示编辑资源表单页.
     * @param $id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($id)
    {
        $editDetails = Db::name('huser')->find($id);

        return json($editDetails);
    }


    /**
     * 保存更新的资源
     *
     * @param Request $request
     * @param $id
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function update(Request $request, $id)
    {
        $post = $request->param();

        $num = Db::name('huser')->where('huser_id',$id)->update($post);

        if($num > 0){
            return '更新成功';
        }else{
            return '更新失败';
        }
    }

    /**
     * 删除资源
     *
     * @param $id
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete($id)
    {
        $num = Db::name('huser')->delete($id);

        if($num > 0){
            return '删除成功';
        }else{
            return '删除失败';
        }
    }
}
