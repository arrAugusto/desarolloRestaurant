<?php

class ControladorUsuarios {

    public static function ctrRevisionDeUsuarios() {
        if (isset($_POST["ingUsuario"])) {

            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])) {
                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $usuarioFront = $_POST["ingUsuario"];
                $passFront = $_POST["ingPassword"];
                var_dump($usuarioFront);
                var_dump($passFront);
                
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($usuarioFront, $passFront);
                echo '<br/>';
                var_dump($respuesta);   
                if ($respuesta["usuario"]==$usuarioFront && $respuesta["password"]==$passFront) {
                                            $_SESSION["iniciar"] = "Ok";
                }
                
            }
        }
    }

}
