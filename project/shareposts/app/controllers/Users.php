<?php
class Users extends Controller {

    private $user_model;

    public function __construct(){
        $this->user_model = $this->model('User');
    }

    public function register(){
        //check if POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //process form
            //Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'err_name' => '',
                'err_email' => '',
                'err_password' => '',
                'err_confirm_password' => ''
            ];
            //Validation
            if (empty($data['name'])){
                $data['err_name'] = 'Please enter the name.';
            }

            if (empty($data['email'])){
                $data['err_email'] = 'Please enter the email.';
            }
            else {
                if ($this->user_model->find_user_by_email($data['email'])){
                    $data['err_email'] = 'Email is already taken.';
                }
            }
            if (empty($data['password'])){
                $data['err_password'] = 'Please enter the password.';
            }
            elseif (strlen($data['password']) < 6){
                $data['err_password'] = 'The password must be at least 6 characters.';
            }
            if (empty($data['confirm_password'])){
                $data['err_confirm_password'] = 'Please confirm the password.';
            }
            else {
                if ($data['password'] !== $data['confirm_password']){
                    $data['err_confirm_password'] = 'Passwords don\'t match';
                }
            }

            //Make sure there are no errors
            if (empty($data['err_name']) && empty($data['err_email']) && empty($data['err_password']) && empty($data['err_confirm_password'])){

                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //register user
                if ($this->user_model->register($data)){
                    redirect('users/login');
                }
                else {
                    die('Something went wrong');
                }
            }
            else {
                //load view with errors
                $this->view('users/register', $data);
            }
        }
        else{
            //init data
            $data = [
              'name' => '',
              'email' => '',
              'password' => '',
              'confirm_password' => '',
              'err_name' => '',
              'err_email' => '',
              'err_password' => '',
              'err_confirm_password' => ''
            ];
            //Load view
            $this->view('users/register', $data);
        }
    }

    public function login(){
        //check if POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //process form
            //Sanitize Post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'err_email' => '',
                'err_password' => ''
            ];
            //Validation
            if (empty($data['email'])){
                $data['err_email'] = 'Please enter the email.';
            }
            if (empty($data['password'])){
                $data['err_password'] = 'Please enter the password.';
            }

            //Make sure there are no errors
            if ( empty($data['err_email']) && empty($data['err_password'])){
                die('SUCCESS');
            }
            else {
                //load view with errors
                $this->view('users/login', $data);
            }
        }
        else{
            //init data
            $data = [
                'email' => '',
                'password' => '',
                'err_email' => '',
                'err_password' => '',
            ];
            //Load view
            $this->view('users/login', $data);
        }
    }
}