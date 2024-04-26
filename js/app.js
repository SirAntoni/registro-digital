
const url = new URL(window.location.href);
const params = new URLSearchParams(url.search);

$(function () {

    //if (params.get('view') === "usuarios") {
    listar_usuarios();
    //store_categorias();
    //delete_categoria();
    //}

});

const store_categorias = function () {
    $('#formCategorias').submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize()
        $.ajax({
            url: 'controller/categorias',
            method: 'POST',
            data: data,
            success: function (data) {
                const response = JSON.parse(data);
                if (response.status === 'error') {
                    Swal.fire(
                        response.status,
                        response.message,
                        'error'
                    )
                } else {
                    Swal.fire(
                        response.status,
                        response.message,
                        'success'
                    )
                    cargar_categorias();
                    $.magnificPopup.close();
                    $('#formCategorias').trigger('reset');

                }
            }
        })
    })
}

const delete_categoria = function () {
    $('#formCategoriasDelete').submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize()
        $.ajax({
            url: 'controller/categorias',
            method: 'POST',
            data: data,
            success: function (data) {
                const response = JSON.parse(data)
                if (response.status === 'error') {
                    Swal.fire(
                        response.status,
                        response.message,
                        'error'
                    )
                } else {
                    Swal.fire(
                        response.status,
                        response.message,
                        'success'
                    )
                    cargar_categorias();
                    $.magnificPopup.close();
                }
            }
        })
    })
}

const listar_usuarios = function () {
    $.ajax({
        url: 'controller/Usuario',
        success: function (response) {
            const data = JSON.parse(response);
            let html = ``;
            let position = parseInt(1)
            if (data.length > 0) {
                data.map((usuario) => {
                    let rol = null;

                    if(usuario.rol === "1"){
                        rol = "Administrador"
                    }else if(usuario.rol === "2"){
                        rol = "Operador"
                    }else if(usuario.rol === "3"){
                        rol = "Validador"
                    }

                    console.log(usuario.rol)

                    html = html + `
                    <tr> <td class='text-center'>${usuario.id}</td><td class='d-none'>${usuario.usuario}</td><td>${usuario.nombres}</td><td>${usuario.apellidos}</td> <td class='d-none'>${usuario.foto}</td> <td>${rol}</td><td class='d-none'>${usuario.rol}</td> <td width='30px' class="text-center">
                    <a href='#' onclick="openModal({opcion:'editar',modulo:'usuario',id:${usuario.id}, posicion: ${position}, tabla: 'tableUsuarios'})"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#" class="delete-row" onclick="openModal({opcion:'eliminar',modulo:'usuario',id:${usuario.id}, posicion: ${position}, tabla: 'tableUsuarios'})"><i class="far fa-trash-alt"></i></a>
                    </td></tr>`;
                    position++
                })
            } else {
                html = html + `<tr><td class='text-center' colspan='5'>No se encontraron resultados</td></tr>`;
            }

            $("#table-usuarios").html(html);

        }
    })
}
