<?php

require_once '../controlador/gestionMesas.controlador.php';
require_once '../modelo/gestionMesas.modelo.php';
require_once '../controlador/usuarios.controlador.php';
require_once '../modelo/usuarios.modelo.php';

class AjaxOperacionesPorMesa {

    public $operaMesa;

    public function ajaxMesaOp() {
        $opMesa = $this->opMesa;
        session_start();
        $identUser = $_SESSION['identUser'];
        $numeroMesa = $this->numeroMesa;
        $respuesta = ControladorMesasRest::ctrMesaOp($opMesa, $identUser, $numeroMesa);
        echo json_encode($identUser);
    }

    public $mostrarMenu;

    public function ajaxMostrarMenus() {
        $mostrarMenu = $this->mostrarMenu;
        $respuesta = ControladorMesasRest::ctrMostrarMenus();
        echo json_encode($respuesta);
    }

    public $mostrarMenuSelect;

    public function ajaxMostrarMenuSelect() {
        $mostrarMenuSelect = $this->mostrarMenuSelect;
        $respuesta = ControladorMesasRest::ctrMostrarMenuSelect($mostrarMenuSelect);
        echo json_encode($respuesta);
    }

    public $ordenMesa;

    public function ajaxOrdenMesa() {
        session_start();
        $identUser = $_SESSION['identUser'];
        $nuevaOrden = $this->nuevaOrden;
        $respuesta = ControladorMesasRest::ctrOrdenMesa($nuevaOrden, $identUser);
        echo json_encode($respuesta);
    }

    public $cobroEnMesa;

    public function ajaxCobroEnMesa() {
        $cobroEnMesa = $this->cobroEnMesa;
        $respuestas = ControladorMesasRest::ctrCobroEnMesa($cobroEnMesa);
        echo json_encode($respuestas);
    }

    public $cambiarEstadoMesa;

    public function ajaxCambioDeMesa() {
        $estadoMesa = $this->estadoMesa;
        $mesaCambio = $this->mesaCambio;
        $respuesta = ControladorMesasRest::ctrCambioDeMesa($estadoMesa, $mesaCambio);
        echo json_encode($respuesta);
    }

    public $cerrarMesa;

    public function ajaxCerrarCuentaMesa() {
        $idMesaCerrarCuenta = $this->idMesaCerrarCuenta;
        $listaDataCliente = $this->listaDataCliente;
        $respuesta = ControladorMesasRest::ctrCerrarCuentaMesa($idMesaCerrarCuenta, $listaDataCliente);
        echo json_encode($respuesta);
    }

    public $mostrarCliente;

    public function ajaxMostrarCliente() {
        $idClienteMostrarUser = $this->idClienteMostrarUser;
        $respuesta = ControladorMesasRest::ctrMostrarCliente($idClienteMostrarUser);
        echo json_encode($respuesta);
        
    }

}

if (isset($_POST["opMesa"])) {
    $operaMesa = new AjaxOperacionesPorMesa();
    $operaMesa->opMesa = $_POST["opMesa"];
    $operaMesa->numeroMesa = $_POST["numeroMesa"];

    $operaMesa->ajaxMesaOp();
}


if (isset($_POST["mostrarMenu"])) {
    $mostrarMenu = new AjaxOperacionesPorMesa();
    $mostrarMenu->mostrarMenu = $_POST["mostrarMenu"];
    $mostrarMenu->ajaxMostrarMenus();
}


if (isset($_POST["mostrarMenuSelect"])) {
    $mostrarMenuSelect = new AjaxOperacionesPorMesa();
    $mostrarMenuSelect->mostrarMenuSelect = $_POST["mostrarMenuSelect"];
    $mostrarMenuSelect->ajaxMostrarMenuSelect();
}


if (isset($_POST["nuevaOrden"])) {
    $ordenMesa = new AjaxOperacionesPorMesa();
    $ordenMesa->nuevaOrden = $_POST["nuevaOrden"];
    $ordenMesa->ajaxOrdenMesa();
}

if (isset($_POST["cobroEnMesa"])) {
    $cobroEnMesa = new AjaxOperacionesPorMesa();
    $cobroEnMesa->cobroEnMesa = $_POST["cobroEnMesa"];
    $cobroEnMesa->ajaxCobroEnMesa();
}


if (isset($_POST["estadoMesa"])) {
    $cambiarEstadoMesa = new AjaxOperacionesPorMesa();
    $cambiarEstadoMesa->estadoMesa = $_POST["estadoMesa"];
    $cambiarEstadoMesa->mesaCambio = $_POST["mesaCambio"];
    $cambiarEstadoMesa->ajaxCambioDeMesa();
}

if (isset($_POST["idMesaCerrarCuenta"])) {
    $cerrarMesa = new AjaxOperacionesPorMesa();
    $cerrarMesa->idMesaCerrarCuenta = $_POST["idMesaCerrarCuenta"];
    $cerrarMesa->listaDataCliente = $_POST["listaDataCliente"];
    $cerrarMesa->ajaxCerrarCuentaMesa();
}

if (isset($_POST["idClienteMostrarUser"])) {
    $mostrarCliente = new AjaxOperacionesPorMesa();
    $mostrarCliente->idClienteMostrarUser = $_POST["idClienteMostrarUser"];
    $mostrarCliente->ajaxMostrarCliente();
}