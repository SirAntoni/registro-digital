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
            case 'firmar':
                titulo = `Decretar documento`;
                btnText = `Decretar`;
                items = {
                    src: '#modalFirmar',
                    type: 'inline'
                }

                datos = obtenerDataTable(tabla, posicion)

                if (modulo === 'firmar') {
                    $(".id").val(datos[0])
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
                    $(".id").val(datos[0])
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
                    data: { id: datos[15], opcion: "obtener_perfil_firma" },
                    success: function (response) {
                        const data = JSON.parse(response);
                        $("#nombreRegistro").html(`<strong>Nombres y Apellidos: </strong>${data.nombres.split(" ")[0]} ${data.apellidos.split(" ")[0]}`)
                        $("#fechaDecretado").html(`<strong>Fecha: </strong> ${datos[14]}`)
                        $("#decreto").html(`<strong>Decreto: </strong> ${datos[10]}`)
                        $("#obsDecreto").html(`<strong>Observaciones: </strong> ${datos[11]}`)

                    }

                })

                break;
            case 'asuntoCompleto':
                titulo = `Asunto`;
                items = {
                    src: '#modalAsunto',
                    type: 'inline'
                }

                datos = obtenerDataTable(tabla, posicion)
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
                    data: { id: datos[1], opcion: "obtener_perfil_firma" },
                    success: function (response) {
                        const data = JSON.parse(response);
                        $("#nombreValidador").html(`<strong>Nombres y apellidos: </strong>${data.nombres.split(" ")[0]} ${data.apellidos.split(" ")[0]}`)
                        $("#fechaValidador").html(`<strong>Fecha: </strong> ${datos[16]}`)
                        $("#obsValidador").html(`<strong>Observaciones: </strong> ${datos[12]}`)
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
                break;
            case 'editar':
                titulo = `Editar ${modulo}`;
                btnText = `Guardar`;
                datos = obtenerDataTable(tabla, posicion)

                if (modulo === 'usuario') {
                    $(".id").val(datos[0])
                    $("#usuario").val(datos[1])
                    $("#usuario").prop('disabled', true)
                    $("#nombres").val(datos[2])
                    $("#apellidos").val(datos[3])
                    $("#rol").val(datos[7])
                    $("#estado").val(datos[8])
                    $("#archivoFoto").val(datos[4])
                    $("#archivoFirma").val(datos[5])
                    $("#fotoPerfil").html(`<img src="./img/fotos/${datos[4]}" alt="" class='fotoPerfil'>`)
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
                $(".id").val(datos[0])
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