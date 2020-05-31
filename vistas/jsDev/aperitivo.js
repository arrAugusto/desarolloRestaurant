$(document).on("change", "#categoriaP", async function () {
    var categoriaP = document.getElementById("categoriaP").value;
    document.getElementById("categoria").innerHTML = categoriaP + ": ";
    if (categoriaP == "Bebida") {
        var tipo = 1;
        fotoComida(tipo);
    }

    if (categoriaP == "Comida") {
        var tipo = 2;
        fotoComida(tipo);
    }

    if (categoriaP == "Postre") {
        var tipo = 3;
        fotoComida(tipo);
    }
})
$(document).on("change", "#aperitivo", async function () {
    var aperitivo = $(this).val();
    document.getElementById("categoria").innerHTML += aperitivo;

})


$(document).on("change", "#textAreaDescripcion", async function () {
    var aperitivo = $(this).val();
    document.getElementById("descripcionAp").innerHTML = "DESCRIPCIÓN: " + aperitivo;
})

$(document).on("change", "#precio", async function () {
    var precio = $(this).val();
    document.getElementById("price").innerHTML = "PRECIO: Q. " + precio;
})



function fotoComida(tipo) {
    if (tipo == 1) {
        $(".previsualizarEditar").attr("src", "vistas/img/platillos/bebidaDefault.png");

    }
    if (tipo == 2) {
        $(".previsualizarEditar").attr("src", "vistas/img/platillos/platilloDefault.jpg");

    }

    if (tipo == 3) {
        $(".previsualizarEditar").attr("src", "vistas/img/platillos/postreDefault.png");

    }


}

$(document).on("click", ".btnCrearMenu", async function () {
    var nomVar = "selectAperitivo";
    var idAperitivo = $(this).attr("idaperitivo");
    var respAperitivo = await selectAperitivo(nomVar, idAperitivo);
    console.log(respAperitivo);
    if (respAperitivo.length >= 1) {
        document.getElementById("titleAPeritivo").innerHTML = ' <h2>SELECCIÓN DE APERITIVOS</h2>';
        document.getElementById("aperitivosSelect").innerHTML +=
                `
                <div class="form-group input-group">
                        <span class="input-group-addon btnCancelAper" style="background-color: #d9534f; color: #fff;" idAperit=` + respAperitivo[0][0] + `>Cancelar <i class="fa fa-trash"></i></span>
                        <input type="text" class="form-control" value="` + respAperitivo[0][1] + ` ` + respAperitivo[0][2] + `  Precio Q. ` + respAperitivo[0][4] + `" />
                    </div> 
                `;
        if ($(".btnNuevoMenu").length == 0) {
            document.getElementById("titleFooter").innerHTML = `
                    <div class="modal-footer">
            <div class="row">
                    <div class="col-lg-3"><input type="text" placeholder="Ingrese El Nombre del Menú" class="form-control pull-left" id="nombreDelMenu" value="" /></div>
                    <div class="col-lg-3"><input type="number" placeholder="Precio del Menú" id="precioMenu" class="form-control pull-left" value="" /></div>
                    <div class="col-lg-6"><button type="button" class="btn btn-success pull-rigth btnNuevoMenu">Guardar Nuevo Menú</button></div>
                    
                    </div>                        
                    </div>
`;

        }
    }
})




function selectAperitivo(nomVar, idAperitivo) {
    let resp;
    var datos = new FormData();
    datos.append(nomVar, idAperitivo);
    $.ajax({
        async: false,
        url: "ajax/nuevosPlatos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            resp = respuesta;
            console.log(respuesta);
        }, error: function (respuesta) {
            console.log(respuesta);
        }
    })
    return resp;
}

