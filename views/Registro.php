<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Mesa de partes</h2>
            </header>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-8">

                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input id='filtroFecha' type="text" data-plugin-datepicker
                                        data-plugin-options="{format:'yyyy-mm-dd'}" class="form-control">

                                </div>


                            </div>
                            <div class="col-lg-4">
                                <select class="form-control mb-3" id="filtroEstados">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Firmados</option>
                                    <option value="0">Pendientes</option>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <input type="text" class="form-control" placeholder="Asunto" id="filtrarAsunto">
                            </div>
                        </div>
                    </div>
                    <?php if ($_SESSION['rol'] === "2") { ?>
                        <div class="col-md-4 text-end">
                            <button onclick="openModal({opcion:'agregar',modulo:'registro'})"
                                class='modal-form btn btn-sm btn-primary mb-3'>Crear registro</button>
                        </div>
                    <?php } ?>
                </div>

                <div class='table-responsive'>
                    <table id='tableRegistros' class="table table-bordered table-responsive-md table-hover mb-0">
                        <thead class='dark'>
                            <tr>
                                <th width='70px'>Nro</th>
                                <th class='d-none'>Usuario</th>
                                <th>Promotor</th>
                                <th>Tipo</th>
                                <th>Indicativo</th>
                                <th width='100px'>Fecha</th>
                                <th>Clasif.</th>
                                <th>Asunto</th>
                                <th>Recibido</th>
                                <th>Documento</th>
                                <th class='d-none'>Decreto</th>
                                <th class='d-none'>obs Decreto</th>
                                <th class='d-none'>obs Validador</th>
                                <th width='100px'>F. Destino</th>
                                <th class='d-none'>Firma gdh fecha</th>
                                <th class='d-none'>Firma gdh usuario</th>
                                <th class='d-none'>F. Destino fecha</th>
                                <th width='100px'>Firma / GFH</th>
                               
                                

                            </tr>
                        </thead>
                        <tbody id='table-registros' style='vertical-align:middle'>
                            <tr>
                                <td class='text-center' colspan='11'>Cargando datos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>


<div id="modalForm" class="modal-block modal-block-primary mfp-hide zoom-anim-dialog modal-block-lg">
    <section class="card">
        <form id='formRegistros' class='form'>
            <header class="card-header">
                <h2 class="modalTitle card-title"></h2>
            </header>

            <div class="card-body">

                <input type="hidden" class='opcion' name='opcion'>
                <input type="hidden" class='id' name='id'>
                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label rol="foto">Cargar Documento</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input">
                                                <span class="fileupload-preview"></span>
                                            </div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileupload-exists"><i class='bx bx-refresh'></i></span>
                                                <span class="fileupload-new"><i class='bx bxs-folder-open'></i></span>
                                                <input type="file" name='documento' id='documento' />
                                                <input type="hidden" name='archivoDocumento' id='archivoDocumento'
                                                    value="" />
                                            </span>
                                            <a href="#" class="btn btn-default fileupload-exists"
                                                data-dismiss="fileupload"><i class='bx bxs-trash'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="promotor">Promotor</label>
                                    <select id="promotor" name="promotor" placeholder="Seleccione un promotor.">
                                        <option value='DEICI'>DEICI</option>
                                        <option value='DIE'>DIE</option>
                                    </select>
                                    <!--select name="promotor" id="promotor" class='form-control'>
                                        <option value=''>Seleccionar</option>
                                        <option value='DEICI'>DEICI</option>
                                        <option value='DIE'>DIE</option>
                                    </select-->
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="tipo">Tipo</label>
                                    <select name="tipo" id="tipo" class='form-control'>
                                        <option value=''>Seleccionar</option>
                                        <option value='FAX/M'>FAX/M</option>
                                        <option value='O/M'>O/M</option>
                                        <option value='ODB'>ODB</option>
                                        <option value='PDI'>PDI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="indicativo">Indicativo</label>
                                    <input type="text" name='indicativo' class="form-control" id="indicativo"
                                        placeholder="Indicativo">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="clasificacion">Clasificación</label>
                                    <select name="clasificacion" id="clasificacion" class='form-control'>
                                        <option value=''>Seleccionar</option>
                                        <option value='R'>R</option>
                                        <option value='S'>S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="recibido">Recibido</label>
                                    <input type="text" name='recibido' class="form-control" id="recibido"
                                        placeholder="Recibido">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-2">
                                    <label for="asunto">Asunto</label>
                                    <textarea name="asunto" id="asunto" cols="30" rows="3"
                                        class='form-control'></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type='submit' id="btnRegistro" class="btnSubmit btn btn-primary modal-confirm"></button>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </div>
                </div>
            </footer>
        </form>
    </section>
