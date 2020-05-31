<?php
require_once "../../../controlador/registroIngresoBodega.controlador.php";
require_once "../../../modelo/registroIngresoBodega.modelo.php";



class imprimirIngresoBodega{
	public $codigo;

	public function traerDatosIngreso(){
// TRAER DATOS DE INGRESO
$codigo = $this->codigo;
$repuestaOperaciones = ControladorRegistroBodega::ctrTraerDatosOperaciones($codigo);
$nombreEmpresa = $repuestaOperaciones[0]["empresa"];
$bultosTotal = $repuestaOperaciones[0]["blts"];
$fecha_actual = new DateTime();
$cadena_fecha_actual = ($repuestaOperaciones[0]["fReal"])->format("d/m/Y");
$ing=$repuestaOperaciones[0]["ing"];
$origen = $repuestaOperaciones[0]["origen"];
$bill = $repuestaOperaciones[0]["bill"];
$container = $repuestaOperaciones[0]["container"];
$plc = $repuestaOperaciones[0]["plc"];
$mrch = $repuestaOperaciones[0]["mrch"];
$plto = $repuestaOperaciones[0]["plto"];
$lic = $repuestaOperaciones[0]["lic"];

$cif = number_format($repuestaOperaciones[0]["cif"],2);
$impuesto = number_format($repuestaOperaciones[0]["impuesto"],2);
$poliza = $repuestaOperaciones[0]["poliza"];


require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


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
			<td style="border: 1px solid #666; background-color:white; width:400px">
				Empresa:  $nombreEmpresa
			</td>
			<td style="border: 1px solid #666; background-color:white; width:140px">
				<label style="color:#C7310F"><strong>Ingreso No.</strong></label>:  <label style="color:#C7310F"><strong><em>$ing</em></strong></label>
			</td>			
		</tr>
		<tr>

			<td style="border: 1px solid #666; background-color:white; width:540px">
				Acusamos de recibido:  Dirección: 24 av. 41-81, Zona 12
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
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:30px">#</td>
			<td style="border: 1px solid #666; background-color:white; width:470px">Descripción de Mercancías</td>
			<td style="border: 1px solid #666; background-color:white; width:40px"><label style="font-size:7px">Bultos</label></td>			
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');


//-------------------------------------------------------------------------------------------------------
$repuestaDetalles = ControladorRegistroBodega::ctrTraerDatosBodega($codigo);
foreach ($repuestaDetalles as $key => $value) {
$key=$key+1;
$nombreEmpresa = $value["nombreEmpresa"];
$detalleMerca = $value["detalleMerca"];

$nombreDetalle =$nombreEmpresa." // ".$detalleMerca;

$blts = $value["blts"];
$bloque4 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:30px"><label style="font-size:7px">$key</label></td>
			<td style="border: 1px solid #666; background-color:white; width:470px"><label style="font-size:7px">$nombreDetalle</label></td>
			<td style="border: 1px solid #666; background-color:white; width:40px"><label style="font-size:7px">$blts</label></td>			
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

//-------------------------------------------------------------------------------------------------------

$bloque5 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:180px">Total Cif:   <label style="color:blue"><strong><em>   Q.  $cif</em></strong></label></td>
			<td style="border: 1px solid #666; background-color:white; width:180px">Total Impuestos:   <label style="color:blue"><strong><em>   Q.  $impuesto</em></strong></label></td>
			<td style="border: 1px solid #666; background-color:white; width:180px">Total Bultos:   <label style="color:blue"><strong><em>     $bultosTotal</em></strong></label></td>
		</tr>
	
	</table>	
EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


//-------------------------------------------------------------------------------------------------------

$bloque6 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">

				<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:240px">Origen: $origen</td>
			<td style="border: 1px solid #666; background-color:white; width:150px">Fecha: $cadena_fecha_actual</td>
			<td style="border: 1px solid #666; background-color:white; width:150px">Bl: $bill</td>			
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:240px">Placa: $plc</td>
			<td style="border: 1px solid #666; background-color:white; width:150px">Contenedor: $container</td>
			<td style="border: 1px solid #666; background-color:white; width:150px">Marchamo: $mrch</td>
	
		</tr>
				<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>

<tr>
			<td style="border: 1px solid #666; background-color:white; width:270px">Piloto: $plto </td>

			<td style="border: 1px solid #666; background-color:white; width:270px">Licencia: $lic </td>
</tr>

<tr>
			<td style="border: 1px solid #666; background-color:white; width:540px">Observaciones: Contenedor descargado por Rony Zuleta de 10:00am a 11:00am</td>

</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');



// SALIDAD DEL ARCHIVO

$pdf->OutPut('Sin título.pdf');
	}
	}

	


$ingreso= new imprimirIngresoBodega();
$ingreso -> codigo = $_GET["codigo"];

$ingreso -> traerDatosIngreso();

?>


															
															