$(document).on("click", ".btnNuevoMenu", async function () {
    var paragraphs = Array.from(document.querySelectorAll(".btnCancelAper"));
    console.log(paragraphs);
    listaMenu = [];
    for (var i = 0; i < paragraphs.length; i++) {
        var idAperitivos = paragraphs[i]["attributes"][2].value;
        ;
        listaMenu.push({idAperitivos});
    }
    var nombreDelMenu = document.getElementById("nombreDelMenu").value;
    var precioMenu = document.getElementById("precioMenu").value;
    var listaMenuString = JSON.stringify(listaMenu);
    if (nombreDelMenu != "" && precioMenu && listaMenu.length >= 1) {
        var respNuevoMen = await nuevoMenuSistema(nombreDelMenu, precioMenu, listaMenuString);
        if (respNuevoMen) {
            Swal.fire({
                title: 'Transacción satisfactoria',
                text: "El nuevo menú fue creado con exito!",
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok!'
            }).then((result) => {
                if (result.value) {
                    location.reload();
                }
            })
        }

    } else {
        alert("invalido");
    }
})


function nuevoMenuSistema(nombreDelMenu, precioMenu, listaMenuString) {
    let resp;
    var datos = new FormData();
    datos.append("nuevoMenu", nombreDelMenu);
    datos.append("precioMenu", precioMenu);
    datos.append("listaMenuString", listaMenuString);

    $.ajax({
        async: false,
        url: "ajax/nuevosPlatos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta) {
                resp = respuesta;
            } else {
                resp = false;
            }

            console.log(respuesta);
        }, error: function (respuesta) {
            console.log(respuesta);
        }
    })
    return resp;
}


$(document).on("click", ".optRightMesa", async function () {
    var mesa = $(this).attr("mesa");

})

$(document).on("click", ".btnMostarMenu", async function () {
    document.getElementById("divTableMenuAperitivos").innerHTML = '<table id="tableMenus" class="table table-hover"></table>';
    var nomVar = "mostrarMenu";
    var valVar = 1;
    var mostrarMen = await mostrarMenusDisponibles(nomVar, valVar);
    console.log(mostrarMen);
    if (mostrarMen != false) {
        listaMenus = [];
        var contador = 0;
        for (var i = 0; i < mostrarMen.length; i++) {
            var contador = contador + 1;
            var nombrePlatillo = mostrarMen[i][1];
            var precio = mostrarMen[i][2];
            var detalleMenu = '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-success bntVerMenu" idDetMenu="' + mostrarMen[i][0] + '" data-toggle="modal" data-target="#modalAperitivos">Ver Menú  <i class="fas fa-carrot"></i></button><button type="button" class="btn btn-info btnAgregarMenu" idDetMenu="' + mostrarMen[i][0] + '" nombreMenu="' + nombrePlatillo + '" precio="' + precio + '">Seleccionar</button></div>';
            listaMenus.push([contador, nombrePlatillo, precio, detalleMenu]);

        }
        $('#tableMenus').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Busqueda:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            data: listaMenus,
            columns: [{
                    title: "#"
                }, {
                    title: "Nombre Menú"
                }, {
                    title: "Precio Menú"
                }, {
                    title: "Acciones"
                }]
        });

    }
})

