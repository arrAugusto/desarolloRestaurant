$(document).on("click", ".btnEditarUsuario", async function () {
    var idusuarioEdit = $(this).attr("idusuario");
    var nombreVar = "datosUser";
    var respuesta = await edicionUserUnParam(idusuarioEdit, nombreVar);
    console.log(respuesta.nombre);
    document.getElementById("editarNombre").value = respuesta.nombre;
    document.getElementById("editarUsuario").value = respuesta.usuario;
    document.getElementById("editarPerfil").innerHTML = respuesta.perfil;
    document.getElementById("passwordActual").value = respuesta.password;
    $(".previsualizarEditar").attr("src", respuesta.foto);

})

function edicionUserUnParam(idusuarioEdit, nombreVar) {
    let resp;
    var datos = new FormData();
    datos.append(nombreVar, idusuarioEdit);
    $.ajax({
        async: false,
        url: "ajax/gestorUsuarios.ajax.php",
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


/*=============================================
 SUBIENDO LA FOTO DEL USUARIO
 =============================================*/
$(document).on("change", ".nuevaFoto", async function () {

    var imagen = this.files[0];
    console.log(imagen);
    /*=============================================
     VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
     =============================================*/

    if (imagen.type != "image/jpeg" && imagen.type != "image/png") {

        $(".nuevaFoto").val("");

        swal({
            title: "Error al subir la imagen",
            text: "¡La imagen debe estar en formato JPG o PNG!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });

    } else if (imagen.size > 2000000) {

        $(".nuevaFoto").val("");

        swal({
            title: "Error al subir la imagen",
            text: "¡La imagen no debe pesar más de 2MB!",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });

    } else {
        console.log(70);
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);
        $(datosImagen).on("load", function (event) {
            var rutaImagen = event.target.result;

            $(".previsualizarEditar").attr("src", rutaImagen);
            swal({
                title: "Carga Exitosa",
                text: "¡Cargo correctamente su imagen!",
                type: "success",
                confirmButtonText: "¡Cerrar!"
            });
        });

    }
})


function ajaxGestionMesas(tipoOp, numMesa) {
    let respAjax;
    var datos = new FormData();
    datos.append("opMesa", tipoOp);
    datos.append("numeroMesa", numMesa);
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
    return respAjax;
}
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
