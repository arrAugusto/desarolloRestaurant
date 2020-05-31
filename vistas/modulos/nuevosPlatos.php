    <div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">NUEVOS APERITIVOS</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalEditarUsuario">Registrar nuevo platillo&nbsp;&nbsp;&nbsp;<i class="fa fa-check-circle"></i></button>

                <br/><br/>
            </div>


                <div class="col-12" id="titleAPeritivo"></div>    
                <div class="col-lg-12" id="aperitivosSelect">

                </div>
                <div class="col-12" id="titleFooter">



                </div>
                <br/><br/><br/>


                <div class="col-12">
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
                                
                                <?php $tipo = 0; $tableAperitivos = ControladornuevosPlatosAperitivos::ctrMostrarAperitivos($tipo); ?>
                            </tbody>
                        </table>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div> 



<!--=====================================
MODAL EDITAR USUARIO
======================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->

                <div class="modal-header" style="background:#3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Editar usuario</h4>

                </div>

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-4 mt-5">
                                <div class="form-group">
                                    <label>CATEGORIAS DE COMIDA</label>
                                    <select multiple="" id="categoriaP" name="categoriaP" class="form-control">
                                        <option>Bebida</option>
                                        <option>Comida</option>
                                        <option>Postre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group has-error">
                                    <label>NOMBRE DEL APERITIVO</label>
                                    <input type="text" class="form-control" id="nombreAperitivo" name="nombreAperitivo"  value="" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                </div>
                                <div class="form-group has-error">
                                    <label>DESCRIPCIÓN</label>
                                    <textarea class="form-control" id="textAreaDescripcion" name="textAreaDescripcion" rows="3" onkeyup="javascript:this.value = this.value.toUpperCase();" /></textarea>

                                </div>

                            </div>
                            <div class="col-lg-2">
                                <div class="form-group has-error">
                                    <label>PRECIO DEL PLATO</label>
                                    <input type="number" id="precio" name="precio" class="form-control" value=""  onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                </div>

                                <div class="form-group">

                                    <div class="panel">SUBIR FOTO</div>

                                    <input type="file" class="nuevaFoto" name="nuevaFoto">

                                    <p class="help-block">Peso máximo de la foto 2MB</p>

                                    <img src="vistas/img/platillos/platilloDefault.jpg" class="img-thumbnail previsualizarEditar" width="100px">


                                </div>

                            </div>




                        </div></div>

                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-success btnEditarUsuarioChange">Crear Aperitivo</button>

                    <?php
                    $guardarAperitivo = ControladornuevosPlatosAperitivos::ctrnuevoAperitivo();
                    ?>

                </div>
            </form>

        </div>

    </div>

</div>