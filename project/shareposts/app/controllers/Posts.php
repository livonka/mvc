<?php

class Posts extends Controller{
    private $post_model;
    private $user_model;

    public function __construct(){
        if (!is_logged_in()){
            redirect('users/login');
        }
        $this->post_model = $this->model('Post');
        $this->user_model = $this->model('User');
    }

    public function index(){

        $posts = $this->post_model->get_posts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // form with data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'err_title' => '',
                'err_body' => ''
            ];

            if (empty($data['title'])){
                $data['err_title'] = 'Please enter the title.';
            }
            if (empty($data['body'])){
                $data['err_body'] = 'Please enter the body text.';
            }
            if (empty($data['err_title']) && empty($data['err_body'])){
                //validated
                if ($this->post_model->add_post($data)){
                    flash('post_message', 'Post added');
                    redirect('posts');
                }
                else {
                    die('Something went wrong.');
                }
            }
            else {
                //load view with errors
                $this->view('posts/add', $data);
            }
        }
        else {
            // empty form
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->view('posts/add', $data);
        }
    }

    public function show($id){
        $post = $this->post_model->get_post_by_id($id);
        $user = $this->user_model->get_user_by_id($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user
        ];
        $this->view('posts/show', $data);
    }

    public function edit($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // form with data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'err_title' => '',
                'err_body' => ''
            ];

            if (empty($data['title'])){
                $data['err_title'] = 'Please enter the title.';
            }
            if (empty($data['body'])){
                $data['err_body'] = 'Please enter the body text.';
            }
            if (empty($data['err_title']) && empty($data['err_body'])){
                //validated
                if ($this->post_model->update_post($data)){
                    flash('post_message', 'Post edited');
                    redirect('posts');
                }
                else {
                    die('Something went wrong.');
                }
            }
            else {
                //load view with errors
                $this->view('posts/edit', $data);
            }
        }
        else {
            // empty form
            $post = $this->post_model->get_post_by_id($id);
            //check for owner
            if ($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            $this->view('posts/edit', $data);
        }
    }

    public function delete($id){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $post = $this->post_model->get_post_by_id($id);
            //check for owner
            if ($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }

            if ($this->post_model->delete_post($id)){
                flash('post_message', 'Post removed.');
                redirect('posts');
            }
            else {
                die('Something went wrong');
            }
        }
        else {
            redirect('posts');
        }
    }
}