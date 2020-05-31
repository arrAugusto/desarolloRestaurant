<?php

require_once 'conexion.php';

class ModeloUsuarios {

    public static function mdlMostrarUsuarios($usuario, $sp) {

        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL " . $sp . " (?)");
        $sentencia->bindParam(1, $usuario, PDO::PARAM_STR);
        $sentencia->execute();

        return $sentencia->fetch();
    }

    public static function mdlMostrarUsuariosIndiv() {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spListaUser");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public static function mdlEditarUsuario($datos) {
        $conn = Conexion::conectar();
        $nombre = $datos["nombre"];
        $password = $datos["password"];
        $perfil = $datos["perfil"];
        $foto = $datos["foto"];
        $usuario = $datos["usuario"];
        $sentencia = $conn->prepare("CALL spEditUSuario (?, ?, ?, ?, ?)");
        $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
        $sentencia->bindParam(2, $password, PDO::PARAM_STR);
        $sentencia->bindParam(3, $perfil, PDO::PARAM_STR);
        $sentencia->bindParam(4, $foto, PDO::PARAM_STR);
        $sentencia->bindParam(5, $usuario, PDO::PARAM_STR);
        $sentencia->execute();
   
        if ($sentencia->execute()) {
            return "ok";
        } else {
                return "error";
        }
    }

}
