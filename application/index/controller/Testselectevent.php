<?php
namespace app\index\controller;

use think\Controller;
use think\Db;


class Testselectevent extends Controller{

    public function mySelect(){
        $result = Db::event('before_select','beforeMySelect');

        return json($result);
    }

    public function beforeMySelect(){
       return Db::name('User')->where('id','>',0)->select();
    }



}