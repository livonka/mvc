<?php
// App Core class
// Creates URL and loads core controller
// URL format - /controller/method/params
class Core{
    protected $current_controller = 'Pages';
    protected $current_method = 'index';
    protected $params = [];

    public function __construct(){
        print_r($this->get_url());
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