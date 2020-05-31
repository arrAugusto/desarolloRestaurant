<?php

require_once "../../../controlador/registroIngresoBodega.controlador.php";
require_once "../../../modelo/registroIngresoBodega.modelo.php";

class imprimirIngresoBodega {

    public $codigo;

    public function traerDatosIngreso() {
// TRAER DATOS DE INGRESO
        $codigo = $this->codigo;
        $cliente = $this->cliente;
        $respuesta = ControladorRegistroBodega::ctrtraerDatosIngreso($codigo, $cliente);

        $respuestaSumaDetalles = ControladorRegistroBodega::ctrSumaDetallesInc($codigo);
        $sumaIncidencias = $respuestaSumaDetalles[0]["sumaIncidencias"];
        $respuestaSumaDetallesMer = ControladorRegistroBodega::ctrSumaDetallesMer($codigo);
        $sumaMerca = $respuestaSumaDetallesMer[0]["sumaMerca"];

        if ($sumaIncidencias == $sumaMerca) {


            $empresa = $respuesta[0]["empresa"];
            $poliza = $respuesta[0]["poliza"];


            require_once('tcpdf_include.php');

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->startPageGroup();

            $pdf->AddPage('L', 'A4');

//---------------------------------------------------------------------------------------------------
            $bloque1 = <<<EOF
	<table>
		<tr>
			<td style="width:150px"><img src="images/almacenadoras_logo.png"></td>
			<td>
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					NIT: 874108
					<br>
					Dirección: 24 av. 41-81, Zona 12
				</div>
				</td>

			<td>
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					Teléfono: 2422-3000
					<br>
					Email: aintegrada@bi.com.gt
				</div>
				</td>



		</tr>

	</table>
EOF;

            $pdf->writeHTML($bloque1, false, false, false, false, PDF_HEADER_STRING);


//-------------------------------------------------------------------------------------------------------
            $bloque2 = <<<EOF
	<table>
		<tr>
			<td style="width:540px"><img src="images/back.jpg"></td>
		</tr>
	</table>
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:396px">
				Empresa:  $empresa
			</td>
			<td style="border: 1px solid #666; background-color:white; width:198px; text-align:left">
				Poliza: $poliza
			</td>
			<td style="border: 1px solid #666; background-color:white; width:198px; text-align:left">
				Fecha: $poliza
			</td>

		</tr>
	</table>
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:396px">
				Auxliar(es) Bodega : Ronny Zuleta
			</td>
			<td style="border: 1px solid #666; background-color:white; width:396px">
				Montacarguista(as) : Rene Castro
			</td>

		</tr>

	</table>
		<table style="font-size:10px; padding:5px 10px;">
		<tr>

			<td style="border: 1px solid #666; background-color:white; width:396px; text-align:left">
				Descarga: 23/07/2019 10:01am || 23/07/2019 11:01am
			</td>
			<td style="border: 1px solid #666; background-color:white; width:396px; text-align:left">
				Total Pos: 350p  //  Total mts: 450m
			</td>

		</tr>
		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>
	</table>
EOF;

            $pdf->writeHTML($bloque2, false, false, false, false, '');


//-------------------------------------------------------------------------------------------------------

            $bloque3 = <<<EOF
	<table style="font-size:10px; padding:5px 10px">
		<tr>

			<td style="border: 1px solid #666; background-color:white; width:30px; text-align:center">#</td>
			<td style="border: 1px solid #666; background-color:white; width:220px; text-align:left">Empresa</td>
			<td style="border: 1px solid #666; background-color:white; width:292px; text-align:left">Descripción</td>

			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center">Ubicación</td>
			<td style="border: 1px solid #666; background-color:white; width:70px; text-align:center">Bultos</td>
			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center">Pos/Mts</td>
		</tr>
	</table>

EOF;

            $pdf->writeHTML($bloque3, false, false, false, false, '');

//----------------------------------------------------------------------------------------------------------
            $respuestaDetalles = ControladorRegistroBodega::ctrMostrarDetalles($codigo);
            $TotalbltsDet = 0;
            $TotalPosDet = 0;
            $TotalMtsDet = 0;

            foreach ($respuestaDetalles as $key => $value) {
                $suma = $key + 1;
                $empresaDetalle = $respuestaDetalles[$key]["RazonSocial"];
                $DescDetalle = $respuestaDetalles[$key]["detalle"];
                $bultosDetalle = $respuestaDetalles[$key]["blts"];
                $pasillo = $respuestaDetalles[$key]["pasillo"];
                $posMts = $respuestaDetalles[$key]["posiciones"] . "pos  | " . $respuestaDetalles[$key]["mts"] . "mts";
                $TotalbltsDet = $TotalbltsDet + $respuestaDetalles[$key]["blts"];
                $TotalPosDet = $TotalPosDet + $respuestaDetalles[$key]["posiciones"];
                $TotalMtsDet = $TotalMtsDet + $respuestaDetalles[$key]["mts"];

                $bloque4 = <<<EOF
	<table style="font-size:10px; padding:5px 10px">
		<tr>

			<td style="border: 1px solid #666; background-color:white; width:30px; text-align:center">$suma</td>
			<td style="border: 1px solid #666; background-color:white; width:220px; text-align:left">$empresaDetalle</td>
			<td style="border: 1px solid #666; background-color:white; width:292px; text-align:left">$DescDetalle</td>

			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center">$pasillo</td>
			<td style="border: 1px solid #666; background-color:white; width:70px; text-align:center">$bultosDetalle</td>
			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center">$posMts</td>
		</tr>
	</table>


EOF;

                $pdf->writeHTML($bloque4, false, false, false, false, '');
            }

//-------------------------------------------------------------------------------------------------------

            $bloque5 = <<<EOF
	<table style="font-size:10px; padding:5px 10px">
			<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>
		<tr>

			<td style="border: 1px solid #666; background-color:white; width:250px; text-align:center">Piloto:</td>
			<td style="border: 1px solid #666; background-color:white; width:292px; text-align:center">Licencia:</td>
			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center"><strong>Total Bultos:</strong></td>
			<td style="border: 1px solid #666; background-color:white; width:160px; text-align:center"><strong>$TotalbltsDet</strong></td>
		</tr>

		<tr>

			<td style="border: 1px solid #666; background-color:white; width:250px; text-align:center">Placa:</td>
			<td style="border: 1px solid #666; background-color:white; width:292px; text-align:center">Contenedor:</td>
			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center"><strong>Total Pos:</strong></td>
			<td style="border: 1px solid #666; background-color:white; width:160px; text-align:center"><strong>$TotalPosDet</strong></td>
		</tr>
		<tr>

			<td style="border: 1px solid #666; background-color:white; width:250px; text-align:center">Marchamo Ingreso:</td>
			<td style="border: 1px solid #666; background-color:white; width:292px; text-align:center">Marchamo Salida:</td>
			<td style="border: 1px solid #666; background-color:white; width:90px; text-align:center"><strong>Total Metros:</strong></td>
			<td style="border: 1px solid #666; background-color:white; width:160px; text-align:center"><strong>$TotalMtsDet</strong></td>
		</tr>
	</table>



EOF;

            $pdf->writeHTML($bloque5, false, false, false, false, '');
            /* /
              $bloquex = <<<EOF

              <table style="font-size:10px; padding:5px 10px;">
              <tr>
              <td style="border: 1px solid #666; background-color:white; width:270px">
              Nombre:  Erasmo Vicente Morales Gonzales
              </td>
              <td style="border: 1px solid #666; background-color:white; width:270px; text-align:left">
              Licencia: 2330-6315-0101
              </td>

              </tr>
              </table>
              <table style="font-size:10px; padding:5px 10px;">
              <tr>
              <td style="border: 1px solid #666; background-color:white; width:270px">
              Placa: C-540CMD / CONTENEDOR: SMLU251365
              </td>
              <td style="border: 1px solid #666; background-color:white; width:270px">
              Marchamo ing: 1235465 / Marchamo sal: 2356633
              </td>
              </tr>
              </table>


              EOF;
              $pdf->writeHTML($bloquex, false, false, false, false, '');
             */
//-------------------------------------------------------------------------------------------------------------
//-------------------------
// SALIDAD DEL ARCHIVO

            $pdf->OutPut('Sin título.pdf');
        }
    }

}

$ingreso = new imprimirIngresoBodega();
$ingreso->codigo = $_GET["codigo"];
$ingreso->cliente = $_GET["cliente"];
$ingreso->traerDatosIngreso();
?>
