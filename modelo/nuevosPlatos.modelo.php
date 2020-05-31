<?php

require_once 'conexion.php';

class ModeloNuevosPlatos {

    public static function mdlNuevoAperitivo($categoriaP, $nombreAperitivo, $textAreaDescripcion, $precio, $ruta) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spNuevoAperitivo (?, ?, ?, ?, ?)");
        $sentencia->bindParam(1, $categoriaP, PDO::PARAM_STR);
        $sentencia->bindParam(2, $nombreAperitivo, PDO::PARAM_STR);
        $sentencia->bindParam(3, $textAreaDescripcion, PDO::PARAM_STR);
        $sentencia->bindParam(4, $precio, PDO::PARAM_STR);
        $sentencia->bindParam(5, $ruta, PDO::PARAM_STR);
        if ($sentencia->execute()) {
            return true;
        } else {
            return "error";
        }
    }

    public static function mdlMostrarAperitivo() {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spMostrarAperitivos");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public static function mdlSeleccionAperitivo($selectAperitivo) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spSelectAperitivo (?)");
        $sentencia->bindParam(1, $selectAperitivo, PDO::PARAM_STR);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public static function mdlNuevoMenu($nuevoMenu, $precioMenu, $listaMenuString) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spNuevoMenu (?, ?, ?)");
        $sentencia->bindParam(1, $nuevoMenu, PDO::PARAM_STR);
        $sentencia->bindParam(2, $precioMenu, PDO::PARAM_STR);
        $sentencia->bindParam(3, $listaMenuString, PDO::PARAM_STR);
        if ($sentencia->execute()) {
            return true;
        } else {
            return "error";
        }
    }

    public static function mdlMostrarFacturas() {
        
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spMostrarFacturas");
        $sentencia->execute();
        return $sentencia->fetchAll();
    
        
    }

}
