<?php
class App
{
    private $__controller, $__action, $__params;

    function __construct()
    {

        global $routes;
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action = 'index';
        $this->__params = [];

        $this->handleUrl();
    }
    function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }
    public function handleUrl()
    {
        $url = $this->getUrl();
        $urlarr = array_filter(explode('/', $url));
        $urlarr = array_values($urlarr);

        // xử lý controller
        if (!empty($urlarr[0])) {
            $this->__controller = $urlarr[0];
        } else {
            $this->__controller = ucfirst($this->__controller);
        }
        if (file_exists('app/controllers/' . ($this->__controller) . '.php')) {
            require_once 'controllers/' . ($this->__controller) . '.php';
            $this->__controller = new $this->__controller();
            unset($urlarr[0]);
        } else {
            $this->loadError();
        }

        // xử lý action
        if (!empty($urlarr[1])) {
            $this->__action = $urlarr[1];
            unset($urlarr[1]);
        }

        //xử lý params
        $this->__params = array_values($urlarr);
        call_user_func_array([$this->__controller, $this->__action], $this->__params);
    }
    public function loadError($name = '404')
    {
        require_once 'errors/' . $name . '.php';
    }
}