function mostrarMenusDisponibles(nomVar, valVar) {
    let resp;
    var datos = new FormData();
    datos.append(nomVar, valVar);
    $.ajax({
        async: false,
        url: "ajax/gestionMesas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            if (respuesta) {
                resp = respuesta;
            } else {
                resp = false;
            }

        }, error: function (respuesta) {
            console.log(respuesta);
        }
    })
    return resp;
}
$(document).on("click", ".bntVerMenu", async function () {
    document.getElementById("divTableAperitivos").innerHTML = '<table id="tableAperitivo" class="table table-hover"></table>';
    var idDetMenu = $(this).attr("idDetMenu");
    var nombVar = "mostrarMenuSelect";
    var menuIndivi = await mostrarMenusDisponibles(nombVar, idDetMenu);
    if (menuIndivi) {
        listaAperitivo = [];
        var numero = 0;
        for (var i = 0; i < menuIndivi.length; i++) {
            var idAper = menuIndivi[i][0];
            var nombreAperitivo = menuIndivi[i][2];
            var detalle = menuIndivi[i][3];
            var foto = menuIndivi[i][5];
            if (i == 0) {
                var cantidad = 1;
                listaAperitivo.push({"idAper": idAper, "nomAper": nombreAperitivo, "cantidad": cantidad, "detalle": detalle, "foto": foto});

            }

            if (listaAperitivo.length >= 1) {
                var estado = 0;
                for (var j = 0; j < listaAperitivo.length; j++) {
                    if (listaAperitivo[j].idAper == idAper) {
                        var estado = 1;
                        cantidad = listaAperitivo[j].cantidad + 1;
                        listaAperitivo[j].cantidad = cantidad;
                    }
                }
                if (estado == 0) {
                    var cantidad = 1;
                    listaAperitivo.push({"idAper": idAper, "nomAper": nombreAperitivo, "cantidad": cantidad, "detalle": detalle, "foto": foto});

                }
            }
        }
        listaDefAperitivos = [];
        var numero = 0;
        for (var i = 0; i < listaAperitivo.length; i++) {
            var numero = numero + 1;
            var nomAper = listaAperitivo[i].nomAper;
            var detalle = listaAperitivo[i].detalle;
            var cantidad = listaAperitivo[i].cantidad;
            var foto = listaAperitivo[i].foto;
            var fotoImg = '<img src="' + foto + '" class="img-thumbnail previsualizarEditar" width="50px">';
            listaDefAperitivos.push([numero, nomAper, detalle, cantidad, fotoImg]);
        }

        $("#buttonMenuMins").click();
        $('#tableAperitivo').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Busqueda:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            data: listaDefAperitivos,
            columns: [{
                    title: "#"
                }, {
                    title: "Nombre Aperitivo"
                }, {
                    title: "Detalle"
                }, {
                    title: "Cantidad"
                }, {
                    title: "Foto"
                }]
        });
    }
})

$(document).on("click", ".bntRegresarAtras", async function () {
    $("#buttonAperitivoMins").click();
    $('#modalAperturaRest').modal('show'); // abrir
})
$(document).on("click", ".btnAgregarMenu", async function () {
    var numeroMesa = $(".btnMostarMenu").attr("numeromesa");
    var nombrePlatillo = $(this).attr("nombreMenu");
    var precio = $(this).attr("precio");
    var idDetMenu = $(this).attr("idDetMenu");
    const {value: password} = await Swal.fire({
        title: 'Agregue cantidad de menús',
        input: 'number',
        inputPlaceholder: 'Enter o presione "OK" para continuar',
        inputAttributes: {
            maxlength: 30,
            autocapitalize: 'off',
            autocorrect: 'off'
        }
    })

    if (password) {
        var tipo = 0;
        document.getElementById("divSolicitiudesComida" + numeroMesa).innerHTML += `
    <div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-danger btnTrash btn-xs" cant=` + password + ` idDetMenu=` + idDetMenu + ` id=numeroMesa` + numeroMesa + ` tipoOp=` + tipo + `><i class="fa fa-trash"></i></button>
  <button type="button" class="btn btn-info btn-xs">` + nombrePlatillo + ` Q. ` + precio + `</button>
  <button type="button" class="btn btn-warning btn-xs"><h8>` + password + `</h8></button>

                       </div>
    
`;


    }
})

