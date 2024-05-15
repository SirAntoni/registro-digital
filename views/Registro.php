<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Mesa de partes</h2>
            </header>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group row pb-3">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input id='filtroFecha' type="text" data-plugin-datepicker
                                        data-plugin-options="{format:'yyyy-mm-dd'}" class="form-control">
                                        
                                </div>
                                
                                
                            </div>
                            <div class="col-lg-6">
                                <select class="form-control mb-3" id="filtroEstados">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Firmados</option>
                                    <option value="0">Pendientes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php if ($_SESSION['rol'] === "1") { ?>
                        <div class="col-md-6 text-end">
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
                                <th width='100px'>Firma / GFH</th>
                                <th class='d-none'>Firma gdh fecha</th>
                                <th class='d-none'>Firma gdh usuario</th>
                                <th class='d-none'>F. Destino fecha</th>
                                <th width='100px'>F. Destino</th>
                                
                            </tr>
                        </thead>
                        <tbody id='table-registros' style='vertical-align:middle'>
                            <tr>
                                <td class='text-center' colspan='10'>Cargando datos...</td>
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
                                    <label for="validador">Validador</label>
                                    <select name="usuario" id="usuario" class='form-control'>
                                        <option value='1'>Asignar validador</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="promotor">Promotor</label>                                 
                                    <select name="promotor" id="promotor" class='form-control'>
                                        <option value='1'>Seleccionar Promotor</option>
                                        <option value='2'>DEICI</option>
                                        <option value='3'>DIE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-2">
                                    <label for="tipo">Tipo</label>
                                    <select name="tipo" id="tipo" class='form-control'>
                                        <option value='1'>Seleccionar Tipo</option>
                                        <option value='2'>FAX/M</option>
                                        <option value='3'>O/M</option>
                                        <option value='4'>ODB</option>
                                        <option value='5'>PDI</option>
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
                                        <option value='1'>Seleccionar Clasificación</option>
                                        <option value='2'>R</option>
                                        <option value='3'>S</option>
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
                        <button type='submit' class="btnSubmit btn btn-primary modal-confirm"></button>
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
        <div class="card-body">
            <div class="modal-wrapper">
                <div class="modal-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="modal-text">
                    <h4 class="font-weight-bold text-dark">Firmar documento</h4>
                    <p>¿Esta seguro que desea firmar el documento?</p>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <form id="formFirmar" class='form'>
                        <input type="hidden" class='opcion' name='opcion'>
                        <input type="hidden" class='id' name='id'>
                        <button type='submit' class="btnSubmit btn btn-success">Firmar</button>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</div>

<div id="modalFirmado" class="modal-block modal-header-color modal-block-primary mfp-hide zoom-anim-dialog">
    <section class="card">
        <header class="card-header">
            <h2 class="modalTitle card-title"></h2>
        </header>
        <div class="card-body">
            <div class='table-responsive'>
                <table id='tableDetalleFirma' class="table table-bordered table-responsive-md table-hover mb-0">
                    <thead class='dark'>
                        <tr>
                            <th>Firmado</th>
                            <th>Fecha</th>
                            <th>Firma</th>
                        </tr>
                    </thead>
                    <tbody id='table-detalle-firma'>
                        <tr>
                            <td style='vertical-align:middle;' id='nameFirma'>Antony Culqui</td>
                            <td style='vertical-align:middle;' id='fechaFirma'></td>
                            <td class='text-center' style='vertical-align:middle;' id='imgFirma'></td>
                        </tr>
                    </tbody>
                </table>
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