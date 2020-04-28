<?php

class ControladorUsuarios {

    public static function ctrRevisionDeUsuarios() {
        if (isset($_POST["ingUsuario"])) {

            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])) {
                $passFront = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $usuarioFront = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($usuarioFront);
                var_dump($respuesta);
                return true;
                if ($respuesta["usuario"]==$usuarioFront && $respuesta["password"]==$passFront) {
                                            $_SESSION["iniciar"] = "Ok";
                }
            }
        }
    }

    public static function ctrMostrarUsuarios(){
       $usuarios = ModeloUsuarios::mdlMostrarUsuariosIndiv();
       return $usuarios; 
    } 
}
