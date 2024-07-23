
const url = new URL(window.location.href);
const params = new URLSearchParams(url.search);

$(function () {
    
   
        $("#documento").change(function(){
            var archivo = $(this).prop('files')[0];
            if (archivo) {
                $("#btnEncriptar").prop("disabled", false);
            } else {
                $("#btnEncriptar").prop("disabled", true);
            }
        });
    

    let document = localStorage.getItem('data_cia_21');
    if(document)  restore(document);
   
    logout();
    cifrar();
    

    if (params.get('view') === "registros") {

        cargar_perfil_2();
        store_registros();
        obtener_validadores();
        filtrarRegistros();
        firmarDocumento();
        filtrarPendientes();
        firmarDocumentoDestino();
        filtrarAsunto();
        $('#promotor').selectize({
            create: true, // Permite al usuario crear nuevas opciones
            sortField: 'text'
        });

        $('#tipo').selectize({
            create: true, // Permite al usuario crear nuevas opciones
            sortField: 'text'
        });

        $('#clasificacion').selectize({
            create: true, // Permite al usuario crear nuevas opciones
            sortField: 'text'
        });

    } else {
        cargar_perfil();
    }



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

const cifrar = () => {
    $("#btnEncriptar").click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Desea cifrar el registro?",
            showCancelButton: true,
            confirmButtonText: "Cifrar",
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire("Registro cifrado", "", "success");
            }
          });

          $("#btnEncriptar").prop("disabled", true);

    });
}



const validarDocumento = () => {
    const fileInput = document.getElementById('documento');
    const file = fileInput.files[0];

    if (!file) {
        Swal.fire(
            'Error',
            'Por favor, selecciona un archivo.',
            'error'
        )
        return false;
    }

    if (file.type !== 'application/pdf') {
        Swal.fire(
            'Error',
            'Solo se permiten archivos PDF.',
            'error'
        )
        return false;
    }
}

const filtrarPendientes = () => {
    $("#filtroEstados").on("change", function () {
        listar_registros();
    })
}

const filtrarAsunto = () => {
    $("#filtrarAsunto").on("keyup", function () {
       
        listar_registros();
    })
}

async function cargar_perfil_2() {
    try {
        await cargar_perfil();
        setTimeout(() => {
            listar_registros();
        }, 1000)
    } catch (error) {
        reject(error)
    }
}

const cargar_perfil = () => {
    return new Promise((resolve, reject) => {
        try {
            $.ajax({
                url: "controller/Usuario",
                method: "POST",
                data: { opcion: "obtener_perfil" },
                success: function (data) {
                    const perfil = JSON.parse(data)
                    const { id, nombres, apellidos, rol, foto } = perfil
                    let rolHeader = "";
                    if (rol === "1") {
                        rolHeader = "Administrador"
                    } else if (rol === "2") {
                        rolHeader = "Operador"
                    } else if (rol === "3") {
                        rolHeader = "Validador"
                    }

                    localStorage.setItem('usuario_id', id)
                    localStorage.setItem('rol', rol)

                    $("#nameHeader").html(`${nombres.split(" ")[0]} ${apellidos.split(" ")[0]}`)
                    $("#rolHeader").html(`${rolHeader}`)
                    $("#imgHeader").html(`<img src="img/fotos/${foto}" alt="${nombres.split(" ")[0]} ${apellidos.split(" ")[0]}" class="rounded-circle"
                data-lock-picture="img/fotos/${foto}" />`)

                }
            })
            resolve();
        } catch (error) {
            reject(error);
        }

    })
}

const firmarDocumento = () => {
    $("#formFirmar").submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.ajax({
            url: "controller/Registro",
            method: "POST",
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

                    listar_registros();
                    $.magnificPopup.close();
                    $('#formFirmar').trigger('reset');

                }
            }
        })
    })
}

const firmarDocumentoDestino = () => {
    $("#formFirmarDestino").submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.ajax({
            url: "controller/Registro",
            method: "POST",
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

                    listar_registros();
                    $.magnificPopup.close();
                    $('#formFirmar').trigger('reset');

                }
            }
        })
    })
}

const logout = () => {
    $("#logout").click(function (e) {
        e.preventDefault();
        console.log('Hola');
        if(localStorage.getItem('data_cia_21')) localStorage.removeItem('usuario_id');
        let document = localStorage.getItem('data_cia_21');
        if(document)  restore(document);
        window.location = 'logout'
    })
}

