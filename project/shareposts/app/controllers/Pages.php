<?php

class Pages extends Controller{

	public function __construct(){

	}
	
	public function index(){
	    if (is_logged_in()){
	        redirect('posts');
        }
		$data = [
			'title' => 'SharePosts'
		];
		$this->view('pages/index', $data);
	}
	
	public function about($param){
	$data = [
			'title' => 'About Us'
		];
		$this->view('pages/about', $data);
	}
}
