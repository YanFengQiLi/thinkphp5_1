<?php
namespace app\index\controller;


use think\Controller;
use think\facade\App as App;

class Testevent extends Controller{


    public function index(){
        $event = App::controller('TestMyEvent','event');

        echo $event->insert();
    }
}