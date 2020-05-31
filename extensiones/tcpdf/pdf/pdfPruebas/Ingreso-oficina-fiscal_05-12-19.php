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
$repuestaBodega = ControladorRegistroBodega::ctrTraerDatosBodegas($codigo);
$repuestaUnidades = ControladorRegistroBodega::ctrTraerDatosUnidades($codigo);

//$contenedor = $repuestaUnidades[0]["contenedor"];
//$placa = $repuestaUnidades[0]["placa"];
//$piloto = $repuestaUnidades[0]["piloto"];
//$licencia = $repuestaUnidades[0]["licencia"];

$cheque = $repuestaBodega[0]["nombres"].' '.$repuestaBodega[0]["apellidos"];

$fecha_actual = new DateTime();
$cadena_fecha_Descarga = ($repuestaBodega[0]["fecha"])->format("d/m/Y H:i:s A");

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
$mrch = $repuestaOperaciones[0]["mrch"];


$cif = number_format($repuestaOperaciones[0]["cif"],2);
$impuesto = number_format($repuestaOperaciones[0]["impuesto"],2);

$idIngreso = $repuestaUnidades[0]["idIngreso"];
$poliza = $repuestaOperaciones[0]["poliza"];
$numPlaca = $repuestaUnidades[0]["placa"];
$concatenarConsultImagen = "qrCode".$idIngreso.$poliza.$numPlaca.".png";

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf->startPageGroup();

$pdf->AddPage();

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetMargins(6, 0, 6);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// 
//---------------------------------------------------------------------------------------------------
$bloque1 = <<<EOF
	<table style="border: none; padding: none; margin: none;">
		<tr><br/>
			<td style="width:130px; text-align:left;"><img src="images/almacenadoras_logo.png"></td>
	
			<td style="width:432px; text-align:right; font-size:7px;">
                                    <br/>
					NIT: 874108
					<br/>
					Dirección: 24 av. 41-81, Zona 12 
					<br/>
					Teléfono: 2422-3000 
					<br/>
					Email: aintegrada@bi.com.gt
		
				</td>

		</tr>

	</table>
        	<table style="padding:3px; border: none; padding: none; margin: none;">
		<tr>
	
<td style="width:550px; text-align:center; font-size:17px; font-family: 'Source Sans Pro';">Ingreso de mercadería en bodega fiscal</td>
			

		</tr>

	</table>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, PDF_HEADER_STRING);



//-------------------------------------------------------------------------------------------------------
$bloque2 = <<<EOF


	<table style="font-size:7.5px; border: none; padding: none; margin: none;">
		<tr>
			<td style="width:410px">
				Empresa:    $nombreEmpresa<br/>
                                Nit:        $numeroNit,<br/>
                                Bodega No.: $area&nbsp;&nbsp;$numeroArea,<br/>
                                Valor Cif Q.:&nbsp;$cif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Impuestos Q.:&nbsp;$impuesto<br/> 
                                Numero de marchamo:&nbsp;$mrch&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Poliza de Ingreso:&nbsp;$poliza<br/> 
                                <b>Numero de ingreso: $ing</b>
                                
			</td>
			<td style="width:152px">
                            <div style="text-align:right;">
                                    <img  style="width:80px; height:80px; text-align:center;" src="../../imagenesQRCreadas/$concatenarConsultImagen">

   </div>
   </td>			
		</tr>

	</table>	
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

//-------------------------------------------------------------------------------------------------------

$bloque3 = <<<EOF
	<table style="font-size:8px; text-align:center;">
		<tr>
                    <th style="border: 1px solid #030505; background-color:white; width:500px;"><strong>DESCRIPCION DE MERCADERIA</strong></th>
                    <th style="border: 1px solid #030505; background-color:white; width:62px;"><strong>Cantidad</strong></th>
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

