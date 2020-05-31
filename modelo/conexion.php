<?php

class Conexion {
    public function conectar(){
        $dtLink = new PDO("mysql:host=localhost;dbname=restaurant", "root", "");
        $dtLink->exec("set names utf8");
            return $dtLink;
         
    }
}