$(document).on("click", ".btnAgregarIndividual", async function () {
    var numeroMesa = $(".btnMostarMenu").attr("numeromesa");
    var idDetMenu = $(this).attr("idAperitivo");

    var nombreapertivo = $(this).attr("nombreapertivo");
    var precio = $(this).attr("precio");
    const {value: password} = await Swal.fire({
        title: 'Agregue cantidad de menús',
        input: 'number',
        inputPlaceholder: 'Enter o presione "OK" para continuar',
        inputAttributes: {
            maxlength: 30,
            autocapitalize: 'off',
            autocorrect: 'off'
        }
    })

    if (password) {
        var tipo = 1;
        document.getElementById("divSolicitiudesComida" + numeroMesa).innerHTML += `
    <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-danger btnTrash btn-xs"cant=` + password + ` idDetMenu=` + idDetMenu + ` id=numeroMesa` + numeroMesa + ` tipoOp=` + tipo + `><i class="fa fa-trash"></i></button>
  <button type="button" class="btn btn-info btn-xs">` + nombreapertivo + ` Q. ` + precio + `</button>
  <button type="button" class="btn btn-warning btn-xs"><h8>` + password + `</h8></button>

                       </div>
    
`;


    }
})



$(document).on("click", ".bntGenerarOrdenMesa", async function () {


    var numeroMesa = $(this).attr("numeroMesa");
    var nomVar = "nuevaOrden";
    var paragraphs = Array.from(document.querySelectorAll("#numeroMesa" + numeroMesa));
    listaOrden = [];
    for (var i = 0; i < paragraphs.length; i++) {
        var tipoop = paragraphs[i]["attributes"]["tipoop"].value;
        var iddetmenu = paragraphs[i]["attributes"]["iddetmenu"].value;
        var cantidad = paragraphs[i]["attributes"]["cant"].value;
        listaOrden.push([numeroMesa, tipoop, iddetmenu, cantidad]);
    }
    listaOrdenMesa = JSON.stringify(listaOrden);
    var respOrden = await mostrarMenusDisponibles(nomVar, listaOrdenMesa);

    if (respOrden) {
        Swal.fire({
  position: 'top-end',
  type: 'success',
  title: 'Creado correctamente',
  showConfirmButton: false,
  timer: 5000
})
    }

})


$(document).on("click", ".ctaDescuparCobrar", async function () {
    var numMesa = $(this).attr("mesa");
    const ipAPI = "Desocupar Mesa " + numMesa

    const inputValue = fetch(ipAPI)
            .then(response => ipAPI)


    const {value: ipAddress} = await Swal.fire({
        title: '¿Quiere Desocupar Mesa?',
        input: 'text',
        inputValue: inputValue,

        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'You need to write something!'
            }
        }
    })

    if (ipAddress) {
        var numeroMesa = $(this).attr("mesa");
        var estado = 2;
        var cambiarEstado = await cambiarEstadoMesa(estado, numeroMesa);
        console.log(cambiarEstado);
        if (cambiarEstado) {
            Swal.fire({
                type: 'success',
                title: `Desocupando la ${ipAddress}`,
            })
            var dataId = $(this);
            var numMesa = $(dataId).attr("mesa");
            console.log(dataId);
            var otraMesa = "#mesaRed" + numMesa;
            $(dataId).addClass('active');
            $(otraMesa).removeClass('active');

            var otraMesa = "#mesaGr" + numMesa;
            $(dataId).addClass('active');
            $(otraMesa).removeClass('active');

            document.getElementById("tableDetalleConsumo").innerHTML = "";
            $('#modalDeCobroDesocupar').modal('show'); // abrir

            document.getElementById("idMesaHidden").value = numMesa;



            var nomVar = "cobroEnMesa";
            var respOrden = await mostrarMenusDisponibles(nomVar, numeroMesa);
            console.log(respOrden["consumido"]);
            var fechaHidden = document.getElementById("fechaHidden").value;
            document.getElementById("tdDatosGenerales").innerHTML = `
                                                            <div style="font-family:Ruda, Arial, Helvetica, sans-serif;font-weight:300;font-size:11px;line-height:1.4em;border-top:1px solid #fff;border-left:1px solid #fff;padding:8px 5px;background:#fff;color:#333" width="100%" align="left">
                                                                Guatemala : ` + fechaHidden + `<br />Le atendío :` + respOrden["consumido"][0].nombreMesero + `
                                                            </div>

`;
            var contador = 0;
            var totalACobrar = 0;
            for (var i = 0; i < respOrden["consumido"].length; i++) {
                var totalACobrar = totalACobrar + (respOrden["consumido"][i].precio * respOrden["consumido"][i].cantidad);

                var contador = contador + 1;

                var descripcion = respOrden["consumido"][i].descrip;

                var htmlTags = `
<tr>
                                            <td style="font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:13px;line-height:1.4em;border-bottom:1px solid #ddd;padding:8px 5px;" align="center">
                                                ` + contador + `
                                            </td>
                                            <td style="font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:13px;line-height:1.4em;border-bottom:1px solid #ddd;padding:8px 5px;" align="center">
                                                ` + descripcion + `
                                            </td>
                                            <td style="text-align: left; font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:13px;line-height:1.4em;border-bottom:1px solid #ddd;padding:8px 5px;" align="left">
                                                ` + respOrden["consumido"][i].cantidad + `
                                            </td>
                                            <td style="text-align: left; font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:13px;line-height:1.4em;border-bottom:1px solid #ddd;padding:8px 5px;" align="right">
                                                Q.` + respOrden["consumido"][i].precio + `
                                            </td>
                                            <td style="font-family:Open Sans, Arial, Helvetica, sans-serif;font-weight:300;font-size:13px;line-height:1.4em;border-bottom:1px solid #ddd;padding:8px 5px;" align="center">
                                                Q.` + respOrden["consumido"][i].totalACobrar + `
                                            </td></tr>

`;
                $('#tableDetalleConsumo').append(htmlTags);
                document.getElementById("totalCobro").innerHTML = 'Q. ' + totalACobrar;
            }
        }

    } else {
        $('#modalDeCobroDesocupar').modal('hide'); // abrir

        Swal.fire({
            type: 'success',
            title: `Ocupada la Mesa ` + numMesa,
        })

    }




})

