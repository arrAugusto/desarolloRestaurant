<?php

require_once 'conexion.php';

class ModeloMesasRest {

    public static function mdlMostrarMesasDisponibles() {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spMesasConsulta");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public static function mdlMostrarMenus() {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spMostrarMenus");
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public static function mdlMostrarMenuSelect($sp, $mostrarMenuSelect) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL " . $sp . " (?)");
        $sentencia->bindParam(1, $mostrarMenuSelect, PDO::PARAM_STR);
        $sentencia->execute();
        while ($fila = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $datos [] = $fila;
        }
        if (!empty($datos)) {
        return $datos;            
        }else{
            return false;
        }

    }

    public static function mdlMostrarMenuSelectFetchAll($sp, $mostrarMenuSelect) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL " . $sp . " (?)");
        $sentencia->bindParam(1, $mostrarMenuSelect, PDO::PARAM_STR);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public static function mdlOrdenMesa($numeroMesa, $iddetmenu, $tipoop, $identUser, $cantidad) {
//return array($numeroMesa, $tipoop, $iddetmenu, $idUser);
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL spNuevaOrden (?, ?, ?, ?, ?)");
        $sentencia->bindParam(1, $numeroMesa, PDO::PARAM_STR);
        $sentencia->bindParam(2, $iddetmenu, PDO::PARAM_STR);
        $sentencia->bindParam(3, $tipoop, PDO::PARAM_STR);
        $sentencia->bindParam(4, $identUser, PDO::PARAM_STR);
        $sentencia->bindParam(5, $cantidad, PDO::PARAM_STR);
        if ($sentencia->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    public static function mdlCambioDeEstadoMesa($sp, $estadoMesa, $mesaCambio) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL " . $sp . " (?, ?)");
        $sentencia->bindParam(1, $estadoMesa, PDO::PARAM_STR);
        $sentencia->bindParam(2, $mesaCambio, PDO::PARAM_STR);
        if ($sentencia->execute()) {
            return true;
        } else {
            return "error";
        }
    }

    public static function mdlNuevoClienteDB($sp, $nit, $nombre, $direccion) {
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL " . $sp . " (?, ?, ?)");
        $sentencia->bindParam(1, $nit, PDO::PARAM_STR);
        $sentencia->bindParam(2, $nombre, PDO::PARAM_STR);
        $sentencia->bindParam(3, $direccion, PDO::PARAM_STR);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }
public static function mdlNuevaFactura($sp, $idMesaCerrarCuenta, $totalCobro, $estado, $identityCliente){
        $conn = Conexion::conectar();
        $sentencia = $conn->prepare("CALL " . $sp . " (?, ?, ?, ?)");
        $sentencia->bindParam(1, $idMesaCerrarCuenta, PDO::PARAM_STR);
        $sentencia->bindParam(2, $totalCobro, PDO::PARAM_STR);
        $sentencia->bindParam(3, $estado, PDO::PARAM_STR);
        $sentencia->bindParam(4, $identityCliente, PDO::PARAM_STR);
        $sentencia->execute();
        return $sentencia->fetchAll();    
}

}
