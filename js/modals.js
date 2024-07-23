function openModal(data) {
    const { opcion, modulo, id = '', posicion = '', tabla = '' } = data
    let datos
    let titulo
    let btnText
    let items = {
        src: '#modalForm',
        type: 'inline'
    }

    if (modulo)
        switch (opcion) {
            case 'viewDocument':
                items = {
                    src: '#modalEncriptar',
                    type: 'inline'
                }
                $("#btnDecrypt").html(`<button onclick="viewDocument(${id.registro},${id.usuario})" class="btn btn-danger btn-flat">DESCIFRAR</button>`);
                break;
            case 'firmar':
                titulo = `Decretar documento`;
                btnText = `Decretar`;
                items = {
                    src: '#modalFirmar',
                    type: 'inline'
                }

                datos = obtenerDataTable(tabla, posicion)

                if (modulo === 'firmar') {
                    $(".id").val(datos[1])
                }

                break;
            case 'firmarDestino':
                titulo = `Firmar documento`;
                btnText = `Firmar`;
                items = {
                    src: '#modalFirmarDestino',
                    type: 'inline'
                }

                datos = obtenerDataTable(tabla, posicion)

                if (modulo === 'firmarDestino') {
                    $(".id").val(datos[1])
                }

                break;
            case 'firmado':
                titulo = `Detalle de firma`;
                items = {
                    src: '#modalFirmado',
                    type: 'inline'
                }

                datos = obtenerDataTable(tabla, posicion)
                console.log(datos)
                $.ajax({
                    url: "controller/Usuario",
                    method: "POST",
                    data: { id: datos[16], opcion: "obtener_perfil_firma" },
                    success: function (response) {
                        const data = JSON.parse(response);
                        $("#nombreRegistro").html(`<strong>Nombres y Apellidos: </strong>${data.nombres.split(" ")[0]} ${data.apellidos.split(" ")[0]}`)
                        $("#fechaDecretado").html(`<strong>Fecha: </strong> ${datos[15]}`)
                        $("#decreto").html(`<strong>Decreto: </strong> ${datos[11]}`)
                        $("#obsDecreto").html(`<strong>Observaciones: </strong> ${datos[12]}`)

                    }

                })

                $.ajax({
                    url: "controller/Usuario",
                    method: "POST",
                    data: { id: datos[2], opcion: "obtener_perfil_firma" },
                    success: function (response) {
                        const data = JSON.parse(response);
                        $("#destino").html(`<strong>Destino: </strong>${data.nombres.split(" ")[0]} ${data.apellidos.split(" ")[0]}`);
                    }

                })

                break;
            case 'asuntoCompleto':
                titulo = `Asunto`;
                items = {
                    src: '#modalAsunto',
                    type: 'inline'
                }

                $.ajax({
                    url: "controller/Registro",
                    method: "POST",
                    data: { id, opcion: "obtener_registro" },
                    success: function (response) {
                        const data = JSON.parse(response);
                        console.log(response)
                        $("#asuntoCompleto").html(`${data.asunto}`)

                    }

                })
                break;
            case 'firmadoDestino':
                titulo = `Detalle de firma`;
                items = {
                    src: '#modalFirmadoDestino',
                    type: 'inline'
                }

                datos = obtenerDataTable(tabla, posicion)
                console.log(datos)
                $.ajax({
                    url: "controller/Usuario",
                    method: "POST",
                    data: { id: datos[2], opcion: "obtener_perfil_firma" },
                    success: function (response) {
                        const data = JSON.parse(response);
                        $("#nombreValidador").html(`<strong>Nombres y apellidos: </strong>${data.nombres.split(" ")[0]} ${data.apellidos.split(" ")[0]}`)
                        $("#fechaValidador").html(`<strong>Fecha: </strong> ${datos[17]}`)
                        $("#obsValidador").html(`<strong>Observaciones: </strong> ${datos[13]}`)
                    }
                })

                break;
            case 'agregar':
                titulo = `Crear ${modulo}`;
                btnText = `Registrar`;
                if (modulo === 'usuario') {
                    $("#usuario").prop('disabled', false);
                    $("#fotoPerfil").html(`<img src="./img/user.jpg" alt="" class='fotoPerfil'>`);
                }
                $("#btnEncriptar").prop("disabled", true);
                break;
            case 'editar':
                titulo = `Editar ${modulo}`;
                btnText = `Guardar`;
                datos = obtenerDataTable(tabla, posicion)

                if (modulo === 'usuario') {
                    $(".id").val(datos[1])
                    $("#usuario").val(datos[2])
                    $("#usuario").prop('disabled', true)
                    $("#nombres").val(datos[3])
                    $("#apellidos").val(datos[4])
                    $("#rol").val(datos[8])
                    $("#estado").val(datos[9])
                    $("#archivoFoto").val(datos[5])
                    $("#archivoFirma").val(datos[6])
                    $("#fotoPerfil").html(`<img src="./img/fotos/${datos[5]}" alt="" class='fotoPerfil'>`)
                }

                break;
            case 'eliminar':
                titulo = `Eliminar ${modulo}`;
                btnText = `Eliminar`;
                items = {
                    src: '#modalFormDelete',
                    type: 'inline'
                }
                datos = obtenerDataTable(tabla, posicion)
                $(".id").val(datos[1])
                break;
            default:
                console.log('ERROR')
                break;
        }

    $.magnificPopup.open({
        items,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        modal: true,
        callbacks: {
            beforeOpen: function () {
                $(".modalTitle").html(titulo);
                $(".btnSubmit").html(btnText);
                $('.opcion').val(opcion);
            }
        }
    });
}


function obtenerDataTable(tabla, posicion) {

    const table = document.getElementById(tabla)

    const cells = table.rows[posicion].cells

    const len = cells.length

    let data = [];

    for (let i = 0; i < len - 1; i++) {

        if (cells[i].textContent !== '') {
            data.push(cells[i].textContent)
        } else {
            data.push(cells[i].children[0].value)
        }


    }

    return data

}

/*
Modal Dismiss
*/
$(document).on('click', '.modal-dismiss', function (e) {
    e.preventDefault();
    $('form').trigger('reset');
    $.magnificPopup.close();
});