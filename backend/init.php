<?php

ob_start();
require "backend/config.php";

require "classes/PHPMailer.php";
require "classes/Exception.php";
require "classes/SMTP.php";


//autoload
spl_autoload_register(function($class){
    require_once "classes/{$class}.php";
}); 
 


session_start();
 

require "functions.php";

$loadFromUser=new User;
$account = new Account;