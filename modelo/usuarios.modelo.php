<?php

require_once 'conexion.php';

class ModeloUsuarios {

    public static function mdlMostrarUsuarios($usuario, $pass) {
        $conn = Conexion::conectar();
       
        $sentencia = $conn->prepare("CALL spMostrarUs(?)");
        $sentencia->bindParam(1, $usuario, PDO::PARAM_STR);
        $sentencia->execute();
        return $sentencia->fetch();
    }

}
