<?php
namespace System;

class File{

    const DS = DIRECTORY_SEPARATOR;
    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function exists($file){
        return file_exists($this->to($file));
    }

    public function required($file){
        return require $this->to($file);
    }

    public function toVendor($path){
        return $this->to('vendor'.File::DS . $path);
    }

    public function to($path){
        return $this->root . File::DS . str_replace(['/' , '\\'] , File::DS , $path);
    }

}