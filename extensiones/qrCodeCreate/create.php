<?php

$textqr="Hola mundo mi primer QR copiado";//Recibo la variable pasada por post
$sizeqr="100";//Recibo la variable pasada por post

include('vendor/autoload.php');//Llamare el autoload de la clase que genera el QR
use Endroid\QrCode\QrCode;
$direccion = "imagenesQRCreadas/";
if (!file_exists($direccion)) {
	mkdir($direccion);
}
$codigoQR = new QrCode($textqr);
# La ruta en donde se guardará el código
$nombreArchivoParaGuardar = $direccion."/codigo_qr.png";
# Escribir archivo
$codigoQR->writeFile($nombreArchivoParaGuardar);