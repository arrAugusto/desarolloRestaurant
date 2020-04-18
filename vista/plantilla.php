<?php

session_start();
if (isset($_SESSION["iniciar"]) && $_SESSION["iniciar"]=="Ok") {
include "modulos/header.php";
include "modulos/navBarraSuper.php";
include "modulos/navBarraLateral.php";


if (isset($_GET["ruta"])) {
    if ($_GET["ruta"]=="inicio" ||
            $_GET["ruta"] == "salir"
            ) {
      
            include "modulos/" . $_GET["ruta"] . ".php";  
    }else{
        
    }
}


include "modulos/footer.php";
}else{
include "modulos/login.php";
}

