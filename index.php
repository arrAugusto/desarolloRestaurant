<?php

require_once "controlador/plantilla.controlador.php";

require_once "controlador/usuarios.controlador.php";
require_once "controlador/gestionMesas.controlador.php";
require_once "controlador/nuevosPlatos.controlador.php";

require_once "modelo/nuevosPlatos.modelo.php";

require_once "modelo/usuarios.modelo.php";
require_once "modelo/gestionMesas.modelo.php";

$plantilla = new ControladorPlantilla();

$plantilla->ctrPlantilla();
