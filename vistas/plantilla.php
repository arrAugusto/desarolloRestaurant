<?php

session_start();
if (isset($_SESSION["iniciar"]) && $_SESSION["iniciar"] == "Ok") {
    include "modulos/header.php";
    include "modulos/navBarraSuper.php";
    include "modulos/navBarraLateral.php";


    if (isset($_GET["ruta"]) && $_GET["ruta"] == "inicio" ||
            $_GET["ruta"] == "salir" ||
            $_GET["ruta"] == "user" ||
            $_GET["ruta"] == "nuevosPlatos" ||
            $_GET["ruta"] == "historiaDeFacturas" ||
            $_GET["ruta"] == "gestorMesas"
    ) {
        include "modulos/" . $_GET["ruta"] . ".php";
    } else {
        include "modulos/pageNotFound.php";
    }


    include "modulos/footer.php";
} else {
    include "modulos/login.php";
}

