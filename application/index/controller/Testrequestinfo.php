<?php
namespace app\index\controller;

use think\Controller;

/**
 * Class Testrequestinfo
 * @package app\index\controller
 *
 * 此控制器用来测试 request 请求信息
 */
class Testrequestinfo extends Controller{

    public function index(){
        //  获取当前访问域名或者IP    127.0.0.3
        $host = $this->request->host();

        //  当前访问协议      http
        $scheme = $this->request->scheme();

        //  当前访问的端口     80
        $port = $this->request->port();

        //  当前请求的REMOTE_PORT（远程端口）  50727
        $remote_port = $this->request->remotePort();

        //  请求页面时通信协议的名称和版本     HTTP/1.1
        $server_protocol = $this->request->protocol();

        //  内容类型,用于定义网络文件的类型和网页的编码，决定浏览器将以什么形式、什么编码读取这个文件
        $contentType = $this->request->contentType();

        //  当前包含协议的域名   http://127.0.0.3
        $domain = $this->request->domain();

        //  当前访问的子域名    127.0
        $subDomain = $this->request->subDomain();

        //  当前访问的泛域名
        $panDomain = $this->request->panDomain();

        //  当前访问的根域名    0.3
        $rootDomain = $this->request->rootDomain();

        //  当前完整URL /index/Testrequestinfo/index
        $url = $this->request->url();

        //  当前URL（不含QUERY_STRING）   /index/Testrequestinfo/index
        $baseUrl = $this->request->baseUrl();

        //  http://127.0.0.3/index/Testrequestinfo/index?id=4 当前请求的QUERY_STRING参数 id=4
        $query = $this->request->query();

        //  当前执行的文件 /index.php
        $baseFile = $this->request->baseFile();

        //  URL访问根地址
        $root = $this->request->root();

        //  URL访问根目录
        $rootUrl = $this->request->rootUrl();

        //  http://127.0.0.3/index/Testrequestinfo/index.html  当前请求URL的pathinfo信息（含URL后缀）   index/Testrequestinfo/index.html
        $pathInfo = $this->request->pathinfo();

        //  http://127.0.0.3/index/Testrequestinfo/index.html  请求URL的pathinfo信息(不含URL后缀)   index/Testrequestinfo/index
        $path = $this->request->path();

        //  http://127.0.0.3/index/Testrequestinfo/index.html  当前URL的访问后缀   html
        $ext = $this->request->ext();

        //  获取当前请求的时间   时间戳
        $time = $this->request->time();

        //  当前请求的资源类型   xml
        $type = $this->request->type();

        //  当前请求类型      GET
        $method = $this->request->method();
        dump($method);
    }
}