$(document).on("click", ".btnCambioEstadoRed", async function () {
    var numMesa = $(this).attr("mesa");
    const ipAPI = "Ocupar Mesa " + numMesa

    const inputValue = fetch(ipAPI)
            .then(response => ipAPI)


    const {value: ipAddress} = await Swal.fire({
        title: 'Enter your IP address',
        input: 'text',
        inputValue: inputValue,

        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'You need to write something!'
            }
        }
    })

    if (ipAddress) {


        Swal.fire({
            type: 'success',
            title: 'Mesa Ocupada!',
        })


        var numeroMesa = $(this).attr("mesa");
        var estado = 1;
        var cambiarEstado = cambiarEstadoMesa(estado, numeroMesa);
        $('#modalAperturaRest').modal('show'); // abrir
        var dataId = $(this);
        var numMesa = $(dataId).attr("mesa");
        console.log(numMesa);
        $(dataId).addClass('active');
        var otraMesa = "#mesaGr" + numMesa;
        $(otraMesa).removeClass('active');
        $(otraMesa).addClass('disabledDiv');
        var otraMesa = "#yellow" + numMesa;
        $(otraMesa).removeClass('disabledDiv');
        $(otraMesa).removeClass('active');
        var tipoOp = 0;
        //    var operacionMesa = await ajaxGestionMesas(tipoOp, numMesa);
        document.getElementById("divButtonsGroups").innerHTML = `
<button type="button" class="btn btn-primary btnMostarMenu"  numeroMesa=` + numMesa + `>Mostrar Menús &nbsp;&nbsp;&nbsp;</button>
<button type="button" class="btn btn-success btnMostrarAperitivo"  numeroMesa=` + numMesa + ` data-toggle="modal" data-target="#modalAperitivosIndiv">Mostrar Aperitivos&nbsp;&nbsp;&nbsp;</button>
<button type="button" class="btn btn-info bntGenerarOrdenMesa" numeroMesa=` + numMesa + `>Generar Orden en Mesa&nbsp;&nbsp;&nbsp;</button>

`;

    } else {
        $('#modalAperturaRest').modal('hide'); // abrir
        Swal.fire({
            type: 'success',
            title: 'Mesa por Desocupar / Mesa Libre!',
        })
    }

})