const filtrarRegistros = () => {
    $("#filtroFecha").on('changeDate', function (e) {
        listar_registros();
    })
}

const obtener_validadores = () => {
    $.ajax({
        url: "controller/Usuario",
        method: "POST",
        data: { opcion: "listar_validadores" },
        success: function (response) {
            const data = JSON.parse(response);

            let opciones = `<option value=''>-- Seleccione --</option>`;
            data.map(v => {
                opciones = opciones + `<option value='${v.id}'>${v.nombres} ${v.apellidos}</option>`
            })
            $("#validador").html(opciones)
            // const fecha = new Date();
            // const fechaFormateada = `${fecha.getFullYear()}-${fecha.getUTCMonth()}-${fecha.getDay()}`;
            // $("#filtroFecha").val(fechaFormateada)

        }
    })
}

const listar_registros = function () {

    return new Promise((resolve, reject) => {
        const filtro = $("#filtroFecha").val();
        $.ajax({
            url: 'controller/Registro',
            method: "POST",
            success: function (response) {
                const data = JSON.parse(response);
                let html = ``;
                let position = parseInt(1)

                const filtroEstados = $("#filtroEstados").val();
                const filtroAsunto = $("#filtrarAsunto").val();
                let data2 = [];

                if (filtroEstados !== "") {
                    data2 = data.filter(r => r.firma_destino === filtroEstados);
                }else if(filtroAsunto !== ""){
                    data2 = data.filter(r => {
                        if(filtroAsunto == '') return r.asunto
                        const regex = new RegExp(filtroAsunto, "i");
                        return regex.test(r.asunto)
                    });
                } else {
                    data2 = data.filter(r => r.fecha.split(" ")[0] === filtro)
                }

                if (data2.length > 0) {
                    data2.map((registro) => {

                        let asunto = registro.asunto;

                        if(registro.asunto.length > 10){
                            asunto = `${registro.asunto.substring(0, 10)}... <a href='#' onclick="openModal({opcion:'asuntoCompleto',modulo:'asuntoCompleto',id:${registro.id}, posicion: ${position}, tabla: 'tableRegistros'})">Ver más</a>`
                        }


                        let firma_gdh = ``;
                        let firma_destino = ``;
                        const usuario_id = localStorage.getItem('usuario_id');
                        const rol = localStorage.getItem('rol');

                        if (rol === "1") {

                            firma_gdh = `<td width='30px' class="text-center">
                            <button onclick="openModal({opcion:'firmar',modulo:'firmar',id:${registro.usuario_id}, posicion: ${position}, tabla: 'tableRegistros'})" class='btn btn-secondary' >Decretar</button>
                            </td>`;

                            firma_destino = `<td width='30px' class="text-center"><button class='btn btn-secondary' disabled='true'>Pendiente</button></td>`;

                            if (registro.firma_gdh === '1') {
                                firma_gdh = `<td width='30px' class="text-center">
                                <button class='btn btn-success' onclick="openModal({opcion:'firmado',modulo:'firmado_gdh',id:${registro.firma_gdh_usuario}, posicion: ${position}, tabla: 'tableRegistros'})" class='btn btn-secondary' >Decretado</button>
                                </td>`;
                            }

                            if (registro.firma_destino === "1") {
                                firma_destino = `<td width='30px' class="text-center">
                            <button class='btn btn-success' onclick="openModal({opcion:'firmadoDestino',modulo:'firmadoDestino',id:${registro.usuario_id}, posicion: ${position}, tabla: 'tableRegistros'})"  >Recibido</button>
                            </td>`;
                            }


                        }

                        if (rol === "2") {

                            firma_gdh = `<td width='30px' class="text-center"><button class='btn btn-secondary' disabled='true'>Pendiente</button></td>`;
                            firma_destino = `<td width='30px' class="text-center"><button class='btn btn-secondary' disabled='true'>Pendiente</button></td>`;

                            if (registro.firma_gdh === "1") {
                                firma_gdh = `<td width='30px' class="text-center">
                                <button class='btn btn-success' onclick="openModal({opcion:'firmado',modulo:'firmado_gdh',id:${registro.firma_gdh_usuario}, posicion: ${position}, tabla: 'tableRegistros'})" class='btn btn-secondary' >Decretado</button>
                                </td>`;
                            }

                            if (registro.firma_destino === "1") {
                                firma_destino = `<td width='30px' class="text-center">
                                <button class='btn btn-success' onclick="openModal({opcion:'firmadoDestino',modulo:'firmadoDestino',id:${registro.firma_gdh_usuario}, posicion: ${position}, tabla: 'tableRegistros'})" class='btn btn-secondary' >Recibido</button>
                                </td>`;
                            }

                        }

                        if (rol === "3") {
                            firma_gdh = `<td width='30px' class="text-center">
                            <button class='btn btn-success' onclick="openModal({opcion:'firmado',modulo:'firmado_gdh',id:${registro.firma_gdh_usuario}, posicion: ${position}, tabla: 'tableRegistros'})" class='btn btn-secondary' >Decretado</button>
                            </td>`;

                            if (registro.firma_destino === '0') {
                                firma_destino = `<td width='30px' class="text-center">
                                <button class='btn btn-secondary' onclick="openModal({opcion:'firmarDestino',modulo:'firmarDestino',id:${registro.usuario_id}, posicion: ${position}, tabla: 'tableRegistros'})">Firmar</button>
                                </td>`;
                            } else {
                                firma_destino = `<td width='30px' class="text-center">
                            <button class='btn btn-success' onclick="openModal({opcion:'firmadoDestino',modulo:'firmadoDestino',id:${registro.usuario_id}, posicion: ${position}, tabla: 'tableRegistros'})"  >Recibido</button>
                            </td>`;
                            }


                        }

                        html = html + `
                    <tr> <td class='text-center'>${registro.id}</td><td class='d-none'>${registro.usuario_id}</td><td>${registro.promotor}</td><td>${registro.tipo}</td> <td>${registro.indicativo}</td><td >${registro.fecha}</td>
                    <td>${registro.clasificacion}</td><td>${asunto}</td><td>${registro.recibido}</td><td class='text-center' width='100px'><a href="#" onclick="openModal({opcion:'viewDocument',modulo:'viewDocument',id:{registro: ${registro.id},usuario:${registro.usuario_id}}, posicion: ${position}, tabla: 'tableRegistros'})"  ><i class='bx bxs-file-pdf bx-md'></i></a></td><td class='d-none'>${registro.decreto}</td><td class='d-none'>${(registro.obs_admin === '') ? "-":registro.obs_admin}</td><td class='d-none'>${(registro.obs_validador === "" ? "-":registro.obs_validador)}</td>${firma_gdh}<td class='d-none'>${registro.firma_gdh_fecha}</td><td class='d-none'>${registro.firma_gdh_usuario}</td><td class='d-none'>${registro.firma_destino_fecha}</td>${firma_destino}</tr>`;
                        position++
                    })


                } else {
                    html = html + `<tr><td class='text-center' colspan='11'>No se encontraron resultados</td></tr>`;
                }

                $("#table-registros").html(html);

            }
        })
    })

}

