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
        case 'agregar':
            titulo = `Registrar ${modulo}`;
            btnText = `Registrar`;
            break;
        case 'editar':
            titulo = `Editar ${modulo}`;
            btnText = `Guardar`;
            datos = obtenerDataTable(tabla, posicion)
            if (modulo === 'usuario') {
                console.log(datos)
                $(".id").val(datos[0])
                $("#usuario").val(datos[1])
                $("#nombre").val(datos[2])
                $("#apellido").val(datos[3])
                $("#rol").val(datos[6])
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
            $(".codigo").val(datos[0])
            $("#nombre").val(datos[1])
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
            beforeOpen: function() {
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
$(document).on('click', '.modal-dismiss', function(e) {
    e.preventDefault();
    $('form').trigger('reset');
    $.magnificPopup.close();
});