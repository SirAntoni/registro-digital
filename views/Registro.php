<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Mesa de partes</h2>
            </header>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button onclick="openModal({opcion:'agregar',modulo:'usuario'})"
                            class='modal-form btn btn-sm btn-primary mb-3'>Nuevo</button>
                    </div>
                </div>
                <div class='table-responsive'>
                    <table id='tableUsuarios' class="table table-bordered table-responsive-md table-hover mb-0">
                        <thead class='dark'>
                            <tr>
                                <th width='70px'>Nro</th>
                                <th class='d-none'>Usuario</th>
                                <th>Promotor</th>
                                <th>Tipo</th>
                                <th>Indicativo</th>
                                <th>Fecha</th>
                                <th>Clasif.</th>
                                <th>Asunto</th>
                                <th>Recibido</th>
                                <th width='100px'>Firma / GFH</th>
                                <th width='100px'>F. Destino</th>
                            </tr>
                        </thead>
                        <tbody id='table-usuarios'>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>


<div id="modalForm" class="modal-block modal-block-primary mfp-hide zoom-anim-dialog modal-block-lg">
    <section class="card">
        <form id='formUsuarios' class='form'>
            <header class="card-header">
                <h2 class="modalTitle card-title"></h2>
            </header>

            <div class="card-body">

                <input type="hidden" class='opcion' name='opcion'>
                <input type="hidden" class='id' name='id'>
                <div class="row">
                    <div id='fotoPerfil' class="col-md-4">
                        <img src="./img/user.jpg" alt="" class='fotoPerfil'>
                    </div>
                    <div class="col-sm-8">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="usuario">Usuario</label>
                                    <input type="text" name='usuario' class="form-control" id="usuario"
                                        placeholder="Usuario">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="contrasena">Contraseña</label>
                                    <input type="text" name='contrasena' class="form-control" id="contrasena"
                                        placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="nombres">Nombre</label>
                                    <input type="text" name='nombres' class="form-control" id="nombres"
                                        placeholder="Nombres">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="apellidos">Apellido</label>
                                    <input type="text" name='apellidos' class="form-control" id="apellidos"
                                        placeholder="Apellidos">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label rol="foto">Foto</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input">
                                                <i class="fas fa-file fileupload-exists"></i>
                                                <span class="fileupload-preview"></span>
                                            </div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileupload-exists"><i class='bx bx-refresh'></i></span>
                                                <span class="fileupload-new"><i class='bx bxs-folder-open'></i></span>
                                                <input type="file" name='foto' id='foto' />
                                                <input type="hidden" name='archivoFoto' id='archivoFoto' />
                                            </span>
                                            <a href="#" class="btn btn-default fileupload-exists"
                                                data-dismiss="fileupload"><i class='bx bxs-trash'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label rol="foto">Firma</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input">
                                                <i class="fas fa-file fileupload-exists"></i>
                                                <span class="fileupload-preview"></span>
                                            </div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileupload-exists"><i class='bx bx-refresh'></i></span>
                                                <span class="fileupload-new"><i class='bx bxs-folder-open'></i></span>
                                                <input type="file" name='firma' id='firma' />
                                                <input type="hidden" name='archivoFirma' id='archivoFirma' value="" />
                                            </span>
                                            <a href="#" class="btn btn-default fileupload-exists"
                                                data-dismiss="fileupload"><i class='bx bxs-trash'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="rol">Rol</label>
                                    <select id="rol" name="rol" class="form-control">
                                        <option value="1">Administrador</option>
                                        <option value="2">Operador</option>
                                        <option value="3">Validador</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="estado">Estado</label>
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type='submit' class="btnSubmit btn btn-primary modal-confirm"></button>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </div>
                </div>
            </footer>
        </form>
    </section>
</div>

<div id="modalFormDelete" class="modal-block modal-header-color modal-block-danger mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title">Danger!</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Eliminar Registro</h4>
                    <p>¿Esta seguro que desea eliminar el registro?</p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <form id="formUsuariosDelete" class='form'>
                        <input type="hidden" class='opcion' name='opcion'>
                        <input type="hidden" class='id' name='id'>
                        <button type='submit' class="btnSubmit btn btn-danger">Eliminar</button>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</div>