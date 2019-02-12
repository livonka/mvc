<?php

class Posts extends Controller{
    private $post_model;

    public function __construct(){
        if (!is_logged_in()){
            redirect('users/login');
        }
        $this->post_model = $this->model('Post');
    }

    public function index(){

        $posts = $this->post_model->get_posts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function add(){

        $data = [
            'title' => '',
            'body' => ''
        ];
        $this->view('posts/add', $data);
    }
}