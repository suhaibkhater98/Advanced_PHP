<?php
namespace System\View;

use System\Application;

class ViewFactory{
    private $app;

    public function __construct(Application $app){
        $this->app = $app;
    }

    public function render($viewPath , $data =[]){
        return new View($this->app->file , $viewPath , $data);
    }
}