function viewDocument(id,userId = null) {
    
    $.ajax({
        url: 'controller/Registro',
        method: 'POST',
        data: { id, opcion: "obtener_documento" },
        success: function (response) {
            const data = JSON.parse(response);

            let url_document = `documentos/${data.nameDocument}`;

            if (userId !== null) {
                url_document = `documentos/${data.nameDocument}&userId=${userId}`;
            }
            console.log(url_document);
            localStorage.setItem('data_cia_21', data.destination);

            window.open(`pdf/view?file=${url_document}`);
            $.magnificPopup.close();
        }
    })
}

function restore(path){
    console.log("path: ",path);
    $.ajax({
        url: 'controller/Registro',
        method: 'POST',
        data: { path, opcion: "restore" },
        success: function (response) {
            console.log(response);
            localStorage.removeItem('data_cia_21');
        }
    })
}

const store_registros = function () {
    $('#formRegistros').submit(function (e) {
        e.preventDefault();

        if (validarDocumento() === false) return;

        const data = new FormData($("#formRegistros")[0])
        $('#btnRegistro').prop('disabled', true);
        $.ajax({
            url: 'controller/Registro',
            method: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#btnRegistro').prop('disabled', false);
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

                    listar_registros();
                    $.magnificPopup.close();
                    $('#formRegistros').trigger('reset');

                }
            }
        })
    })
}

const obtener_perfil = () => {
    $.ajax({
        url: "controller/Usuario",
        method: "POST",
        data: { opcion: 'obtener_perfil' },
        success: function (data) {
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

