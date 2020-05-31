<?php

class ControladorMesasRest {

    public static function ctrMostrarMesasDisponibles() {
        $mesasDisp = ModeloMesasRest::mdlMostrarMesasDisponibles();
        
        foreach ($mesasDisp as $key => $value) {
            
            $mesaRed = "mesaRed" . $value["mesa"];
            $mesaGree = "mesaGr" . $value["mesa"];
            $mesaYellow = "yellow" . $value["mesa"];
            $idMesa = $value["id"];
            if ($value["estado"] == 0) {
                $estadoMesa = '<div class="panel-body">
                        <div class="row posted-content centered-vertically">
                            <div class="col-md-8">
                                <h2 class="text-primary pull-left" id="mesaEstado">Mesa Libre <br/><div id="divSolicitiudesComida' . $idMesa . '"></div></h2>
                            </div>
                            <div cl ass="col-md-4 comment-count pull-right">
                                <div class="light-wrapper">
                                    <div id = "mesaRed' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="red btnCambioEstadoRed light">
                                    </div>
                                    <div id = "yellow' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="yellow light ctaDescuparCobrar disabledDiv" >
                                    </div>                                  
                                    <div id = "mesaGr' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="green light active"  >
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <center><strong>  Sin Mesero Asginado</strong></center>
                    </div>';
            }
            if ($value["estado"] == 2) {
                $estadoMesa = '
                    <div class="panel-body">
                        <div class="row posted-content centered-vertically">
                            <div class="col-md-8">
                                <h2 class="text-primary pull-left">Mesa Ocupada</h2>
                            </div>
                            <div class="col-md-4 comment-count pull-right">
                                <div class="light-wrapper">
                                    <div id = "red" class="light mesaRed' . $value["mesa"] . '" onClick="estadoMesa()">
                                    </div>
                                    <div id = "green" class="light active mesaGr' . $value["mesa"] . '">
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <center><strong>  Sin Mesero Asginado</strong></center>
                    </div>
';
            }
            if ($value["estado"] == 0) {
                echo '
            <div class="col-lg-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <center><h3>Mesa ' . $value["mesa"] . '</h3></center>
                    </div>

' . $estadoMesa . '

</div>
            </div>';
            }
            if ($value["estado"] == 1) {
                $sp = "spMostrarOrdeDeMesa";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelect($sp, $idMesa);
                
                echo '
            <div class="col-lg-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><h3>Mesa ' . $value["mesa"] . '</h3></center>
                    </div>';
                echo '
                    <div class="panel-body">
                        <div class="row posted-content centered-vertically">
                            <div class="col-md-8">
                                <h2 class="text-red pull-left">Ocupado<br/><div id="divSolicitiudesComida' . $idMesa . '">';
                
                if ($mesaData!=false) {
                    
                
                
                foreach ($mesaData as $keys => $values) {
                    if ($values["tipoOp"] == 0) {
                        $nombrePlat = $values["menu"];
                    }
                    if ($values["tipoOp"] == 1) {
                        $nombrePlat = $values["aperitivo"];
                    }
                    $cantidad = $values["cantidad"];
                    echo '<div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info btn-xs">' . $nombrePlat . '</button>
                    <button type="button" class="btn btn-warning btn-xs">' . $cantidad . '</button>
                    </div>&nbsp;'

                    ;
                
                }}echo'</div></h2>
                            </div>
                            <div class="col-md-4 comment-count pull-right">
                                <div class="light-wrapper">
                                    <div id = "mesaRed' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="red btnCambioEstadoRed light active" >
                                    </div>
                                    <div id = "yellow' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="yellow light ctaDescuparCobrar" >
                                    </div>                                  
                                    <div id = "mesaGr' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="green light"  >
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <center><strong class="text-info">Mesero Asginado : ' . $mesaData[0]["nombreMesero"] . '</strong></center>
                    </div>';



                echo'</div>
            </div>';
            }
            if ($value["estado"] == 2) {
                $sp = "spMostrarOrdeDeMesa";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelect($sp, $idMesa);

                echo '
            <div class="col-lg-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <center><h3>Mesa ' . $value["mesa"] . '</h3></center>
                    </div>';
                echo '
                    <div class="panel-body">
                        <div class="row posted-content centered-vertically">
                            <div class="col-md-8">
                                <h2 class="text-red pull-left">Ocupado<br/><div id="divSolicitiudesComida' . $idMesa . '">';

                foreach ($mesaData as $keys => $values) {
                    if ($values["tipoOp"] == 0) {
                        $nombrePlat = $values["menu"];
                    }
                    if ($values["tipoOp"] == 1) {
                        $nombrePlat = $values["aperitivo"];
                    }
                    $cantidad = $values["cantidad"];
                    echo '<div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info btn-xs">' . $nombrePlat . '</button>
                    <button type="button" class="btn btn-warning btn-xs">' . $cantidad . '</button>
                    </div>&nbsp;'

                    ;
                }
                echo'</div></h2>
                            </div>
                            <div class="col-md-4 comment-count pull-right">
                                <div class="light-wrapper">
                                    <div id = "mesaRed' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="red btnCambioEstadoRed light" >
                                    </div>
                                    <div id = "yellow' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="yellow light active ctaDescuparCobrar" >
                                    </div>                                  
                                    <div id = "mesaGr' . $value["mesa"] . '" mesa="' . $value["mesa"] . '" class="green light"  >
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <center><strong class="text-info">Mesero Asginado : ' . $mesaData[0]["nombreMesero"] . '</strong></center>
                    </div>';



                echo'</div>
            </div>';
            }
        }
    }

