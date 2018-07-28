<?php
/**
 * Created by PhpStorm.
 * User: tioncico
 * Date: 2018/7/19
 * Time: 16:21
 */

namespace App\Base;

use EasySwoole\Config;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Http\Request;
use EasySwoole\Core\Http\Response;
use EasySwoole\Core\Http\Session\Session;
use think\Template;

class BaseController extends ViewController
{
    use Tool;
    protected $config;
    protected $session;

    public function __construct(string $actionName, Request $request, Response $response)
    {
        parent::__construct($actionName, $request, $response);
        $this->header();
    }

    public function defineVariable()
    {


    }

    protected function onRequest($action): ?bool
    {
        return parent::onRequest($action); // TODO: Change the autogenerated stub
    }

    public function init($actionName, $request, $response)
    {
        $class_name                         = static::class;
        $array                              = explode('\\', $class_name);
        $GLOBALS['base']['MODULE_NAME']     = $array[2];
        $GLOBALS['base']['CONTROLLER_NAME'] = $array[3];
        $GLOBALS['base']['ACTION_NAME']     = $actionName;

        $this->session($request, $response)->sessionStart();

        $_GET     = $request->getQueryParams();
        $_POST    = $request->getRequestParam();
        $_REQUEST = $request->getRequestParam();
        $_COOKIE  = $request->getCookieParams();

        $this->defineVariable();
        parent::init($actionName, $request, $response); // TODO: Change the autogenerated stub
    }

    public function header()
    {
        $this->response()->withHeader('Content-type', 'text/html;charset=utf-8');
    }

    /**
     * 首页方法
     * @author : evalor <master@evalor.cn>
     */
    public function index()
    {
        return false;
    }


    function session($request = null, $response = null): Session
    {
        $request == null && $request = $this->request();
        $response == null && $response = $this->response();
        if ($this->session == null) {
            $this->session = new Session($request, $response);
        }
        return $this->session;
    }
}