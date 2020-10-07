<?php
namespace System;

use http\Exception\BadMethodCallException;

class Html{
    protected $app;
    private $title;
    private $description;
    private $keywords;

    public function __construct(Application $app){
        $this->app = $app;
    }

    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle($title){
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description){
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getKeywords(){
        return $this->keywords;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords){
        $this->keywords = $keywords;
    }

}