function cambiarEstadoMesa(estado, numeroMesa) {
    let resp;
    var datos = new FormData();
    datos.append("estadoMesa", estado);
    datos.append("mesaCambio", numeroMesa);
    $.ajax({
        async: false,
        url: "ajax/gestionMesas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            resp = respuesta;
            console.log(respuesta);
        }, error: function (respuesta) {
            console.log(respuesta);
        }
    })
    return resp;
}
$(document).on("click", ".btnCobroDeCuentaConsumida", async function () {
    if ($("#nitCliente").val() == "" || $("#nombreCliente").val() == "" || $("#direccionCliente").val() == "") {
        swal({
            title: "Error",
            text: "¡Los campos de facturacion, NIT, Nombre y Dirección no pueden ser vacís!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });

    } else {


        var idMesaHidden = document.getElementById("idMesaHidden").value;
        const ipAPI = "Liberar Mesa " + idMesaHidden

        const inputValue = fetch(ipAPI)
                .then(response => ipAPI)


        const {value: ipAddress} = await Swal.fire({
            title: '¿Deseas Liberar La Mesa?',
            text: 'Si Liberar  ' + idMesaHidden + '!!',

            input: 'text',
            inputValue: inputValue,

            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!'
                }
            }
        })

        if (ipAddress) {
            listaDataCliente = [];
            var nit = $("#nitCliente").val();
            var nombre = $("#nombreCliente").val();
            var direccion = $("#direccionCliente").val();
            listaDataCliente.push([nit, nombre, direccion]);
            listaCliente = JSON.stringify(listaDataCliente);
            var respuestaFacturar = await facturarMesa(idMesaHidden, listaCliente);
            if (respuestaFacturar.length >= 1) {

                var numeroCodigo = respuestaFacturar[0].identity;
                window.open("extensiones/tcpdf/pdf/Factura-PDF.php?codigo=" + numeroCodigo, "_blank");

                var idMesaHidden = document.getElementById("idMesaHidden").value;
                var dataId = $("#mesaGr" + idMesaHidden);
                var numMesa = $(dataId).attr("mesa");
                var otraMesa = "#mesaRed" + numMesa;
                $(dataId).addClass('active');
                $(otraMesa).removeClass('active');
                var otraMesa = "#yellow" + numMesa;
                $(dataId).addClass('active');
                $(otraMesa).removeClass('active');
                location.reload();
            }
        } else {

        }
    }
})

$(document).on("change", "#nitCliente", async function () {
    var nitCliente = $(this).val();
    console.log("nitCliente");
    var nomVar = "idClienteMostrarUser";
    var respuestaFacturar = await mostrarMenusDisponibles(nomVar, nitCliente);
    if (respuestaFacturar.length >= 1) {
        document.getElementById("nombreCliente").value = respuestaFacturar[0]["nombre"];
        document.getElementById("direccionCliente").value = respuestaFacturar[0]["direccion"];


    }
})

function facturarMesa(idMesaHidden, listaDataCliente) {
    let resp;
    var datos = new FormData();
    datos.append("idMesaCerrarCuenta", idMesaHidden);
    datos.append("listaDataCliente", listaDataCliente);
    $.ajax({
        async: false,
        url: "ajax/gestionMesas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            resp = respuesta;
            console.log(respuesta);
        }, error: function (respuesta) {
            console.log(respuesta);
        }
    })
    return resp;
}

$(document).on("click", ".btnImprimirFact", async function () {
    var identity = $(this).attr("identity");
    window.open("extensiones/tcpdf/pdf/Factura-PDF.php?codigo=" + identity, "_blank");

})


