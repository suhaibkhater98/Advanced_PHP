<?php
namespace App\Controllers;

use System\Controller;

class HomeController extends Controller {

    public function index(){
        pre($this->db->fetchAll('users'));
    }
}