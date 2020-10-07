<?php

namespace System;

class Cookie{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function set($key , $value , $hours = 1800){
        setcookie($key , $value , time() + $hours * 3600 ,'','',false,true);
    }

    public function get($key , $default = null){
        return array_get($_COOKIE , $key  , $default);
    }

    public function has($key){
        return array_key_exists($key , $_COOKIE);
    }

    public function all(){
        return $_COOKIE;
    }

    public function remove($key){
        setcookie($key , null ,-1);
        unset($_COOKIE);
    }

    public function destroy(){
        foreach (array_key_exists($this->all()) as $key){
            $this->remove($key);
        }
        unset($_COOKIE);
    }
}