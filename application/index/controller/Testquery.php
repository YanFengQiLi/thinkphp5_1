<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Testquery extends Controller{

    /**
     * @return \think\response\Json
     */
    public function myQuery(){
        //  like查询-- 可以使用 where 传递第四个参数
//        $result = Db::name('User')->where('user_name','like',['%ad%','%tes%'],'OR')->select();

        /**
         *  whereLike() 与 whereNotLike() 是一组
         *  logic 使用 OR 时 存在 BUG
         *  SELECT * FROM `sn_user` WHERE (`user_name` LIKE '%ad%' AND `user_name` LIKE '%tes%')
         */
//        $result = Db::name('User')->whereLike('user_name',['%ad%','%tes%'],'or')->select();


          //  whereBetween()  与 whereNotBetween() 是一组
//        $result = Db::name('User')->whereBetween('id',[1,2])->select();


         /**
          *     whereNull() 与 whereNotNull() 是一组
          *     注意：如果使用链式操作的话，且要查询两个字段其中一个为 NULL 的情况，则需要将第二个 whereNull 的 logic 设置为 'OR' 即可
          *     sql：
          *     SELECT * FROM `sn_project` WHERE `pr_utime` IS NULL OR `pr_status` IS NULL
         */
//          $result = Db::name('Project')->whereNull('pr_utime')->whereNull('pr_status','OR')->select();


          //    whereExp() 表达式查询，可以写任何 SQL 支持的语法
//          $result = Db::name('User')->whereExp('user_name',"= 'admin' AND `user_name` <> 'test1' ")->select();


            //  使用行级锁
//          $result = Db::name('User')->where('id','=',1)->lock(true)->find();


            //  数据不存在返回空数组 不抛异常
            $result = Db::name('User')->where('user_name','1212')->failException(false)->find();

            return json($result);
    }


    public function timeQuery(){
        /*// 大于某个时间
        Db::name('Project')
            ->whereTime('pr_ctime', '>=', '1970-10-1')
            ->select();
        // 小于某个时间
        Db::name('Project')
            ->whereTime('pr_ctime', '<', '2000-10-1')
            ->select();
        // 时间区间查询
        Db::name('Project')
            ->whereTime('pr_ctime', 'between', ['1970-10-1', '2000-10-1'])
            ->select();
        // 不在某个时间区间
        Db::name('Project')
            ->whereTime('pr_ctime', 'not between', ['1970-10-1', '2000-10-1'])
            ->select();*/

        //  时间区间查询  没有指定结束时间的话，表示查询当天
        $result = Db::name('Project')
            ->whereBetweenTime('pr_ctime', '2018-06-01')
            ->select(false);
        echo $result;
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 高级查询
     */
    public function seniorQuery(){
        /**
         *  区间查询：
         *      1、区间查询的查询条件必须使用数组定义方式，支持所有的查询表达式
         *        SELECT * FROM `sn_user` WHERE ( `user_name` LIKE 'admin%' OR `user_name` LIKE '%王%' )
         *        AND ( `id` > 0 and `id` <> 10 ) LIMIT 1
         *
         *      2、查询构造器支持对同一个字段多次调用查询条件
         *      SELECT * FROM `sn_user` WHERE `name` LIKE '%admin%' AND `name` LIKE '%王%' AND `id` IN (1,2,3) AND `id` > 1 LIMIT 1
         */
        //  写法1：
        /*$result = Db::name('User')
            ->where('user_name',['like','admin%'],['like','%王%'],'OR')
            ->where('id',['>',0],['<>',10],'and')
            ->fetchSql(true)
            ->find();*/

        //  写法2：
        /*$result = Db::name('User')
            ->where('name', 'like', '%admin%')
            ->where('name', 'like', '%王%')
            ->where('id', 'in', [1, 2, 3])
            ->where('id', '>', 1)
            ->fetchSql(true)
            ->find();*/


        /**
         *  批量字段查询-1
         */
       /* $result = Db::name('User')
            ->where([
                ['user_name', 'like', 'admin%'],
                ['id', '>', 0],
                ['status', '=', 1],
            ])->select(false);*/


        /**
         *  批量字段查询-1
         *  多字段查询时，如果要使用 exp 查询的话，条件必须要使用 Db:raw('条件') 的形式
         */
        /*$result = Db::name('User')
            ->where([
                ['name', 'like', 'thinkphp%'],
                ['id', 'exp', Db::raw('>0')],
                ['status', '=', 1],
            ])->select(false);*/


        /**
         *  两个字段比较的查询条件 whereColumn
         *
         *  1、比较单个字段 whereColumn('字段1','条件','字段2')
         *
         *  2、比较多个字段    whereColumn([
         *          ['字段1','条件','字段2'],
         *          ['字段3','条件','字段4'],
         *      ])
         */
        /*$result = Db::name('Project')
            ->whereColumn('pr_utime','>','pr_ctime')
            ->select(false);*/

        $result = Db::name('Project')->whereColumn([
            ['pr_title', '=', 'pr_description'],
            ['pr_utime', '>=', 'pr_ctime']
        ])->select(false);
        echo $result;
    }


    /**
     *  动态查询
     *  whereFieldName      :    查询某个字段的值
     *  whereOrFieldName    : 	 查询某个字段的值
     *  getByFieldName      :    根据某个字段查询
     *  getFieldByFieldName :    根据某个字段获取某个值
     *
     *  注意：
     *      1、FieldName 表示数据表的实际字段名称的驼峰法表示
     *      形如 email = Email / nick_name = NickName
     */
    public function activeQuery(){
        /**
         *  whereFieldName
         *  sql :  SELECT * FROM `sn_user` WHERE `user_name` = 'admin' LIMIT 1
         */
//        $result = Db::name('User')->whereUserName('admin')->fetchSql(true)->find();

        /**
         *  whereOrFieldName
         *  sql: "SELECT * FROM `sn_user` WHERE  `user_name` = 'admin' OR `real_name` = '王涛ss'"
         */
//        $result = Db::name('User')->whereUserName('admin')->whereOrRealName('王涛ss')->select(false);

        /**
         *  getByFieldName
         *  sql : SELECT * FROM `sn_user` WHERE `user_name` = 'admin' LIMIT 1
         */
//        $result = Db::name('User')->getByUserName('admin');


        /**
         *  getFieldByFieldName
         *  sql : SELECT `real_name` FROM `sn_user` WHERE `user_name` = 'admin' LIMIT 1
         */
          $result = Db::name('User')->getFieldByUserName('admin','real_name');

          return json($result);
    }
}