//-------------------------------------------------------------------------------------------------------
$repuestaDetalles = ControladorRegistroBodega::ctrTraerDatosBodega($codigo);
if (count($repuestaDetalles)<=3) {
 $fontLetra = "font-size:7px";    
}else if(count($repuestaDetalles)>=4)  {
  $fontLetra = "font-size:6px";     
}
foreach ($repuestaDetalles as $key => $value) {
$nombreEmpresa = $value["nombreEmpresa"];
$detalleMerca = $value["detalleMerca"];
$llave= count($repuestaDetalles);
$nombreDetalle =$nombreEmpresa." - ".$detalleMerca;
$blts = $value["blts"];
$tdDetalleS ="";
$tdDetalle="";
$tdCantidadS ="";
$tdCantidad="";        
$linea = 0;    
if ($key+1 == $llave) {
    
    $tdDetalle = '<td style="border-left: 1px solid #030505; border-right: 1px solid #030505; border-bottom: 1px solid #030505; width:500px; '.$fontLetra.' text-align:left;">'.$nombreDetalle.'</td>';
    $tdCantidad = '<td style="text-align:center; border-right: 1px solid #030505; border-bottom: 1px solid #030505; width:62px; '.$fontLetra.'">'.$blts.'</td>';
    
    
}else {
   
     $tdDetalle = '<td style="border-left: 1px solid #030505; border-right: 1px solid #030505; width:500px; '.$fontLetra.' text-align:left;">'.$nombreDetalle.'</td>';
     $tdCantidad = '<td style="text-align:center; border-right: 1px solid #030505; width:62px;'.$fontLetra.'">'.$blts.'</td>';
   

    
    
    
}

$bloque4 = <<<EOF
	<table style="padding: 2px 5px">
		<tr>
                
        		$tdDetalle
                        $tdCantidad
                        
		</tr>
	</table>	
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

//-------------------------------------------------------------------------------------------------------
$bloque5 = <<<EOF
	<table style="font-size:8px;">
            <tr>
                <th style="border: 1px solid #030505; background-color:white; width:500px; text-align:center"><strong>TOTAL BULTOS INGRESO</strong></th>
                <th style="border: 1px solid #030505; background-color:white; width:62px; text-align:center"><strong>$bultosTotal</strong></th>
            </tr>
	</table>	
EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

//-------------------------------------------------------------------------------------------------------
$bloque6 = <<<EOF

	<table style="font-size:7px; border: none; padding: none; margin: none;">
        
		<tr><br/>
			<td style="width:262px text-align:left;">
				<b>Recibido por:</b> $cheque<br/>
        $cadena_fecha_Descarga
                                    </td>
        <td style="width:262px text-align:left;">
				<b>Montacarguista por:</b> Rene castro cifuentes</td>
		</tr>

	</table>
EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

//-------------------------------------------------------------------------------------------------------
//var_dump($repuestaUnidades);        
foreach ($repuestaUnidades as $key => $value) {
           
         $licencia = $value["licencia"];
         $piloto = $value["piloto"];
         $placa = $value["placa"];
         $contenedor = $value["contenedor"];
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
        
        

	<table style="font-size:7px; border: none; padding: none; margin: none;">
		<tr><br/><br/>
			<td style="width:262px text-align:left;">
				$piloto</td>
        <td style="width:262px text-align:left;">
				<b>Firma recibido:</b>____________________________________</td>
        
		</tr>
        		<tr>
			<td style="width:262px text-align:left;">
				$licencia

                        </td>
        			<td style="width:105px text-align:left;">
				$placa

                        </td>
        		<td style="width:165px text-align:left;">
				$contenedor

                        </td>
		</tr>

	</table><br/>
EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');
}

//-------------------------------------------------------------------------------------------------------


/*
 *
 *  
 * LEYENDA ALMACENADORAS RESPONSABILIDES INGRESO FISCAL 42 / 33 CALLE
 * 
 * 
 */

$bloque8 = <<<EOF

	<table style="font-size:9px; border: none; padding: none; margin: none;">
		<tr><br/>
        
                <td style="font-size:7px width:540px text-align:left;">
		<strong>Nota:</strong>
                    <p style="text-align:justify;">
		El ingreso de la mercadería que se describe en el presente documento, implica la aceptación por parte del su propietario de que la misma se le entregará sin responsabilidad alguna de Almacenadora Integrada, Sociedad Anónima, al portador de la respectiva póliza de importación.<br/>
                La persona que ingrese la mercaderia a la Almacenadora es la responsable de obtener la autorización y aceptación del propietario para el ingreso de la misma. De no existir consentimiento del propietario, la responsabilidad sobre la mercadería recaerá en la persona que ingrese la mercaderia y en ningún caso en la Almacenadora.<br/>
                Almacenadora Integrada, S.A. no se responsabiliza de la merma, deterioro o destrucción de las mercancías derivadas de su propia naturaleza    
				</p>
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


															
															
