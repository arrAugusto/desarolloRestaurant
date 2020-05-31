<?php

class ControladornuevosPlatosAperitivos {

    public static function ctrnuevoAperitivo() {
        if (isset($_POST["nombreAperitivo"])) {

            $categoriaP = $_POST["categoriaP"];
            $nombreAperitivo = $_POST["nombreAperitivo"];
            $textAreaDescripcion = $_POST["textAreaDescripcion"];
            $precio = $_POST["precio"];
            $ruta = "";

            if (isset($_FILES["nuevaFoto"]["tmp_name"])) {

                list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                $nuevoAncho = 500;
                $nuevoAlto = 500;

                /* =============================================
                  CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
                  ============================================= */

                $directorio = "vistas/img/aperitivos/" . $_POST["nombreAperitivo"];

                mkdir($directorio, 0755);

                /* =============================================
                  DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
                  ============================================= */

                if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {

                    /* =============================================
                      GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                      ============================================= */

                    $aleatorio = mt_rand(100, 999);

                    $ruta = "vistas/img/aperitivos/" . $_POST["nombreAperitivo"] . "/" . $aleatorio . ".jpg";

                    $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagejpeg($destino, $ruta);
                }

                if ($_FILES["nuevaFoto"]["type"] == "image/png") {

                    /* =============================================
                      GUARDAMOS LA IMAGEN EN EL DIRECTORIO
                      ============================================= */

                    $aleatorio = mt_rand(100, 999);

                    $ruta = "vistas/img/aperitivos/" . $_POST["nombreAperitivo"] . "/" . $aleatorio . ".png";

                    $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagepng($destino, $ruta);
                }
            }


            $respGuardarNuevoPlato = ModeloNuevosPlatos::mdlNuevoAperitivo($categoriaP, $nombreAperitivo, $textAreaDescripcion, $precio, $ruta);
            if ($respGuardarNuevoPlato) {
                echo'<script>

					swal({
						  type: "success",
						  title: "Aperitivo creado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

								window.location = "nuevosPlatos";

									}
								})

					</script>';
            } else {

                echo'<script>

					swal({
						  type: "error",
						  title: "¡No se creo el aperitivo!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
							if (result.value) {

								window.location = "nuevosPlatos";

							}
						})

			  	</script>';
            }
        }
    }

    public static function ctrMostrarAperitivos($tipo) {
        $respGuardarNuevoPlato = ModeloNuevosPlatos::mdlMostrarAperitivo();

        $contador = 0;
        foreach ($respGuardarNuevoPlato as $key => $value) {
            if ($value["estadAperitivo"] == 1) {
                $contador = $contador + 1;
                $idAperitivo = $value["id"];

                if ($value["fotoAperitivo"] == "" && $value["categoriaAperitivo"] == "comida") {
                    $imagen = '<img src="vistas/img/platillos/platilloDefault.jpg" class="img-thumbnail previsualizarEditar" width="50px">';
                } else {
                    $imagen = '<img src="' . $value["fotoAperitivo"] . '" class="img-thumbnail previsualizarEditar" width="50px">';
                }

                if ($value["fotoAperitivo"] == "" && $value["categoriaAperitivo"] == "bebida") {
                    $imagen = '<img src="vistas/img/platillos/bebidaDefault.png" class="img-thumbnail previsualizarEditar" width="50px">';
                } else {
                    $imagen = '<img src="' . $value["fotoAperitivo"] . '" class="img-thumbnail previsualizarEditar" width="50px">';
                }
                if ($value["fotoAperitivo"] == "" && $value["categoriaAperitivo"] == "postre") {
                    $imagen = '<img src="vistas/img/platillos/postreDefault.png" class="img-thumbnail previsualizarEditar" width="50px">';
                } else {
                    $imagen = '<img src="' . $value["fotoAperitivo"] . '" class="img-thumbnail previsualizarEditar" width="50px">';
                }
                if ($tipo == 0) {
                    $button = '<button type="button" class="btn btn-success btnCrearMenu" idAperitivo=' . $idAperitivo . '>Menú<i class="fa fa-plus"></i></button>';
                } else {
                    $button = '<button type="button" class="btn btn-success btnAgregarIndividual" idAperitivo=' . $idAperitivo . ' nombreApertivo="' . $value["nombreAperitivo"] . '" precio="' . $value["precioAperitivo"] . '">Menú<i class="fa fa-plus"></i></button>';
                }
                echo '
                <tr>
                    <td>' . $contador . '</td>
                    <td>' . $value["categoriaAperitivo"] . '</td>
                    <td>' . $value["nombreAperitivo"] . '</td>
                    <td>' . $value["descripcionAperitivo"] . '</td>
                    <td>' . $value["precioAperitivo"] . '</td>
                    <td>' . $imagen . '</td>
                    <td>' . $button . '</td>
                        
</tr>   
                
                ';
            }
        }
    }

    public static function ctrSeleccionAperitivo($selectAperitivo) {
        $respuesta = ModeloNuevosPlatos::mdlSeleccionAperitivo($selectAperitivo);
        return $respuesta;
    }

    public static function ctrNuevoMenu($nuevoMenu, $precioMenu, $listaMenuString) {
        $respuesta = ModeloNuevosPlatos::mdlNuevoMenu($nuevoMenu, $precioMenu, $listaMenuString);
        return $respuesta;
    }

    public static function ctrMostrarFacturas() {
        $respuesta = ModeloNuevosPlatos::mdlMostrarFacturas();
        $contador = 0; 
        foreach ($respuesta as $key => $value) {
            $contador=$contador+1;
            if ($value["estado"]==1) {  
                $button = '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-danger btnAnularFactura" identity='.$value["identity"].'><i class="fa fa-close"></i></button><button type="button" class="btn btn-info btnImprimirFact" identity='.$value["identity"].'><i class="fa fa-print"></i></button></div>';
            }else{
                $button = '<button type="button" class="btn btn-dark" disabled="true"><i class="fa fa-print"></i></button>';
            }
            echo '
                <tr>
                       <td>'.$contador.'</td>
                       <td>'.$value["factura"].'</td>
                       <td>'.$value["nombre"].'</td>
                       <td>'.$value["monto"].'</td>
                       <td>'.$value["fechaEmision"].'</td>
                       <td>'.$button .'</td>    

         </tr>   ';
        }
        
    }

}
