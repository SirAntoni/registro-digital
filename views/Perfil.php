<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Editar Perfil</h2>
            </header>
            <form id="formPerfil">
                <input type="hidden" name="opcion" value="editar_perfil">
                <div class="card-body">
                    <div class="row">
                        <div id='fotoPerfil' class="col-md-3">
                            <img src="./img/user.jpg" alt="" class='fotoPerfil'>
                        </div>
                        <div class="col-sm-9">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-2">
                                        <label for="usuario">Usuario</label>
                                        <input type="text" name='usuario' disabled="true" class="form-control"
                                            id="usuario" placeholder="Usuario">
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
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists"><i class='bx bx-refresh'></i></span>
                                                    <span class="fileupload-new"><i
                                                            class='bx bxs-folder-open'></i></span>
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
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists"><i class='bx bx-refresh'></i></span>
                                                    <span class="fileupload-new"><i
                                                            class='bx bxs-folder-open'></i></span>
                                                    <input type="file" name='firma' id='firma' />
                                                    <input type="hidden" name='archivoFirma' id='archivoFirma'
                                                        value="" />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists"
                                                    data-dismiss="fileupload"><i class='bx bxs-trash'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type='submit' class="btnSubmit btn btn-primary modal-confirm">Editar</button>
                        </div>
                    </div>
                </footer>
            </form>
        </section>
    </div>
</div>