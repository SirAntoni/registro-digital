
const url = new URL(window.location.href);
const params = new URLSearchParams(url.search);

$(function () {

    cargar_perfil();

    if (params.get('view') === "usuarios") {
        listar_usuarios();
        store_usuarios();
        delete_usuarios();
    }

    if (params.get('view') === "perfil") {
        obtener_perfil();
        editar_perfil();
    }

});

const cargar_perfil = () => {
    $.ajax({
        url:"controller/Usuario",
        method: "POST",
        data:{opcion:"obtener_perfil"},
        success: function(data){
            const perfil = JSON.parse(data)
            const {nombres,apellidos,rol,foto} = perfil 
            let rolHeader = "";
            console.log(rol)
            if(rol === "1"){
                rolHeader = "Administrador"
            }else if(rol === "2"){
                rolHeader = "Operador"
            }else if(rol === "3"){
                rolHeader = "Validador"
            }

            $("#nameHeader").html(`${nombres.split(" ")[0]} ${apellidos.split(" ")[0]}`)
            $("#rolHeader").html(`${rolHeader}`)
            $("#imgHeader").html(`<img src="img/fotos/${foto}" alt="${nombres.split(" ")[0]} ${apellidos.split(" ")[0]}" class="rounded-circle"
            data-lock-picture="img/fotos/${foto}" />`)
        }
    })
}

const obtener_perfil = () => {
    $.ajax({
        url: "controller/Usuario",
        method: "POST",
        data: {opcion: 'obtener_perfil'},
        success: function(data){
            const perfil = JSON.parse(data);
            $("#usuario").val(perfil.usuario)
            $("#nombres").val(perfil.nombres)
            $("#apellidos").val(perfil.apellidos)
            $("#archivoFoto").val(perfil.foto)
            $("#archivoFirma").val(perfil.firma)
            $("#fotoPerfil").html(`<img src="./img/fotos/${perfil.foto}" alt="" class='fotoPerfil'>`)
            cargar_perfil();
        }
    })
}

const editar_perfil = () => {
    $('#formPerfil').submit(function (e) {
        e.preventDefault();
        const data = new FormData($("#formPerfil")[0])

        $.ajax({
            url: 'controller/Usuario',
            method: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
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

                    obtener_perfil();

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
                    if (usuario.rol === "1") {
                        rol = "Administrador"
                    } else if (usuario.rol === "2") {
                        rol = "Operador"
                    } else if (usuario.rol === "3") {
                        rol = "Validador"
                    }

                    html = html + `
                    <tr> <td class='text-center'>${usuario.id}</td><td class='d-none'>${usuario.usuario}</td><td>${usuario.nombres}</td><td>${usuario.apellidos}</td> <td class='d-none'>${usuario.foto}</td><td class='d-none'>${usuario.firma}</td>
                    <td>${rol}</td><td class='d-none'>${usuario.rol}</td> <td>${usuario.estado}</td> <td width='30px' class="text-center">
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

const store_usuarios = function () {
    $('#formUsuarios').submit(function (e) {
        e.preventDefault();
        const data = new FormData($("#formUsuarios")[0])

        $.ajax({
            url: 'controller/Usuario',
            method: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
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

                    listar_usuarios();
                    $.magnificPopup.close();
                    $('#formUsuarios').trigger('reset');

                }
            }
        })
    })
}

const delete_usuarios = function () {
    $('#formUsuariosDelete').submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize()
        $.ajax({
            url: 'controller/Usuario',
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
                    listar_usuarios();
                    $.magnificPopup.close();
                }
            }
        })
    })
}

