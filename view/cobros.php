<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][8]["ver"] == 1) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php include('./layout/head.php'); ?>
        </head>

        <body class="hold-transition skin-blue sidebar-mini">
            <div class="wrapper">

                <!-- start header -->
                <?php include('./layout/header.php') ?>
                <!-- end header -->
                <!-- start menu -->
                <?php include('./layout/menu.php') ?>
                <!-- end menu -->

                <!-- modal nueva Empresa  -->
                <div class="row">
                    <div class="modal fade" id="NuevaEmpresaPersona">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="box box-default">
                                    <div class="box-body">
                                        <div class="modal-header">
                                            <button type="button" class="close" id="btnCloseEmpresa">
                                                <i class="fa fa-close"></i>
                                            </button>
                                            <h4 class="modal-title">
                                                <i class="fa fa-building-o">
                                                </i> Registrar Empresa
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label for="txtRuc">RUC: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-btn">
                                                                <button type="button" id="btnSunat" class="btn btn-default btn-flat"><img src="./images/sunat_logo.png" width="16" height="16" /></button>
                                                            </div>
                                                            <input id="txtRuc" type="number" class="form-control" placeholder="Ingrese ruc" required="" minlength="11">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="NombreComercial">Nombre/Razón Social: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="NombreComercial" type="text" class="form-control" placeholder="Nombre Comercial" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="DireccionEmpresa">Dirección: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="DireccionEmpresa" type="text" class="form-control" placeholder="Dirección" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Tlf_Celular">Telefono/Celular:</label>
                                                        <input id="Tlf_Celular" type="number" class="form-control" placeholder="telefono o celular" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Pagina_web">Pagina Web:</label>
                                                        <input id="Pagina_web" type="text" class="form-control" placeholder="página web" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="Email_Empresa">Correo Electrónico:</label>
                                                        <input id="Email_Empresa" type="text" class="form-control" placeholder="Correo electónico" required="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                            <button type="submit" class="btn btn-danger" id="btnAceptarAddEmpresa">
                                                <i class="fa fa-check"></i> Aceptar</button>
                                            <button type="button" class="btn btn-primary" id="btnCancelarAddEmpresa">
                                                <i class="fa fa-remove"></i> Cancelar</button>
                                        </div>
                                    </div>
                                    <div id="divLoad">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal new Bussinees -->

                <!-- modal start ingenieros -->
                <?php include './layout/cobros/cobrosingenieros.php'; ?>
                <!-- modal end ingenieros -->

                <!-- modal detalle del ingreso -->
                <?php include './layout/cobros/detalleingreso.php'; ?>
                <!--end modal history enginner  -->

                <!-- modal start colegiatura-->
                <?php include './layout/cobros/colegiatura.php'; ?>
                <!-- modal end colegiatura-->

                <!-- modal start cuotas -->
                <?php include './layout/cobros/cuotas.php'; ?>
                <!-- modal end cuotas -->

                <!-- modal start certificado -->
                <?php include './layout/cobros/certificados.php'; ?>
                <!-- modal start certificado -->

                <!-- modal start peritaje -->
                <?php include './layout/cobros/peritaje.php'; ?>
                <!-- modal end peritaje -->

                <!-- modal start otros -->
                <?php include './layout/cobros/otros.php'; ?>
                <!-- modal end otros -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content">

                        <!-- <div class="row"> -->
                        <div class="row">

                            <div class="col-md-8">
                                <!-- panel izquierdo superior-->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h5 class="no-margin"> Generar cobro</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn-group" role="group">
                                                    <button id="btnIngenieros" type="button" class="btn btn-primary" data-toggle="modal">
                                                        <i class="fa fa-group"></i> Ingenieros
                                                    </button>
                                                    <button id="btnColegitura" type="button" class="btn btn-default" data-toggle="modal">
                                                        <i class="fa fa-plus"></i> Colegiatura
                                                    </button>
                                                    <button id="btnCuotas" type="button" class="btn btn-default" data-toggle="modal">
                                                        <i class="fa fa-plus"></i> Cuotas
                                                    </button>
                                                    <div class="btn-group" role="group">
                                                        <button id="btnCertificado" type="button" class="btn btn-default dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-plus"></i> Certificado <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                            <li><button id="btnCertHabilidad" type="button" class="btn btn-default">Certificado de Habilidad(A)</button></li>
                                                            <li><button id="btnCertResidenciaObra" type="button" class="btn btn-default">Certificado de Residencia de Obra(B)</button></li>
                                                            <li><button id="btnCertProyecto" type="button" class="btn btn-default">Certificado de Proyecto(C)</button></li>
                                                        </ul>
                                                    </div>
                                                    <button id="btnPeritaje" type="button" class="btn btn-default" data-toggle="modal">
                                                        <i class="fa fa-plus"></i> Peritaje
                                                    </button>
                                                    <button id="btnOtro" type="button" class="btn btn-default" data-toggle="modal">
                                                        <i class="fa fa-plus"></i> Otros
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                                        <th width="5%">#</th>
                                                        <th width="15%">Cantidad</th>
                                                        <th width="35%">Concepto</th>
                                                        <!-- <th width="15%">Precio</th> -->
                                                        <th width="20%">Monto</th>
                                                        <th width="10%">Quitar</th>
                                                    </thead>
                                                    <tbody id="tbIngresos">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- panel izquierdo inferior-->

                                <!-- HISTORIAL DE COBROS-->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h5 class="no-margin"> Historial de cobro</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <button class="btn btn-danger" id="btnIzquierdaHistorial">
                                                        <i class="fa fa-toggle-left"></i>
                                                    </button>
                                                    <span id="lblPaginaActualHistorial" class="font-weight-bold margin">0</span>
                                                    <span class="margin">a</span>
                                                    <span id="lblPaginSiguienteHistorial" class="font-weight-bold margin">0</span>
                                                    <button class="btn btn-danger" id="btnDerechaHistorial">
                                                        <i class="fa fa-toggle-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover" style="border-width: 1px; border-style: dashed; border-color: #E31E25;">
                                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                                            <th style="text-align: center;" width="5%">#</th>
                                                            <th style="text-align: center;" width="10%">Recibo</th>
                                                            <th style="text-align: center;" width="15%">Fecha de Cobro</th>
                                                            <th style="text-align: center;" width="25%">Concepto</th>
                                                            <th style="text-align: center;" width="15%">Monto</th>
                                                            <th style="text-align: center;" width="30%">Observacion</th>
                                                            <th style="text-align: center;" width="10%">Detalle</th>
                                                        </thead>
                                                        <tbody id="tbHistorial">
                                                            <tr class="text-center">
                                                                <td colspan="7">
                                                                    <p>No se ha seleccionado ningún ingeniero.</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- panel derecho de cobro -->
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h5 class="no-margin">Detalle del Cobro</h5>
                                    </div>

                                    <div class="panel-body">

                                        <?php
                                        if ($_SESSION["Permisos"][8]["crear"]) {
                                            echo '<div class="row">
                                                 <div class="col-md-12">
                                                <button id="btnCobrar" class="btn btn-success btn-block">
                                                    <div class="col-md-6 text-left">
                                                        <h4>COBRAR</h4>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <h4 id="lblSumaTotal">0.00</h4>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>';
                                        } ?>

                                        <?php
                                        if ($_SESSION["Permisos"][8]["crear"]) {
                                            echo ' <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h5>Empresa a Facturar</h5>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" id="btnAddEmpresa" class="btn btn-primary btn-flat">Nuevo</button>
                                                        </div>
                                                        <select class="form-control select2" id="cbEmpresa">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                        } ?>

                                        <div class="row">
                                            <div class="col-md-12 text-left no-margin">
                                                <h5>Comprobante</h5>
                                                <select class="form-control" id="cbComprobante">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>N° Cip</h5>
                                                        <h5 id="lblCipSeleccionado">--</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>Tipo</h5>
                                                        <h5 id="lblTipoIngenieroSeleccionado">--</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>Ultimo Pago</h5>
                                                        <h5 class="text-primary description-header" id="lblUltimoPago">--</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>Hábil Hasta</h5>
                                                        <h5 class="text-primary description-header" id="lblHabilHasta">--</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5>Capitulo</h5>
                                                        <h5 id="lblCapitulo">--</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>Especialidad</h5>
                                                        <h5 id="lblEspecialidad">--</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <h5>N° Documento</h5>
                                                <h5 id="lblDocumentSeleccionado">--</h5>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <h5>Ingeniero</h5>
                                                <h4 id="lblDatosSeleccionado">--</h4>
                                            </div>

                                            <div class="col-md-12 text-left">
                                                <h5>Fecha Colegiatura</h5>
                                                <h5 id="lblFechaColegiatura">--</h5>
                                            </div>

                                            <div class="col-md-12 ">
                                                <div class="clearfix">
                                                    <span class="pull-left" id="lblYears">0 AÑOS PARA VITALICO</span>
                                                    <span class="pull-right"></span>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar" style="width: 0%;" id="lblProgress"></div>
                                                </div>
                                                <!-- <h5>Fecha Colegiatura</h5>
                                            progress-bar-green
                                                    <h5 id="lblDireccionSeleccionado">--</h5> -->
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- </div> -->
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <!-- start footer -->
                <?php include('./layout/footer.php') ?>
                <!-- end footer -->
            </div>
            <!-- ./wrapper -->

            <!-- Select2 -->
            <script src="js/tools.js"></script>
            <script src="js/cobros/cobrosingenieros.js"></script>
            <script src="js/cobros/colegiatura.js"></script>
            <script src="js/cobros/cuotas.js"></script>
            <script src="js/cobros/certificados.js"></script>
            <script src="js/cobros/peritaje.js"></script>
            <script src="js/cobros/otros.js"></script>
            <script>
                let tools = new Tools();
                //cuotas
                let cuotas = [];
                let countCurrentDate = 0;
                let yearCurrentView = "";
                let monthCurrentView = "";
                let tipoCuotas = 0;
                let cuotasEstate = false;
                let cuotasInicio = "";
                let cuotasFin = "";

                //colegiatura
                let colegiaturas = [];
                let colegiaturaEstado = false;

                //certficado de habilidad
                let certificadoHabilidad = {};
                let certificadoHabilidadEstado = false;

                //certificado de residencia de obra
                let certificadoResidenciaObra = {};
                let certificadoResidenciaObraEstado = false;

                //certificado de proyecto
                let certificadoProyecto = {};
                let certificadoProyectoEstado = false;

                //peritaje
                let peritaje = {};
                let peritajeEstado = false;

                //ingresos totales
                let arrayIngresos = [];
                let sumaTotal = 0;

                //paginacion ingenieros
                let state = false;
                let opcion = 0;
                let totalPaginacion = 0;
                let paginacion = 0;
                let filasPorPagina = 10;

                let idDNI = 0;
                let cip = 0;
                let tipoColegiado = "";

                let comprobantes = [];
                let UsarRuc = false;
                let newEmpresa = 0;

                let editView = "<?= $_SESSION["Permisos"][8]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][8]["eliminar"]; ?>";
                let idUsuario = <?= $_SESSION['IdUsuario'] ?>;

                let modelCobrosIngenieros = new CobroIngenieros();
                let modelColegiatura = new Colegiatura();
                let modelCuotas = new Cuotas();
                let modelCertificado = new Certificado();
                let modelPeritaje = new Peritaje();
                let modelOtros = new Otros();

                $(document).ready(function() {

                    // comprobantes
                    loadComprobantes();

                    // empresas asociadas al ingeniero
                    loadEmpresaPersona();

                    //ingenieros
                    modelCobrosIngenieros.componentesIngenieros();

                    //colegiatura
                    modelColegiatura.componentesColegiatura();

                    //coutas
                    modelCuotas.componentesCuotas();

                    //certificado
                    modelCertificado.componentesCertificado();

                    //peritaje
                    modelPeritaje.componentesPeritaje();

                    //otros
                    modelOtros.componentesOtros();

                    //cobro
                    componentesRegistrarIngreso();

                    // añadir empresas asociadas al ingeniero
                    $("#btnAddEmpresa").click(function() {
                        $("#NuevaEmpresaPersona").modal("show");
                    });
                    // modelCobrosIngenieros.loadEmpresaPersona(idDNI);

                    $("#btnCloseEmpresa").click(function() {
                        clearModalAddEmpresa();
                    });

                    $("#btnCancelarAddEmpresa").click(function() {
                        clearModalAddEmpresa();
                    });

                    $("#btnAceptarAddEmpresa").click(function() {
                        crudEmpresa();
                    });

                    $("#cbComprobante").change(function() {
                        for (let i = 0; i < comprobantes.length; i++) {
                            if (comprobantes[i].IdTipoComprobante == $(this).val()) {
                                if (comprobantes[i].UsarRuc == "1") {
                                    UsarRuc = true;
                                } else {
                                    UsarRuc = false;
                                }
                                break;
                            }
                        }
                    });

                    $("#btnSunat").click(function() {
                        if ($("#txtRuc").val().trim() == '') {
                            tools.AlertWarning("Ingenieros", "Ingrese un ruc en el campo.");
                            $("#txtRuc").focus();
                        } else if ($("#txtRuc").val().length !== 11) {
                            tools.AlertWarning("Ingenieros", "El ruc debe tener 11 caracteres.");
                            $("#txtRuc").focus();
                        } else {
                            loadSunatApi($("#txtRuc").val());
                        }

                    });

                    $("#btnSunat").keypress(function(event) {
                        if (event.keyCode == 13) {
                            if ($("#txtRuc").val().trim() == '') {
                                tools.AlertWarning("Ingenieros", "Ingrese un ruc en el campo.");
                                $("#txtRuc").focus();
                            } else if ($("#txtRuc").val().length !== 11) {
                                tools.AlertWarning("Ingenieros", "El ruc debe tener 11 caracteres.");
                                $("#txtRuc").focus();
                            } else {
                                loadSunatApi($("#txtRuc").val());
                            }
                        }
                        event.preventDefault();
                    });

                    $("#cbEmpresa").on('change', function() {
                        console.log($("#cbEmpresa").val());
                    });

                });

                function loadComprobantes() {
                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "comprobante"
                        },
                        beforeSend: function() {
                            $("#cbComprobante").empty();
                            comprobantes = [];
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                comprobantes = result.data;
                                $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                                for (let value of comprobantes) {
                                    $("#cbComprobante").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>')
                                }
                                for (let value of comprobantes) {
                                    if (value.Predeterminado == "1") {
                                        $("#cbComprobante").val(value.IdTipoComprobante);
                                        break;
                                    }
                                }
                            } else {
                                $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                            }
                        },
                        error: function(error) {
                            $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                        }
                    });
                }

                function loadEmpresaPersona() {
                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "empresaPersona"
                        },
                        beforeSend: function() {
                            $("#cbEmpresa").empty();
                        },
                        success: function(result) {

                            if (result.estado == 1) {
                                $("#cbEmpresa").append('<option value="">- Seleccione Empresa -</option>');
                                for (let value of result.data) {
                                    $("#cbEmpresa").append('<option value="' + value.IdEmpresa + '">' + value.RazonSocial + '</option>');
                                }
                                $('#cbEmpresa').select2();
                                if (newEmpresa != 0) {
                                    $('#cbEmpresa').val(newEmpresa).trigger('change.select2');
                                }
                            } else {
                                $("#cbEmpresa").append('<option value="">- Seleccione -</option>');
                            }
                        },
                        error: function(error) {
                            $("#cbEmpresa").append('<option value="">- Seleccione -</option>');
                        }
                    });
                }

                function componentesRegistrarIngreso() {
                    $("#btnCobrar").click(function() {
                        registrarIngreso();
                    });

                    $("#btnCobrar").keypress(function(event) {
                        if (event.keyCode === 13) {
                            registrarIngreso();
                        }
                        event.preventDefault();
                    });
                }

                function registrarIngreso() {
                    if ($("#cbComprobante").val() == '') {
                        tools.AlertWarning("Cobros", "Seleccione un comprobante para continuar.");
                    } else if (arrayIngresos.length == 0) {
                        tools.AlertWarning("Cobros", "No hay conceptos para continuar.");
                    } else if (idDNI == 0 && $("#cbEmpresa").val() == "") {
                        tools.AlertWarning("Cobros", "No selecciono ningún ingeneniero o Empresa para continuar.");
                    } else if (UsarRuc && $("#cbEmpresa").val() == '') {
                        tools.AlertWarning("Cobros", "El comprobante requiere usar una empresa asociada.");
                        $("#cbEmpresa").focus();
                    } else {
                        tools.ModalDialog("Cobros", "¿Está seguro de continuar?", function(value) {
                            if (value == true) {
                                let cipupdate = cip;
                                $.ajax({
                                    url: "../app/controller/RegistrarIngresoController.php",
                                    method: "POST",
                                    accepts: "application/json",
                                    contentType: "application/json",
                                    data: JSON.stringify({
                                        "idTipoDocumento": parseInt($("#cbComprobante").val()),
                                        "idCliente": idDNI == 0 ? 0 : idDNI,
                                        "idEmpresaPersona": $("#cbEmpresa").val() == '' ? null : $("#cbEmpresa").val(),
                                        "idUsuario": idUsuario,
                                        "estado": 'C',
                                        "estadoCuotas": cuotasEstate,
                                        "estadoColegiatura": colegiaturaEstado,
                                        "estadoCertificadoHabilidad": certificadoHabilidadEstado,
                                        "objectCertificadoHabilidad": certificadoHabilidad,
                                        "estadoCertificadoResidenciaObra": certificadoResidenciaObraEstado,
                                        "objectCertificadoResidenciaObra": certificadoResidenciaObra,
                                        "estadoCertificadoProyecto": certificadoProyectoEstado,
                                        "objectCertificadoProyecto": certificadoProyecto,
                                        "estadoPeritaje": peritajeEstado,
                                        "objectPeritaje": peritaje,
                                        "ingresos": arrayIngresos,
                                        "cuotasInicio": cuotasInicio,
                                        "cuotasFin": cuotasFin
                                    }),
                                    beforeSend: function() {
                                        cancelarIngreso();
                                        tools.ModalAlertInfo("Cobros", "Procesando petición..");
                                    },
                                    success: function(result) {
                                        if (result.estado === 1) {
                                            tools.ModalAlertSuccess("Cobros", result.mensaje);
                                            openPdfComprobante(result.idIngreso);
                                            $("#btnCertificado").attr('data-toggle', '');
                                            $("#btnCertificado").attr('aria-expanded', 'false');
                                            newEmpresa = 0;
                                            loadEmpresaPersona();
                                            loadComprobantes();
                                            if (result.estadoCuotas == true) {
                                                if (result.colegiado != null) {
                                                    EnviarHabilidad(result.colegiado.CIP, result.colegiado.Apellidos, result.colegiado.Nombres, result.colegiado.Condicion, result.colegiado.FechaColegiado, result.cuotasFin, result.colegiado.Especialidad, result.colegiado.Capitulo);
                                                }
                                            }
                                        } else {
                                            tools.ModalAlertWarning("Cobros", result.mensaje);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Cobros", "Se produjo un error: " + error.responseText);
                                    }
                                });
                            }
                        });
                    }
                }

                function EnviarHabilidad(cip, apellidos, nombres, condicion, colegiatura, ultimopago, especialidad, capitulo) {
                    $.ajax({
                        url: "http://cip-junin.org.pe/sistema/UpdateLastPago.php",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "cip": cip,
                            "apellidos": apellidos,
                            "nombres": nombres,
                            "condicion": condicion,
                            "colegiatura": colegiatura,
                            "ultimopago": ultimopago,
                            "sede": "JUNIN",
                            "especialidad": especialidad,
                            "capitulo": capitulo
                        },
                        beforeSend: function() {
                            tools.ModalAlertInfo("Cobros", "Actualizando su habilidad del Ingeniero...");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tools.ModalAlertSuccess("Cobros", result.mensaje);
                            } else {
                                tools.ModalAlertWarning("Cobros", result.mensaje);
                            }
                        },
                        error: function(error) {
                            tools.ModalAlertError("Cobros", "Error de conexión, actualize su habilidad desde el panel ingenieros/habilidad.");
                        }
                    });
                }

                function openPdfComprobante(idIngreso) {
                    window.open("../app/sunat/pdfingresos.php?idIngreso=" + idIngreso, "_blank");
                    // window.open("../app/sunat/pdfingresos.php?idIngreso=" + idIngreso, "_blank");
                }

                function openPdfCertHabilidad() {
                    window.open("../app/sunat/certHabilidad.php", "_blank");
                }

                function addIngresos() {
                    $("#tbIngresos").empty();
                    sumaTotal = 0;
                    let arrayRenderTable = [];

                    for (let value of arrayIngresos) {
                        let cuotasFechas = cuotasEstate == true ? tools.getDateForma(cuotasInicio) + " al " + tools.getDateForma(cuotasFin) : '-';

                        if (!arrayRenderTable.find(ar => ar.categoria == value.categoria && value.categoria == 1 ||
                                ar.categoria == value.categoria && value.categoria == 2 ||
                                ar.categoria == value.categoria && value.categoria == 3 ||
                                ar.categoria == value.categoria && value.categoria == 4 ||
                                ar.categoria == value.categoria && value.categoria == 9 ||
                                ar.categoria == value.categoria && value.categoria == 10 ||
                                ar.categoria == value.categoria && value.categoria == 11 ||
                                ar.categoria == value.categoria && value.categoria == 12
                            )) {

                            arrayRenderTable.push({
                                "idConcepto": parseInt(value.idConcepto),
                                "categoria": value.categoria,
                                "cantidad": value.cantidad,
                                "concepto": value.categoria == 1 ? "Cuotas Ordinarias(Del " + cuotasFechas + ")" : value.categoria == 2 ? "Cuotas de Administia(Del " + cuotasFechas + ")" : value.categoria == 3 ? "Cuotas de Vitalicio(Del " + cuotasFechas + ")" : value.categoria == 12 ? "Cuota Ordinarias - Resolución 15 (Del " + cuotasFechas + ")" : value.categoria == 4 ? "Colegiatura Ordinaria" : value.categoria == 9 ? "Colegiatura Otras Modalidades" : value.categoria == 10 ? "Colegiatura por Tesis Local" : value.categoria == 11 ? "Colegiatura por Tesis Externa" : value.concepto,
                                "precio": parseFloat(value.precio),
                                "monto": parseFloat(value.monto)
                                // "monto": parseFloat(value.precio) * parseFloat(value.cantidad)
                            });
                        } else {
                            for (let i = 0; i < arrayRenderTable.length; i++) {
                                if (arrayRenderTable[i].categoria == value.categoria) {
                                    let newConcepto = arrayRenderTable[i];
                                    newConcepto.idConcepto = parseInt(value.idConcepto);
                                    newConcepto.categoria = parseInt(value.categoria);
                                    newConcepto.cantidad = newConcepto.cantidad;

                                    newConcepto.concepto =
                                        value.categoria == 1 ? "Cuotas Ordinarias(Del " + cuotasFechas + ")" :
                                        value.categoria == 2 ? "Cuotas de Administia(Del " + cuotasFechas + ")" :
                                        value.categoria == 3 ? "Cuotas de Vitalicio(Del " + cuotasFechas + ")" :
                                        value.categoria == 12 ? "Cuota Ordinarias - Resolución 15 (Del " + cuotasFechas + ")" :
                                        value.categoria == 4 ? "Colegiatura Ordinaria" :
                                        value.categoria == 9 ? "Colegiatura Otras Modalidades" :
                                        value.categoria == 10 ? "Colegiatura por Tesis Local" :
                                        value.categoria == 11 ? "Colegiatura por Tesis Externa" :
                                        value.concepto;

                                    newConcepto.precio += parseFloat(value.precio);
                                    newConcepto.monto += value.monto;
                                    // newConcepto.monto = newConcepto.precio * newConcepto.cantidad;
                                    arrayRenderTable[i] = newConcepto;
                                }
                            }
                        }
                    }

                    let count = 0;
                    for (let value of arrayRenderTable) {
                        count++;
                        $("#tbIngresos").append('<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + value.cantidad + '</td>' +
                            '<td>' + value.concepto + '</td>' +
                            // '<td>' + tools.formatMoney(value.precio) + '</td>' +
                            '<td>' + tools.formatMoney(value.monto) + '</td>' +
                            '<td><button class="btn btn-warning" onClick="removeIngresos(\'' + value.idConcepto + '\',\'' + value.categoria + '\')"><i class="fa fa-trash"></i></button></td>' +
                            '</tr>');
                        sumaTotal += parseFloat(value.monto);
                    }

                    $("#lblSumaTotal").html(tools.formatMoney(sumaTotal));
                }

                function removeIngresos(idConcepto, categoria) {
                    for (let i = 0; i < arrayIngresos.length; i++) {
                        if (arrayIngresos[i].categoria == 100) {
                            if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                break;
                            }
                        } else if (arrayIngresos[i].categoria == 5) {
                            if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                certificadoHabilidadEstado = false;
                                break;
                            }
                        } else if (arrayIngresos[i].categoria == 6) {
                            if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                certificadoResidenciaObraEstado = false;
                                break;
                            }
                        } else if (arrayIngresos[i].categoria == 7) {
                            if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                certificadoProyectoEstado = false;
                                break;
                            }
                        } else if (arrayIngresos[i].categoria == 8) {
                            if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                peritajeEstado = false;
                                break;
                            }
                        } else {
                            if (arrayIngresos[i].categoria == categoria && categoria == 1) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                cuotasEstate = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 2) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                cuotasEstate = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 3) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                cuotasEstate = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 4) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                colegiaturaEstado = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 9) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                colegiaturaEstado = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 10) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                colegiaturaEstado = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 11) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                colegiaturaEstado = false;
                            } else if (arrayIngresos[i].categoria == categoria && categoria == 12) {
                                arrayIngresos.splice(i, 1);
                                i--;
                                cuotasEstate = false;
                            }
                        }
                    }
                    addIngresos();
                }

                function cancelarIngreso() {
                    arrayIngresos.splice(0, arrayIngresos.length);
                    addIngresos();

                    $("#lblCipSeleccionado").html("--");
                    $("#lblTipoIngenieroSeleccionado").html("--");
                    $("#lblDocumentSeleccionado").html("--");
                    $("#lblEmpresaAFacturar").html("--");
                    $("#lblDatosSeleccionado").html("--");
                    // $("#lblDireccionSeleccionado").html("--");
                    $("#lblUltimoPago").html("--");
                    $("#lblHabilHasta").html("--");
                    $("#lblFechaColegiatura").html("--");
                    $("#lblYears").html("0 años/0");
                    $("#lblProgress").removeClass();
                    $("#lblProgress").addClass("progress-bar");
                    $("#lblProgress").css("width", "0%");
                    $("#txtIngenieroCertificado").val("");
                    $("#txtIngenieroObra").val("");
                    $("#txtIngenieroProyecto").val("");
                    idDNI = 0;
                    cip = 0;
                    tipoColegiado = "";
                    cuotasEstate = false;
                    colegiaturaEstado = false;
                    certificadoHabilidadEstado = false;
                    certificadoResidenciaObraEstado = false;
                    certificadoProyectoEstado = false;
                    peritajeEstado = false;
                    certificadoHabilidad = {};
                    certificadoResidenciaObra = {};
                    certificadoProyecto = {};
                    peritajeEstado = {};
                    $("#btnCertificado").attr('aria-expanded', 'false');
                    $("#tbHistorial").empty();
                    UsarRuc = false;
                    for (let i = 0; i < comprobantes.length; i++) {
                        if (comprobantes[i].Predeterminado == "1") {
                            $("#cbComprobante").val(comprobantes[i].IdTipoComprobante)
                        }
                        if (comprobantes[i].UsarRuc == "1") {
                            UsarRuc = true;
                        } else {
                            UsarRuc = false;
                        }
                        break;
                    }
                }

                function validateDuplicate(idConcepto) {
                    let ret = false;
                    for (let i = 0; i < arrayIngresos.length; i++) {
                        if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                            ret = true;
                            break;
                        }
                    }
                    return ret;
                }

                function clearModalAddEmpresa() {
                    loadEmpresaPersona();
                    $("#NuevaEmpresaPersona").modal("hide");
                    $("#txtRuc").val("")
                    $("#NombreComercial").val("")
                    $("#DireccionEmpresa").val("")
                    $("#Tlf_Celular").val("")
                    $("#Pagina_web").val("")
                    $("#Email_Empresa").val("")
                }

                function crudEmpresa() {
                    if ($("#txtRuc").val().length != 11) {
                        $("#txtRuc").focus();
                        tools.AlertWarning("Empresa", "Ingrese un ruc válido")
                    } else if ($("#NombreComercial").val() == "") {
                        $("#NombreComercial").focus();
                        tools.AlertWarning("Empresa", "Ingrese la razón social")
                    } else {
                        tools.ModalDialog("Empresa", "¿Está seguro de continuar?", function(value) {
                            if (value == true) {
                                $.ajax({
                                    url: "../app/controller/EmpresaController.php",
                                    method: "POST",
                                    data: {
                                        "type": "addEmpresa",
                                        "idEmpresa": 0,
                                        "ruc": $("#txtRuc").val(),
                                        "nombre": $("#NombreComercial").val(),
                                        "direccion": $("#DireccionEmpresa").val(),
                                        "telefono": $("#Tlf_Celular").val(),
                                        "web": $("#Pagina_web").val(),
                                        "email": $("#Email_Empresa").val()
                                    },
                                    beforeSend: function() {
                                        tools.ModalAlertInfo("Empresa", "Procesando petición..");
                                    },
                                    success: function(result) {
                                        if (result.estado === 1) {
                                            console.log(result.data.id)
                                            tools.ModalAlertSuccess("Empresa", result.mensaje);
                                            clearModalAddEmpresa();
                                            newEmpresa = result.data.id;
                                            // $("#cbEmpresa").val(result.data.id)
                                        } else if (result.estado === 2) {
                                            tools.ModalAlertWarning("Empresa", result.mensaje);
                                        } else {
                                            tools.ModalAlertWarning("Empresa", result.mensaje);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Empresa", "Se produjo un error: " + error.responseText);
                                    }
                                });
                            }
                        });
                    }
                }


                function loadSunatApi(numero) {
                    $.ajax({
                        url: "https://dniruc.apisperu.com/api/v1/ruc/" + numero + "?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFsZXhhbmRlcl9keF8xMEBob3RtYWlsLmNvbSJ9.6TLycBwcRyW1d-f_hhCoWK1yOWG_HJvXo8b-EoS5MhE",
                        type: "get",
                        data: {},
                        beforeSend: function() {
                            $("#divLoad").addClass("overlay");
                            $("#divLoad").append('<i class="fa fa-refresh fa-spin"></i>');
                        },
                        success: function(result) {
                            $("#divLoad").removeClass("overlay");
                            $("#divLoad").empty();
                            $("#NombreComercial").val(result.razonSocial);
                            $("#DireccionEmpresa").val(result.direccion);
                        },
                        error: function(error) {
                            $("#divLoad").removeClass("overlay");
                            $("#divLoad").empty();
                        }
                    });
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
