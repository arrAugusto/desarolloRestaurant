<?php
require_once "../../../controlador/registroIngresoBodega.controlador.php";
require_once "../../../modelo/registroIngresoBodega.modelo.php";

require_once "../../../controlador/historiaIngresosFisacales.controlador.php";
require_once "../../../modelo/historiaIngresosFisacales.modelo.php";

class imprimirIngresoBodega{
	public $codigo;

	public function traerDatosIngreso(){
// TRAER DATOS DE INGRESO
$codigo = $this->codigo;
$repuestaOperaciones = ControladorRegistroBodega::ctrTraerDatosOperaciones($codigo);
$respuestaPiloto =  ModeloHistorialIngresos::mdlMostrarDetallesPlts($codigo);

$area = $repuestaOperaciones[0]["area"];
$numeroArea = $repuestaOperaciones[0]["numeroArea"];
$nombreEmpresa = $repuestaOperaciones[0]["empresa"];
$numeroNit = $repuestaOperaciones[0]["numeroNit"];
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
		<tr><br/>
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


	<table style="font-size:9px; padding:5px 10px;">
		<tr>
			<td style="width:400px">
				Empresa:    $nombreEmpresa<br/>
                                Nit:        $numeroNit,<br/>
                                Bodega No.: $area&nbsp;&nbsp;$numeroArea,<br/>
                                Valor Cif Q.:&nbsp;$cif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Impuestos Q.:&nbsp;$impuesto<br/> 
                                Numero de marchamo:&nbsp;$mrch&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Poliza de Ingreso:&nbsp;$poliza<br/> 
                                <b>Numero de ingreso: $ing</b>
                                
			</td>
			<td style="width:140px">
                            <div style="text-align:right;">
                            <img  style="width:80px; height:80px; text-align:center;" src="images/QR.png">
                            </div>
   </td>			
		</tr>

	</table>	
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');


//-------------------------------------------------------------------------------------------------------
$bloque3 = <<<EOF
	<table style="font-size:9px; padding:5px 10px; text-align:center; ">
		<tr>
			<th style="border: 1px solid #030505; background-color:white; width:470px;"><strong>Descripción de Mercancías</strong></th>
                        <th style="border: 1px solid #030505; background-color:white; width:70px;"><strong>Cantidad</strong></th>
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');


//-------------------------------------------------------------------------------------------------------
$repuestaDetalles = ControladorRegistroBodega::ctrTraerDatosBodega($codigo);
foreach ($repuestaDetalles as $key => $value) {
$nombreEmpresa = $value["nombreEmpresa"];
$detalleMerca = $value["detalleMerca"];
$llave= count($repuestaDetalles);
$nombreDetalle =$nombreEmpresa." // ".$detalleMerca;
$blts = $value["blts"];
$tdDetalleS ="";
$tdDetalle="";
$tdCantidadS ="";
$tdCantidad="";        
$linea = 0;    
if ($key+1 == $llave) {
    $linea = 1;
    $tdDetalle = '<td style="border-left: 1px solid #030505; width:470px; font-size:7px; border-bottom: 1px solid #030505;">';
    $tdDetalleS = $tdDetalle.$nombreDetalle.'</td>';
    $tdCantidad = '<td style="border-left: 1px solid #030505; border-right: 1px solid #030505; border-bottom: 1px solid #030505; width:70px; font-size:8px; text-align:center;">';
    $tdCantidadS = $tdCantidad.$blts.'</td>';
    
    
}else {
    
        $tdDetalle = '<td style="border-left: 1px solid #030505; width:470px; font-size:7px;">';
    $tdDetalleS = $tdDetalle.$nombreDetalle.'</td>';
    $tdCantidad = '<td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:70px; font-size:8px; text-align:center;">';
    $tdCantidadS= $tdCantidad.$blts.'</td>';
    $linea = 0;
    
    
    
}

$bloque4 = <<<EOF
	<table style="padding: 2px 7px;">
		<tr>
                
        		$tdDetalleS
                        $tdCantidadS
                        
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

//-------------------------------------------------------------------------------------------------------
$bloque5 = <<<EOF
	<table style="font-size:9px; padding:5px 10px;">
		<tr>
			<th style="width:470px; text-align:left;"><strong>TOTAL BULTOS INGRESO</strong></th>
                        <th style="width:70px; border-bottom: 1px solid #030505; text-align:center;"><strong>$bultosTotal</strong></th>
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


//-------------------------------------------------------------------------------------------------------
$bloque6 = <<<EOF

	<table style="font-size:9px; padding:0px 10px;">
		<tr><br/>
			<td style="width:270px text-align:left;">
				<b>Recibido por:</b> Augusto Gomez</td>
        <td style="width:270px text-align:left;">
				<b>Recibido por:</b> Augusto Gomez</td>
		</tr>

	</table>	
EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

//-------------------------------------------------------------------------------------------------------
//var_dump($respuestaPiloto);        
foreach ($respuestaPiloto as $key => $value) {
           
         $licencia = $respuestaPiloto[0]["licencia"];
         $piloto = $respuestaPiloto[0]["piloto"];
         $placa = $respuestaPiloto[0]["placa"];
         $contenedor = $respuestaPiloto[0]["contenedor"];
         if ($key==0) {
           $licencia = '<b>Licencia:</b> '.$licencia; 
           $piloto =  '<b>Nombre piloto:</b> '.$piloto;
           $placa = '<b>Placa:</b> '.$placa;
           $contenedor = '<b>Transporte:</b> '.$contenedor;
         }else if ($key>=1) {
            $licencia = ', '.$licencia;
            $piloto = ', '.$piloto;
            $placa = ', '.$placa;
            $contenedor = ', '.$contenedor;
         }
$bloque7 = <<<EOF
        
        

	<table style="font-size:9px; padding:0px 10px;">
		<tr><br/>
			<td style="width:270px text-align:left;">
				$piloto</td>
        <td style="width:270px text-align:left;">
				<b>Firma recibido:</b>____________________________________</td>
        
		</tr>
        		<tr>
			<td style="width:270px text-align:left;">
				$licencia

                        </td>
        			<td style="width:105px text-align:left;">
				$placa

                        </td>
        		<td style="width:165px text-align:left;">
				$contenedor

                        </td>
		</tr>

	</table>
EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');
}

//-------------------------------------------------------------------------------------------------------
$bloque8 = <<<EOF

	<table style="padding:0px 10px;">
		<tr><br/>
			<td style="font-size:9px; width:50px text-align:right;">
				<b>Nota:</b></td>
        
                <td style="font-size:7px; width:470px text-align:left;">
															
		El ingreso de la mercadería que se describe en el presente documento, implica la aceptación por parte del su propietario de que la misma se le entregará sin responsabilidad alguna de Almacenadora Integrada, Sociedad Anónima, al portador de la respectiva póliza de importación.<br/>
                La persona que ingrese la mercaderia a la Almacenadora es la responsable de obtener la autorización y aceptación del propietario para el ingreso de la misma. De no existir consentimiento del propietario, la responsabilidad sobre la mercadería recaerá en la persona que ingrese la mercaderia y en ningún caso en la Almacenadora.<br/>
                Almacenadora Integrada, S.A. no se responsabiliza de la merma, deterioro o destrucción de las mercancías derivadas de su propia naturaleza    
				
   </td>
		</tr>

	</table>	
EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');
//-------------------------------------------------------------------------------------------------------
/*
$bloque6 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">

				<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>



	</table>	
EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

*/

// SALIDAD DEL ARCHIVO

$pdf->OutPut('Sin título.pdf');
	}
	}

	


$ingreso= new imprimirIngresoBodega();
$ingreso -> codigo = $_GET["codigo"];

$ingreso -> traerDatosIngreso();

?>


															
															