    public static function ctrMostrarMenus() {
        $mostrarMenu = ModeloMesasRest::mdlMostrarMenus();
        return $mostrarMenu;
    }

    public static function ctrMostrarMenuSelect($mostrarMenuSelect) {
        $sp = "spMostrarMenuSelect";
        $mostrarMenu = ModeloMesasRest::mdlMostrarMenuSelect($sp, $mostrarMenuSelect);
        $miMenuSelect = json_decode($mostrarMenu[3], true);

        $listaAperitivosMenu = [];
        foreach ($miMenuSelect as $key => $value) {
            $idAperitivoMenu = $value["idAperitivos"];
            $sp = "spSelectAperitivo";
            $mostrarMenu = ModeloMesasRest::mdlMostrarMenuSelect($sp, $idAperitivoMenu);
            array_push($listaAperitivosMenu, $mostrarMenu);
        }
        return $listaAperitivosMenu;
    }

    public static function ctrOrdenMesa($nuevaOrden, $identUser) {

        $ordenMatriz = json_decode($nuevaOrden, true);
        foreach ($ordenMatriz as $key => $value) {
            $numeroMesa = $value["0"];
            $tipoop = $value["1"];
            $iddetmenu = $value["2"];
            $cantidad = $value["3"];
            $respuesta = ModeloMesasRest::mdlOrdenMesa($numeroMesa, $iddetmenu, $tipoop, $identUser, $cantidad);
        }
        return $respuesta;
    }

