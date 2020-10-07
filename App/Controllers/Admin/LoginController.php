<?php
namespace App\Controllers\Admin;

use System\Controller;

class LoginController extends Controller{
    public function index(){
        $loginModel = $this->load->model('Login');
        if($loginModel->isLogged()){
            //return $this->url->redirectTo('/admin');
        }
        $data['errors'] = $this->errors;
        return $this->view->render('admin/users/login' , $data);
    }

    public function submit(){
        if ($this->isValid()){
            $loginModel = $this->load->model('Login');
            if($this->request->post('remember')){
                //save login data globaly
                $this->cookie->set('login' , $loginModel->user()->code);
            } else {
                //save login data locally
                $this->session->set('login' , $loginModel->user()->code);
            }
            $data['success'] = 'Welcome Back '.$loginModel->user()->first_name;
            $data['redirect'] = $this->url->link('/admin');
            return $this->json($data);
        } else {
            $data = [];
            $data['errors'] = $this->errors;
            return $this->json($data);
        }
    }

    public function isValid(){
        $email = $this->request->post('email');
        $password = $this->request->post('password');
        if(!$email){
            $this->errors[] = 'Please Insert Email address';
        } if(! filter_var($email , FILTER_VALIDATE_EMAIL)){
            $this->errors[] = 'Please Insert Valid Email';
        }

        if(!$password){
            $this->errors[] = 'Please Insert Passwrod';
        }

        if(!$this->errors){
            $loginModel = $this->load->model('Login');
            if(! $loginModel->isValidLogin($email , $password)){
                $this->errors[] = 'Invalid Login';
            }
        }

        return empty($this->errors);
    }

}