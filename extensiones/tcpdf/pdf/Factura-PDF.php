<?php

require_once '../../../controlador/gestionMesas.controlador.php';
require_once '../../../modelo/gestionMesas.modelo.php';
require_once '../../../controlador/usuarios.controlador.php';
require_once '../../../modelo/usuarios.modelo.php';

class imprimirFacturaRestaurante {

    public $numCodigo;

    public function traerDatosIngreso() {
        $codigo = $this->codigo;
        $sp = "spMostrarDetalleFact";
        $respuestas = ControladorMesasRest::ctrCobroEnMesaFactura($codigo);
        $atendio = $respuestas["consumido"][0]["nombreMesero"];
        $factura = $codigo + 1000000;
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->startPageGroup();

        $pdf->AddPage();

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetMargins(6, 0, 6);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);


//---------------------------------------------------------------------------------------------------
        $bloque1 = <<<EOF
	<table style="border: none; padding: none; margin: none;">
		<tr><br/>
			<td style="width:130px; text-align:left;"><img src="images/restaUralogo.jpeg" width="100px;"></td>
                        <td style="width:432px; text-align:right; font-size:7px;">
                            <br/>
                            NIT: 3531543
                            <br/>
                            Dirección: 24 av. 41-81, Zona 16 
                            <br/>
                            Teléfono: 2425-3000 
                            <br/>
                            Email: laPiedar@barCafe.com.gt
                        </td>
		</tr>
	</table>
        <table style="padding:3px; border: none; padding: none; margin: none;">
            <tr>
                <td style="width:550px; text-align:center; font-size:17px; font-family: 'Source Sans Pro'; color:red;">Factura.:   $factura</td>
            </tr>
	</table>
EOF;

        $pdf->writeHTML($bloque1, false, false, false, false, PDF_HEADER_STRING);

//-------------------------------------------------------------------------------------------------------
        $respuetaDatosCliente = ControladorMesasRest::ctrDatosFactura($codigo);
        $nit = $respuetaDatosCliente[0]["nit"];
        $nombre = $respuetaDatosCliente[0]["nombre"];
        $direccion = $respuetaDatosCliente[0]["direccion"];
        $cadena_fecha_Descarga = $respuetaDatosCliente[0]["fechaEmision"];

        $bloque2 = <<<EOF
	<table style="font-size:9px; border: none; padding: none; margin: none;">
		<tr><br/><br/>
                    <td style="width:75px"><b>Fecha. :</b></td><td style="width:250px">$cadena_fecha_Descarga</td>
                </tr>
   	<tr>
                    <td style="width:75px"><b>Nit. :</b></td><td style="width:250px">$nit</td>
                </tr>
             
   <tr>
                    <td style="width:75px"><b>NOmbre.:</b></td><td style="width:250px">$nombre</td>
                </tr>
                <tr>
                    <td style="width:75px"><b>Dirección.:</b></td><td style="width:250px">$direccion</td>
                </tr>
                <tr>
                    <td style="width:75px"><b>Le Atendío.:</b></td><td style="width:250px">$atendio&nbsp;&nbsp;</td>
                </tr>

        </table>	
   
EOF;

        $pdf->writeHTML($bloque2, false, false, false, false, '');
//-------------------------------------------------------------------------------------------------------

        $bloque3 = <<<EOF
	<table style="font-size:8px; text-align:left;">
	<tr><br/>
          <br/>
            <th style="border: 1px solid #030505; text-align:center; background-color:white; width:30px;"><strong>No.</strong></th>
            <th style="border: 1px solid #030505; text-align:center; background-color:white; width:286px;"><strong>DESCRIPCIÓN</strong></th>
            <th style="border: 1px solid #030505; text-align:center; background-color:white; width:77px;"><strong>CANTIDAD</strong></th>
            <th style="border: 1px solid #030505; text-align:center; background-color:white; width:77px;"><strong>PRECIO</strong></th>
            <th style="border: 1px solid #030505; text-align:center; background-color:white; width:90px;"><strong>TOTAL COBRAR</strong></th>
           </tr>
   </table>	
EOF;
        $pdf->writeHTML($bloque3, false, false, false, false, '');
//-------------------------------------------------------------------------------------------------------

        $contador = 0;
        $totalCobrado = 0;
        foreach ($respuestas["consumido"] as $key => $value) {
            $contador = $contador + 1;
            $descripcion = $value["descrip"];
            $cantidad = $value["cantidad"];
            $precio = $value["precio"];
            $total = $cantidad * $precio;
            $totalCobrado = $totalCobrado + $total;
            $bloque3 = <<<EOF
	<table style="font-size:8px; text-align:center;">
	<tr>
            <td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:30px;">$contador</td>
            <td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:286px;">$descripcion</td>
            <td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:77px;">$cantidad</td>
            <td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:77px;">Q. $precio</td>
            <td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:90px;">Q. $total</td>
           </tr>
   </table>	
EOF;
            $pdf->writeHTML($bloque3, false, false, false, false, '');
        }


        $bloque3 = <<<EOF
	<table style="font-size:8px; text-align:left;">
	<tr>
            <th rowspan="4" style="border: 1px solid #030505; text-align:center; background-color:white; width:470px;"><strong>TOTAL COBRADO</strong></th>
            <th style="border: 1px solid #030505; text-align:center; background-color:white; width:90px;"><strong>Q. $totalCobrado</strong></th>
           </tr>
   </table>	
EOF;
        $pdf->writeHTML($bloque3, false, false, false, false, '');


        $pdf->OutPut('Sin título.pdf');
    }

}

$numCodigo = new imprimirFacturaRestaurante();
$numCodigo->codigo = $_GET["codigo"];
ob_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
$numCodigo->traerDatosIngreso();
?>




