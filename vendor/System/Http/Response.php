<?php
namespace System\Http;

use System\Application;

class Response{

    private $app;
    private $headers = [];
    private $content = '';

    public function __construct(Application $app){
        $this->app = $app;
    }

    public function setOutput($output){
        $this->content = $output;
    }

    public function setHeader($header, $value){
        $this->headers[$header] = $value;
    }

    public function send(){
        $this->sendHeaders();
        $this->sendOutput();
    }

    private function sendHeaders(){
        foreach ($this->headers as $key => $header){
            header($key .':'. $header);
        }
    }

    private function sendOutput(){
        echo $this->content;
    }
}