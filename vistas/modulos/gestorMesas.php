<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr.header td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.item td:nth-child(3) {
        text-align: right;
    }


    .invoice-box table tr.item td:nth-child(1) {
        width:15px;
    }


    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    .disabledDiv{
        pointer-events:none;
    }
    .container-fluid .centered-vertically{
        display:flex;
        align-items:center;
    }

    .light-wrapper {
        margin: 0px auto;
        height: 130px;
        width: 75px;
        background-color: black;
        padding: 10px;
        border-radius:5px;
        border:1px solid #eee;
    }

    .light {
        margin: 3px auto;
        height: 30px;
        width: 30px;
        background-color: #848484;
        border-radius: 50%;
        box-shadow:inset 0 1px 0 0 rgba(0,0,0,0.2);
    }

    .red.active {
        background-color: #DF0101;
    }
    .yellow.active {
        background-color: #FF0;
    }
    .green.active {
        background-color: #76ff03;
    }

</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">CONTROL DE MESAS</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
<input type="hidden" id="fechaHidden" value="<?php         date_default_timezone_set('America/Guatemala');
        echo $date = date('d-m-Y');?>" />
            <?php
            $usuarios = ControladorMesasRest::ctrMostrarMesasDisponibles();
            ?>

            <!-- /.container-fluid -->
        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal fade bd-example-modal-lg" id="modalAperitivos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Mostra Aperitivos</h4>
                <button type="button" class="close" id="buttonAperitivoMins" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="divTableAperitivos">

                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success bntRegresarAtras">Regresar A menu</button>
            </div>

        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="modalAperturaRest">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Control de Mesas</h4>
                <button type="button" class="close" id="buttonMenuMins" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="btn-group" role="group" aria-label="Basic example" id="divButtonsGroups">


                        </div>

                    </div>
                    <div class="col-lg-12" id="divTableMenuAperitivos"></div>
                </div>
            </div>


        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="modalAperitivosIndiv">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Control de Mesas</h4>
                <button type="button" class="close" id="buttonMenuMins" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="divTableAperitivos">

                        <form role="form" method="post">
                            <table id="tablas" role="grid" class="table dt-responsive table-striped table-hover table-sm">

                                <thead>

                                    <tr>

                                        <th style="width:10px">#</th>
                                        <th>Categoria</th>
                                        <th>Aperitivo</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Foto</th>
                                        <th>Acciones</th>

                                    </tr> 

                                </thead>

                                <tbody>
                                    <?php $tipo = 1;
                                    $tableAperitivos = ControladornuevosPlatosAperitivos::ctrMostrarAperitivos($tipo);
                                    ?>
                                </tbody>
                            </table>

                        </form>


                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="modalDeCobroDesocupar">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Control de Mesas</h4>
                <button type="button" class="close" id="buttonMenuMins" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                                            <div class="col-lg-4">
                                                <label>NIT</label>
                                               <input type="number" placeholder="Ejemplo: 37315439" id="nitCliente" class="form-control" value="" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>NOMBRE CLIENTE</label>
                                                <input type="text" placeholder="Ejemplo: JUAN FERNANDO URREGO" id="nombreCliente" class="form-control" value="" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>DIRECCION</label>
                                                <input type="text" placeholder="Ejemplo: 5A CALLE GUATEMALA ZONA 3" id="direccionCliente" class="form-control" value="" />
                                            </div><br/><br/><br/>
                                        
                    <div class="col-lg-12">
                        <table data-module="table 02" border="0" width="100%" cellpadding="0" cellspacing="0" style="padding:0;background:#ffffff;" class="currentTable">
                            <tr valign="top">
                                <td class="editable">
                                    <table width="650" style="padding:30px;margin:0 auto 0 auto;width:650px;background:#ffffff;border-right:1px solid #ddd;border-left:1px solid #ddd;" cellpadding="0" cellspacing="0" bgcolor="#fff">
                                        <tr valign="top">
                                            <td>
                                                <h1 style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:20px;text-transform:capitalize" align="center" data-color="Headline01" data-size="Headline01" data-min="20" data-max="26">
                                                    POUL BOCUSE
                                                </h1>
                                                <div style="height:1px;background:#59C2C5;width:100px;margin:0 auto 0 auto;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr valign="top">
                                            <td style="font-size: 0; line-height: 0;" height="20">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr valign="top">
                                            <td style="padding:0;width:100%;border:1px solid #ddd">
                                                <!-- ///////////////////////////////// table payment ///////////////////////////////// -->

                                                <table border="0" width="100%" cellpadding="0" cellspacing="0" style="padding:0;margin:0">
                                                    <tr>
                                                        <td style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:bold;font-size:12px;border-top:1px solid #fff;border-left:1px solid #fff;padding:8px 5px;background:#59C2C5;color:#fff" align="center">

                                                        </td>
                                                        <td colspan="5" style="font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:12px;border-top:1px solid #fff;border-right:1px solid #fff;padding:8px 5px;background:#59C2C5;color:#fff" width="100%" align="left">
                                                    CONSUMO DE CLIENTE
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <table border="0" width="100%" cellpadding="0" cellspacing="0" style="padding:0;margin:0">
                                                    <tr valign="top">

                                                        <td id="tdDatosGenerales">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:12px;background-color:#ccc;color:#fff;line-height:22px;border-top:1px solid #fff;border-left:1px solid #fff;border-bottom:1px solid #ddd;padding:5px;width:5%" align="center">
                                                No
                                            </td>
                                            <td style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:12px;background-color:#ccc;color:#fff;line-height:22px;border-top:1px solid #fff;border-left:1px solid #fff;border-bottom:1px solid #ddd;padding:5px;width:40%" align="left">

                                                Descripción
                                            </td>
                                            <td style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:12px;background-color:#ccc;color:#fff;line-height:22px;border-top:1px solid #fff;border-left:1px solid #fff;border-bottom:1px solid #ddd;padding:5px;width:10%" align="center">
                                                Cantidad
                                            </td>

                                            <td style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:12px;background-color:#ccc;color:#fff;line-height:22px;border-top:1px solid #fff;border-left:1px solid #fff;border-bottom:1px solid #ddd;padding:5px;width:10%" align="center">
                                                Precio
                                            </td>
                                            <td style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:12px;background-color:#ccc;color:#fff;line-height:22px;border-top:1px solid #fff;border-left:1px solid #fff;border-bottom:1px solid #ddd;padding:5px;width:10%" align="center">
                                                Total Cobrado
                                            </td>
                                        </tr>
  <tbody id="tableDetalleConsumo">
  </tbody>
                                        <tr>
                                            <td colspan="2" style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:15px;line-height:1.4em;border:1px solid #fff;padding:10px 5px;">
                                            </td>
                                            <td colspan="2" style="font-family:Open sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:15px;line-height:1.4em;border:1px solid #fff;padding:10px 5px;" align="right">
                                                TOTAL A COBRAR
                                            </td>
                                            <td id="totalCobro" style="text-align: left; font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:600;font-size:15px;line-height:1.4em;letter-spacing:1px;border:1px solid #fff;background-color:#59C2C5;color:#fff;padding:10px 5px;" align="right">
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- ///////////////////////////////// table payment end ///////////////////////////////// -->

                                </td>
                            </tr>
                            <tr valign="top">
                                <td style="font-size: 0; line-height: 0;" height="20">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr valign="top">
                                <td>
                                    <div data-color="ContentTable02" data-size="ContentTable02" style="font-family:Open Sans, Arial, Helvetica, sans-serif;font-size:14px;font-weight:300;line-height:1.4em;" align="left">
                                        
                                    </div>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td style="font-size: 0; line-height: 0;" height="20">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr valign="top">
                                <td>
                                    <div data-color="Button01" data-size="Button01" style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:14px;line-height:14px;padding:15px;" align="center">
                                        <a style="background:#59C2C5;border-radius:2px;text-transform:capitalize;padding:10px 20px;color:#fff;font-family:Ruda, Arial, Helvetica, sans-serif;font-size:18px;line-height:1.4em;text-decoration:none" class="editable btnCobroDeCuentaConsumida">Abrir caja y cobrar</a>
                                        <input type="hidden" id="idMesaHidden" value="" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </td>
                        </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12" id="divTableMenuAperitivos"></div>
            </div>
        </div>


    </div>
</div>
</div>
