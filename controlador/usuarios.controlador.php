<?php

class ControladorUsuarios {

    public static function ctrRevisionDeUsuarios() {
        if (isset($_POST["ingUsuario"])) {

            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])) {
                $passFront = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $usuarioFront = $_POST["ingUsuario"];
                $sp = "spConsultarUsuario";
                $respuesta = ModeloUsuarios::mdlMostrarUsuarios($usuarioFront, $sp);
                if ($respuesta["usuario"] == $usuarioFront && $respuesta["password"] == $passFront) {
                    $_SESSION["iniciar"] = "Ok";
                    $_SESSION["identUser"] = $respuesta["id"];
                    $_SESSION["nombreUser"] = $respuesta["nombre"];
                    $_SESSION["perfilUser"] = $respuesta["perfil"];
                    $_SESSION["foto"] = $respuesta["foto"];
                    echo '<script>window.location = "inicio";</script>';
                } else {
                    echo '<div class="alert alert-primary" role="alert">
 El usuario o contraseña no existe
</div>';
                }
            }
        }
    }

    public static function ctrMostrarUsuarios() {
        $usuarios = ModeloUsuarios::mdlMostrarUsuariosIndiv();
        return $usuarios;
    }

    public static function ctrMostrarUsuario($idUser) {
        $sp = "spMostrarUserEdit";
        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($idUser, $sp);
        return $respuesta;
    }

    /* =============================================
      EDITAR USUARIO
      ============================================= */

    static public function ctrEditarUsuario() {

        if (isset($_POST["editarUsuario"])) {

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {

                /* =============================================
                  VALIDAR IMAGEN
                  ============================================= */

                $ruta = $_POST["fotoActual"];

                if (isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {

                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /* =============================================
                      CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                      ============================================= */

                    $directorio = "vista/img/usuarios/" . $_POST["editarUsuario"];

                    /* =============================================
                      PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
                      ============================================= */

                    if (!empty($_POST["fotoActual"])) {

                        unlink($_POST["fotoActual"]);
                    } else {

                        mkdir($directorio, 0755);
                    }

                    /* =============================================
                      DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                      ============================================= */

                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {

                        /* =============================================
                          GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                          ============================================= */

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    }

                    if ($_FILES["editarFoto"]["type"] == "image/png") {

                        /* =============================================
                          GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                          ============================================= */

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/" . $aleatorio . ".png";

                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "usuarios";

                if ($_POST["editarPassword"] != "") {

                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {

                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                    } else {

                        echo'<script>

								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result) {
										if (result.value) {

										window.location = "usuarios";

										}
									})

						  	</script>';

                        return;
                    }
                } else {

                    $encriptar = $_POST["passwordActual"];
                }

                $datos = array("nombre" => $_POST["editarNombre"],
                    "usuario" => $_POST["editarUsuario"],
                    "password" => $encriptar,
                    "perfil" => $_POST["editarPerfil"],
                    "foto" => $ruta);
                var_dump($datos);
                $respuesta = ModeloUsuarios::mdlEditarUsuario($datos);

                if ($respuesta == "ok") {

                    echo'<script>

					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "usuarios";

									}
								})

					</script>';
                }
            } else {

                echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

							window.location = "usuarios";

							}
						})

			  	</script>';
            }
        }
    }

}
