<?php
require_once '../controlador/usuarios.controlador.php';
require_once '../modelo/usuarios.modelo.php';

class AjaxGestorDeUsuarios{
    public $mostrarDataUser;
    public function mostrarDataUser(){
        $datosUser = $this->datosUser;
        $respuesta = ControladorUsuarios::ctrMostrarUsuario($datosUser);
        echo json_encode($respuesta);
    }
}

if (isset($_POST["datosUser"])){
$mostrarDataUser = new AjaxGestorDeUsuarios();
$mostrarDataUser -> datosUser = $_POST["datosUser"];
$mostrarDataUser -> mostrarDataUser();

}