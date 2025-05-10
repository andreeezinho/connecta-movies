<?php

namespace App\Config;

class Admin {

    protected $permissaoUserRepository;

    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public function check(){
        if(isset($_SESSION['user']) && $_SESSION['user']->is_admin == 1){
            return true;
        }

        return false;
    }
}