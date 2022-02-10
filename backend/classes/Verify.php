<?php 

class Verify{
    private $pdo;

    public function __construct(){
        $this->pdo=Database::instance();
    }

    public function generateLink(){
        return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
    }
}