</div>

<div id="modalFirmar" class="modal-block modal-header-color modal-block-success mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title"></h2>
        </header>
        <form id="formFirmar" class='form'>
            <div class="card-body">
                <input type="hidden" class='opcion' name='opcion'>
                <input type="hidden" class='id' name='id'>
                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="validadores">Validadores</label>
                                    <select name="validador" id="validador" class='form-control'>
                                        <option value=''>Seleccionar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="decreto">Decreto</label>
                                    <select name="decreto" id="decreto" class='form-control'>
                                        <option value=''>Seleccionar</option>
                                        <option value='Control'>Control</option>
                                        <option value='Conocimiento'>Conocimiento</option>
                                        <option value='Trámite'>Trámite</option>
                                        <option value='Acciones adoptadas'>Acciones Adoptadas</option>
                                        <option value='Completamiento'>Completamiento</option>
                                        <option value='Estudio'>Estudio</option>
                                        <option value='Archivo'>Archivo</option>
                                        <option value='Distribución'>Distribución</option>
                                        <option value='Urgente'>Urgente</option>
                                        <option value='Cumplimiento'>Cumplimiento</option>
                                        <option value='Coordinación'>Coordinación</option>
                                        <option value='Análisis'>Análisis</option>
                                        <option value='Respuesta'>Respuesta</option>
                                        <option value='Recomendación'>Recomendación</option>
                                        <option value='Informe Escrito'>Informe Escrito</option>
                                        <option value='Informe Verbal'>Informe Verbal</option>
                                        <option value='Acuse de recibo'>Acuse de recibo</option>
                                        <option value='Muy urgente'>Muy urgente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-2">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="3"
                                        class='form-control'></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type='submit' class="btnSubmit btn btn-success">Firmar</button>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>

                    </div>
                </div>
            </footer>
        </form>
    </section>
</div>

<div id="modalFirmarDestino" class="modal-block modal-header-color modal-block-success mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title"></h2>
        </header>
        <form id="formFirmarDestino" class='form'>
            <div class="card-body">
                <input type="hidden" class='opcion' name='opcion'>
                <input type="hidden" class='id' name='id'>
                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-2">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="3"
                                        class='form-control'></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type='submit' class="btnSubmit btn btn-success">Firmar</button>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>

                    </div>
                </div>
            </footer>
        </form>
    </section>
</div>

<div id="modalFirmado" class="modal-block modal-header-color modal-block-primary mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title"></h2>
        </header>
        <div class="card-body">
           
        <div class="row">
            <div class="col-md-12">
                <p id="nombreRegistro"></p>
                <p id="fechaDecretado"></p>
                <p id="decreto"></p>
                <p id="obsDecreto"></p>
            </div>
        </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <form class='form'>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalFirmadoDestino" class="modal-block modal-header-color modal-block-primary mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title"></h2>
        </header>
        <div class="card-body">
           
        <div class="row">
            <div class="col-md-12">
                <p id="nombreValidador"></p>
                <p id="fechaValidador"></p>
                <p id="obsValidador"></p>
            </div>
        </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <form class='form'>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalAsunto" class="modal-block modal-header-color modal-block-primary mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title"></h2>
        </header>
        <div class="card-body">
           
        <div class="row">
            <div class="col-md-12">
                <p id="asuntoCompleto"></p>
            </div>
        </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <form class='form'>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</div>