    public static function ctrCobroEnMesa($cobroEnMesa) {
        $sp = "spMostrarOrdeDeMesa";
        $mesaConsumida = ModeloMesasRest::mdlMostrarMenuSelect($sp, $cobroEnMesa);
        $totalACobrar = 0;
        $nuevaListaResp = [];
        foreach ($mesaConsumida as $key => $value) {
            $idAper = $value["idAperM"];

            if ($value["tipoOp"] == 0) {
                $sp = "spMostrarMenuSelect";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idAper);
                $totalACobrar = $value["cantidad"] * $mesaData[0]["precio"];
                $mesero = $value["nombreMesero"];
                $descrip = $value["menu"];
                $tipoOp = $value["tipoOp"];
                $cantidad = $value["cantidad"];
                $precio = $mesaData[0]["precio"];
                $consumido = array("nombreMesero" => $mesero, "tipoOp" => $tipoOp, "cantidad" => $cantidad, "precio" => $precio, "totalACobrar" => $totalACobrar, "descrip" => $descrip);
                array_push($nuevaListaResp, $consumido);
            }
            if ($value["tipoOp"] == 1) {
                $sp = "spSelectAperitivo";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idAper);
                $totalACobrar = $value["cantidad"] * $mesaData[0]["precioAperitivo"];
                $mesero = $value["nombreMesero"];
                $descrip = $value["aperitivo"];

                $tipoOp = $value["tipoOp"];
                $cantidad = $value["cantidad"];
                $precio = $mesaData[0]["precioAperitivo"];

                $consumido = array("nombreMesero" => $mesero, "tipoOp" => $tipoOp, "cantidad" => $cantidad, "precio" => $precio, "totalACobrar" => $totalACobrar, "descrip" => $descrip);

                array_push($nuevaListaResp, $consumido);
            }
        }
        return array("consumido" => $nuevaListaResp);
    }

    public static function ctrCobroEnMesaFactura($cobroEnMesa) {
        $sp = "spMostrarDetalleFact";
        $mesaConsumida = ModeloMesasRest::mdlMostrarMenuSelect($sp, $cobroEnMesa);
        $totalACobrar = 0;
        $nuevaListaResp = [];
        foreach ($mesaConsumida as $key => $value) {
            $idAper = $value["idAperM"];

            if ($value["tipoOp"] == 0) {
                $sp = "spMostrarMenuSelect";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idAper);
                $totalACobrar = $value["cantidad"] * $mesaData[0]["precio"];
                $mesero = $value["nombreMesero"];
                $descrip = $value["menu"];
                $tipoOp = $value["tipoOp"];
                $cantidad = $value["cantidad"];
                $precio = $mesaData[0]["precio"];
                $consumido = array("nombreMesero" => $mesero, "tipoOp" => $tipoOp, "cantidad" => $cantidad, "precio" => $precio, "totalACobrar" => $totalACobrar, "descrip" => $descrip);
                array_push($nuevaListaResp, $consumido);
            }
            if ($value["tipoOp"] == 1) {
                $sp = "spSelectAperitivo";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idAper);
                $totalACobrar = $value["cantidad"] * $mesaData[0]["precioAperitivo"];
                $mesero = $value["nombreMesero"];
                $descrip = $value["aperitivo"];

                $tipoOp = $value["tipoOp"];
                $cantidad = $value["cantidad"];
                $precio = $mesaData[0]["precioAperitivo"];

                $consumido = array("nombreMesero" => $mesero, "tipoOp" => $tipoOp, "cantidad" => $cantidad, "precio" => $precio, "totalACobrar" => $totalACobrar, "descrip" => $descrip);

                array_push($nuevaListaResp, $consumido);
            }
        }
        return array("consumido" => $nuevaListaResp);
    }
    public static function ctrCambioDeMesa($estadoMesa, $mesaCambio) {
        $sp = "spCambioEstadoMesa";
        $mesaConsumida = ModeloMesasRest::mdlCambioDeEstadoMesa($sp, $estadoMesa, $mesaCambio);
        return $mesaConsumida;
    }

    public static function ctrCerrarCuentaMesa($idMesaCerrarCuenta, $listaDataCliente) {
        $listaDataCliente = json_decode($listaDataCliente, true);
        $nit = $listaDataCliente[0][0];
        $sp = "spMostrarNit";
        $mostrarCliente = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $nit);
       
        if (!empty($mostrarCliente)) {
            $idNit = $mostrarCliente[0]["id"];
        } else {
            $nit = $listaDataCliente[0][0];
            $nombre = $listaDataCliente[0][1];
            $direccion = $listaDataCliente[0][2];
            $sp = "spNuevoCliente";
            $nuevoCliente = ModeloMesasRest::mdlNuevoClienteDB($sp, $nit, $nombre, $direccion);
            if ($nuevoCliente) {
                $idNit = $nuevoCliente[0]["Identity"];
            }
        }


        $sp = "spCambioEstadoMesa";
        $estadoMesa = 0;
        $insertEstado = ModeloMesasRest::mdlCambioDeEstadoMesa($sp, $estadoMesa, $idMesaCerrarCuenta);


        $sp = "spMostrarOrdeDeMesa";
        $mesaConsumida = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idMesaCerrarCuenta);
        $totalACobrar = 0;
        foreach ($mesaConsumida as $key => $value) {
            $idAper = $value["idAperM"];
            if ($value["tipoOp"] == 0) {
                $sp = "spMostrarMenuSelect";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idAper);
                $precio = $mesaData[0]["precio"] * $mesaConsumida[0]["cantidad"];
                $totalACobrar = $totalACobrar + $precio;
            }
            if ($value["tipoOp"] == 1) {
                $sp = "spSelectAperitivo";
                $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idAper);
                $precio = $mesaData[0]["precioAperitivo"] * $mesaConsumida[0]["cantidad"];
                $totalACobrar = $totalACobrar + $precio;
            }
        }
//idMesa
//cantidad
        $totalCobro = $totalACobrar;
//estado
        $estado = 1;
//fecha
//idCaliente
        $identityCliente = $idNit;
        $sp = "spNuevaFactura";
        $respuesta = ModeloMesasRest::mdlNuevaFactura($sp, $idMesaCerrarCuenta, $totalCobro, $estado, $identityCliente);

        $identFact = $respuesta[0]["identity"];

        foreach ($mesaConsumida as $key => $value) {
            $sp = "spCulminarMEsas";
            $idOrden = $value["idOrden"];
            $mesaConsumida = ModeloMesasRest::mdlCambioDeEstadoMesa($sp, $identFact, $idOrden);
        }
        return $respuesta;
    }

    public static function ctrMostrarCliente($idClienteMostrarUser) {
        $sp = "spMostrarNit";
        $mostrarCliente = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $idClienteMostrarUser);
        return $mostrarCliente;
    }

    public static function ctrDatosFactura($codigo) {
        $sp="spMostrarDatoFact";
        $mesaData = ModeloMesasRest::mdlMostrarMenuSelectFetchAll($sp, $codigo);
        return $mesaData; 
    }

}
