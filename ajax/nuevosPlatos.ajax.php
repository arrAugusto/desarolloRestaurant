<?php

require_once '../controlador/nuevosPlatos.controlador.php';
require_once '../modelo/nuevosPlatos.modelo.php';

class AjaxNuevosMenus {

    public $mostrarDataAPeritivo;

    public function ajaxSeleccionAperitivo() {
        $selectAperitivo = $this->selectAperitivo;
        $respuesta = ControladornuevosPlatosAperitivos::ctrSeleccionAperitivo($selectAperitivo);
        echo json_encode($respuesta);
    }

    public $nuevoMenuSis;

    public function ajaxNuevoMenu() {
    $nuevoMenu = $this ->nuevoMenu;
    $precioMenu = $this ->precioMenu;
    $listaMenuString = $this ->listaMenuString;
    $respuesta = ControladornuevosPlatosAperitivos::ctrNuevoMenu($nuevoMenu, $precioMenu, $listaMenuString);
    echo json_encode($respuesta);
    }

}

if (isset($_POST["selectAperitivo"])) {
    $mostrarDataAPeritivo = new AjaxNuevosMenus();
    $mostrarDataAPeritivo->selectAperitivo = $_POST["selectAperitivo"];
    $mostrarDataAPeritivo->ajaxSeleccionAperitivo();
}


if (isset($_POST["nuevoMenu"])) {
    $nuevoMenuSis = new AjaxNuevosMenus();
    $nuevoMenuSis->nuevoMenu = $_POST["nuevoMenu"];
    $nuevoMenuSis->precioMenu = $_POST["precioMenu"];
    $nuevoMenuSis->listaMenuString = $_POST["listaMenuString"];
    $nuevoMenuSis->ajaxNuevoMenu();
}