<?php
// App Core class
// Creates URL and loads core controller
// URL format - /controller/method/params
class Core{
    protected $current_controller = 'Pages';
    protected $current_method = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->get_url();
        //Look in Controllers for controller from url
        if (file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')){
        	$this->current_controller = ucwords($url[0]);
        	unset($url[0]);
        }
        //require the controller
        require_once '../app/Controllers/' . $this->current_controller . '.php';
        //instantiate controller class
        $this->current_controller = new $this->current_controller;
        //Look in Controller for method from url
        if (isset($url[1])){
        	if (method_exists($this->current_controller, $url[1])){
        		$this->current_method = $url[1];
        		unset($url[1]);
        	}
        }
        //Get params
        $this->params = $url ? array_values($url) : [null];
        //Call a callback with params
        call_user_func_array([$this->current_controller, $this->current_method], $this->params);
    }

    public function get_url(){
        if (isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
