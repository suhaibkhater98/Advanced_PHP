<?php

namespace App\Models;

use http\Url;
use System\Model;

class LoginModel extends Model {
    protected $table = 'users';
    protected $user;

    public function isValidLogin($email , $password){
        $user = $this->where('email = ?' , $email)->fetch($this->table);
        if(!$user) return false;
        $this->user = $user;
        return password_verify($password , $user->password);

    }

    public function user(){
        return $this->user;
    }

    public function isLogged(){
        if($this->cookie->has('login')){
            $code = $this->cookie->get('login');
        } elseif ($this->session->has('login')){
            $code = $this->session->get('login');
        } else{
            $code = '';
        }

        $user = $this->where('code = ?', $code)->fetch($this->table);
        if(!$user) return false;
        $this->user = $user;
        return true;
    }
}