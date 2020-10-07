<?php
namespace System;

class Application{

    //container hold all objcet for application
    private $container = [];

    private static $app;

    private function __construct(File $file){
        $this->share('file' , $file);
        $this->registerClasses();
        $this->loadHelpers();
    }

    public static function getApp($file = null){
        if(is_null(self::$app)){
            self::$app = new self($file);
        }
        return self::$app;
    }

    public function run(){
        $this->session->start();
        $this->request->prepareUrl();
        $this->file->required('App/index.php');
        list($controller , $method , $arguments) = $this->route->getProperRoute();
        $output = $this->load->action($controller , $method , $arguments);
        $this->response->setOutput($output);
        $this->response->send();
    }

    private function registerClasses(){
        spl_autoload_register([$this , 'load']);
    }

    private function loadHelpers(){
        $this->file->required('vendor/helpers.php');
    }

    public function load($class){
        if(strpos($class , 'App') === 0){
            $file = $class . '.php';
        } else {
            //get the class from vendor file
            $file = 'vendor/' . $class . '.php';
        }
        if($this->file->exists($file)){
            $this->file->required($file);
        }
    }

    private function coreClasses(){
        return [
            'request' => 'System\\Http\\Request',
            'response' => 'System\\Http\\Response',
            'session' => 'System\\Session',
            'route'  => 'System\\Route',
            'cookie'  => 'System\\Cookie',
            'load'    => 'System\\Loader',
            'html'    => 'System\\Html',
            'db'    => 'System\\Database',
            'view'    => 'System\\View\\ViewFactory'
        ];
    }
    public function get($key){
        //Check the class if in container
        if (! $this->isSharing($key)){
            //check the class if in Core Class
            if($this->isCoreAlias($key)){
                $this->share($key , $this->createNewCoreObject($key));
            } else {
                die('<h1>' . $key . ' Not Found in Application </h1>');
            }
        }
        return $this->container[$key];
    }

    public function isSharing($key){
        return isset($this->container[$key]);
    }

    public function isCoreAlias($key){
        $classes = $this->coreClasses();
        return isset($classes[$key]);
    }

    public function createNewCoreObject($key){
        $class = $this->coreClasses();
        $object = $class[$key];
        return new $object($this);
    }

    public function __get($key){
        return $this->get($key);
    }

    public function share($key , $value){
        $this->container[$key] = $value;
    }

}