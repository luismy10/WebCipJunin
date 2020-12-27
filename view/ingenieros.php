<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
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
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin">Ingenieros <small> Lista </small> </h3>
                </section>

                <!-- modal nuevo ingeniero  -->
                <div class="row">
                    <div class="modal fade" id="confirmar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseIngeniero">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-user-plus">
                                        </i> Registrar Ingeniero
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="dni" type="text" name="Dni" class="form-control" placeholder="DNI" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Nombres">Nombres: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="Nombres" type="text" name="Nombres" class="form-control" placeholder="Nombres" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Apellidos">Apellidos: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Genero">Genero: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="Genero" class="form-control">
                                                    <option value="M">Maculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Nacimiento">Nacimiento: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="Nacimiento" type="date" name="Nacimiento" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Estado_civil">Estado civil: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="Estado_civil" class="form-control">
                                                    <option value="S">Soltero/a</option>
                                                    <option value="C">Casado/a</option>
                                                    <option value="V">Viudo/a</option>
                                                    <option value="D">Divorciado/a</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Ruc">RUC (opcional):</label>
                                                <input id="Ruc" type="text" name="Ruc" class="form-control" placeholder="número de RUC" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Razon_social">Razon social (opcional):</label>
                                                <input id="Razon_social" type="text" name="Razon_social" class="form-control" placeholder="Razon social" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="Codigo">Codigo CIP: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="Codigo" type="number" name="Codigo" class="form-control" placeholder="Codigo" required="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Condición">Nuevo </label>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="cbTramite" checked> Tramite
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="Condición">Condición: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="Condicion" class="form-control">
                                                    <option value="O">ORDINARIO</option>
                                                    <option value="T">TRANSEUNTE</option>
                                                    <option value="F">FALLECIDO</option>
                                                    <option value="R">RETIRADO</option>
                                                    <option value="V">VITALICIO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-danger" id="btnAceptarIngeniero">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarIngeniero">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal new enginner -->

                <!-- modal historial de un ingeniero -->
                <div class="row">
                    <div class="modal fade" id="mostrarHistorial" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Historial de Pagos
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
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
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <input type="search" class="form-control" aria-describedby="search">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button id="btnBuscarIngeniero" class="btn btn-default">
                                                    <i class="fa fa-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Recibo</th>
                                                            <th>Fecha</th>
                                                            <th>Concepto</th>
                                                            <th>Monto</th>
                                                            <th>Observación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbHistorial">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal history enginner  -->

                <section class="content">

                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-danger" id="btnNuevoIngeniero">
                                    <i class="fa fa-plus"></i> Nuevo Ingeniero
                                </button>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-link" id="btnactualizar">
                                    <i class="fa fa-refresh"></i> Actualizar..
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombres o apellidos" aria-describedby="search" value="">
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-default">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: -5px;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                        <th style="text-align: center;">#</th>
                                        <th>Cip</th>
                                        <th>Dni</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>Sexo</th>
                                        <th>Estado Civil</th>
                                        <th>Condicion</th>
                                        <th>Colegiaturas</th>
                                        <th>Historial</th>
                                        <th>Opciones</th>
                                    </thead>
                                    <tbody id="tbTable">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                <ul class="pagination">
                                    <li>
                                        <button class="btn btn-primary" id="btnIzquierda">
                                            <i class="fa fa-toggle-left"></i>
                                        </button>
                                    </li>
                                    <li>
                                        <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                    </li>
                                    <li><span>a</span></li>
                                    <li>
                                        <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                    </li>
                                    <li>
                                        <button class="btn btn-primary" id="btnDerecha">
                                            <i class="fa fa-toggle-right"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- start footer -->
            <?php include('./layout/footer.php') ?>
            <!-- end footer -->
        </div>
        <!-- ./wrapper -->
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();

            let state = false;
            let opcion = 0;
            let totalPaginacion = 0;
            let paginacion = 0;
            let filasPorPagina = 10;
            let tbTable = $("#tbTable");

            let stateHistorial = false;
            let opcionHistorial = 0;
            let totalPaginacionHistorial = 0;
            let paginacionHistorial = 0;
            let filasPorPaginacionHistorial = 10;
            let tbHistorial = $("#tbHistorial");
            let dni = 0;

            $(document).ready(function() {

                loadInitVentas();

                $("#btnIzquierda").click(function() {
                    if (!state) {
                        if (paginacion > 1) {
                            paginacion--;
                            onEventPaginacion();
                        }
                    }
                });

                $("#btnDerecha").click(function() {
                    if (!state) {
                        if (paginacion < totalPaginacion) {
                            paginacion++;
                            onEventPaginacion();
                        }
                    }
                });

                $("#cbTramite").on("change", function() {
                    $("#Codigo").prop("disabled", this.checked);
                });

                $("#btnactualizar").click(function() {
                    loadInitVentas()
                });

                $("#buscar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        paginacion = 1;
                        loadTablePersonas($("#buscar").val());
                        opcion = 1;
                    }
                });

                $("#btnNuevoIngeniero").click(function() {
                    $("#confirmar").modal("show");
                });


                //-------------------------------------------------------------------------

                $("#btnCloseIngeniero").click(function() {
                    $("#confirmar").modal("hide")
                    clearModalIngeniero()
                });

                $("#btnCancelarIngeniero").click(function() {
                    $("#confirmar").modal("hide")
                    clearModalIngeniero()
                });

                $("#btnAceptarIngeniero").click(function() {
                    if ($("#dni").val() == '' || $("#dni").val().length < 8) {
                        tools.AlertWarning("Advertencia", "Ingrese un número de dni o ruc correcto por favor.");
                    } else if ($("#Nombres").val() == '' || $("#Nombres").val().length < 2) {
                        tools.AlertWarning("Advertencia", "Ingrese un nombre de 3 o mas letras por favor.");
                    } else if ($("#Apellidos").val() == '' || $("#Apellidos").val().length < 2) {
                        tools.AlertWarning("Advertencia", "Ingrese un apellido de 3 o mas letras por favor.");
                    } else if ($("#Nacimiento").val() == '') {
                        tools.AlertWarning("Advertencia", "Ingrese un fecha de nacimiento por favor.");
                    } else if (!$('#cbTramite').is(":checked") && $("#Codigo").val() == '' || !$('#cbTramite').is(":checked") && $("#Codigo").val().length < 4) {
                        tools.AlertWarning("Advertencia", "Ingrese el número cip por favor.");
                    } else {
                        insertPersona($("#dni").val(), $("#Nombres").val(), $("#Apellidos").val(), $("#Genero").val(),
                            $("#Nacimiento").val(), $("#Estado_civil").val(), $("#Ruc").val(), $("#Razon_social").val(),
                            $("#Codigo").val(), $("#Condicion").val());
                    }
                });

                //-------------------------------------------------------------------------
                $("#btnIzquierdaHistorial").click(function() {
                    if (!stateHistorial) {
                        if (paginacionHistorial > 1) {
                            paginacionHistorial--;
                            onEventPaginacionHistorial();
                        }
                    }
                });

                $("#btnDerechaHistorial").click(function() {
                    if (!stateHistorial) {
                        if (paginacionHistorial < totalPaginacionHistorial) {
                            paginacionHistorial++;
                            onEventPaginacionHistorial();
                        }
                    }
                });

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTablePersonas("");
                        break;
                    case 1:
                        loadTablePersonas($("#buscar").val());
                        break;
                }
            }

            function loadInitVentas() {
                if (!state) {
                    paginacion = 1;
                    loadTablePersonas("");
                    opcion = 0;
                }
            }

            function loadTablePersonas(nombres) {
                $.ajax({
                    url: "../app/controller/PersonaController.php",
                    method: "GET",
                    data: {
                        "type": "alldata",
                        "nombres": nombres,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                        );
                        state = true;
                    },
                    success: function(result) {

                        if (result.estado === 1) {
                            tbTable.empty();
                            for (let persona of result.personas) {
                                // let image = '<img src="images/masculino.png" width="30">';
                                let btnHistorial = '<button class="btn btn-info btn-sm" onclick="onSelectedIngeniero(\'' + persona.idDNI + '\')">' +
                                    '<i class="fa fa-eye"></i> Ver' +
                                    '</button>';

                                let btnUpdate =
                                    '<button class="btn btn-warning btn-sm" onclick="loadUpdateIngenieros(\'' +
                                    persona.idDNI + '\')">' +
                                    '<i class="fa fa-wrench"></i> Editar' +
                                    '</button>';

                                let estadoCivil = (persona.EstadoCivil == 'S') ? 'Soltero/a' :
                                    (persona.EstadoCivil == 'C') ? 'Casado/a' :
                                    (persona.EstadoCivil == 'V') ? 'Viudo/a' : 'Divorciado/a'

                                let condicion = (persona.Condicion == 'O') ? 'Ordinario' :
                                    (persona.Condicion == 'T') ? 'Transeunte' :
                                    (persona.Condicion == 'F') ? 'Fallecido' :
                                    (persona.Condicion == 'R') ? 'Retirado' : 'Vitalicio'

                                tbTable.append('<tr>' +
                                    '<td style="text-align: center;color: #2270D1;">' + persona.Id + '</td>' +
                                    '<td>' + persona.Cip + '</td>' +
                                    '<td>' + persona.idDNI + '</td>' +
                                    '<td>' + persona.Apellidos + ' ' + persona.Nombres + '</td>' +
                                    '<td>' + persona.Sexo + '</td>' +
                                    '<td>' + estadoCivil + '</td>' +
                                    '<td>' + condicion + '</td>' +
                                    '<td>' + 0 + '</td>' +
                                    '<td>' + btnHistorial + '</td>' +
                                    '<td>' +
                                    '' + btnUpdate + '' +
                                    '</td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                filasPorPagina))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>' + result.message + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="9"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function loadUpdateIngenieros(idPersona) {
                location.href = "update_ingenieros.php?idPersona=" + idPersona;
            }

            function insertPersona(idPersona, nombres, apellidos, sexo, nacimiento, estado_civil, ruc, rason_social, cip,
                condicion) {
                tools.ModalDialog("Ingeniero", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/PersonaController.php",
                            method: "POST",
                            data: {
                                "type": "create",
                                "dni": idPersona,
                                "nombres": nombres.toUpperCase(),
                                "apellidos": apellidos.toUpperCase(),
                                "sexo": sexo,
                                "nacimiento": nacimiento,
                                "estado_civil": estado_civil,
                                "ruc": ruc,
                                "rason_social": rason_social,
                                "cip": cip,
                                "condicion": condicion,
                            },
                            beforeSend: function() {
                                $("#confirmar").modal("hide")
                                clearModalIngeniero();
                                tools.ModalAlertInfo("Ingeniero", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Ingeniero", result.message);
                                } else if (result.estado == 3) {
                                    tools.ModalAlertWarning("Ingeniero", result.message);
                                } else {
                                    tools.ModalAlertWarning("Ingeniero", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Ingeniero", "Se produjo un error: " + error.responseText);
                            }
                        });
                    }
                });
            }

            function onEventPaginacionHistorial() {
                switch (opcionHistorial) {
                    case 0:
                        loadTableHistorial(dni);
                        break;
                }
            }

            function loadTableHistorial(dni) {
                $.ajax({
                    url: "../app/controller/PersonaController.php",
                    method: "GET",
                    data: {
                        "type": "historialpago",
                        "dni": dni,
                        "posicionPagina": ((paginacionHistorial - 1) * filasPorPaginacionHistorial),
                        "filasPorPagina": filasPorPaginacionHistorial
                    },
                    beforeSend: function() {
                        tbHistorial.empty()
                        tbHistorial.append('<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');
                        stateHistorial = true;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbHistorial.empty()
                            if (result.historial.length == 0) {
                                tbHistorial.append('<tr class="text-center"><td colspan="6"><p>No hay datos para mostrar.</p></td></tr>');
                                totalPaginacionHistorial = 0;
                                $("#lblPaginaActual").html(paginacionHistorial);
                                $("#lblPaginaSiguiente").html(totalPaginacionHistorial);
                                stateHistorial = false;
                            } else {
                                for (let historial of result.historial) {

                                    let Concepto;
                                    if (historial.Concepto == 1) {
                                        Concepto = "Cuota Ordinaria";
                                    } else if (historial.Concepto == 2) {
                                        Concepto = "Cuota Ordinaria (Amnistia)";
                                    } else if (historial.Concepto == 3) {
                                        Concepto = "Cuota Ordinaria (Vitalicio)";
                                    } else if (historial.Concepto == 4) {
                                        Concepto = "Colegiatura";
                                    } else if (historial.Concepto == 5) {
                                        Concepto = "Certificado de habilidad";
                                    } else if (historial.Concepto == 6) {
                                        Concepto = "Cuota de residencia de obra";
                                    } else if (historial.Concepto == 7) {
                                        Concepto = "Certificado de proyecto";
                                    } else if (historial.Concepto == 8) {
                                        Concepto = "Peritaje";
                                    } else if (historial.Concepto == 100) {
                                        Concepto = "Ingresos Diversos";
                                    }

                                    tbHistorial.append('<tr>' +
                                        '<td>' + historial.Id + '</td>' +
                                        '<td>' + historial.Recibo + '</td>' +
                                        '<td>' + tools.getDateForma(historial.Fecha) + '<br>' + tools.getTimeForma(historial.Hora, true) + '</td>' +
                                        '<td>' + Concepto + '</td>' +
                                        '<td>' + tools.formatMoney(historial.Monto) + '</td>' +
                                        '<td>' + historial.Observacion + '</td>' +
                                        '</tr>');
                                }

                                totalPaginacionHistorial = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPaginacionHistorial))));
                                $("#lblPaginaActualHistorial").html(paginacionHistorial);
                                $("#lblPaginSiguienteHistorial").html(totalPaginacionHistorial);
                                stateHistorial = false;
                            }
                        } else {

                            tbHistorial.empty()
                            tbHistorial.append('<tr class="text-center"><td colspan="6"><p>' + result.message + '</p></td></tr>');
                            stateHistorial = false;
                        }
                    },
                    error: function(error) {
                        tbHistorial.empty()
                        tbHistorial.append('<tr class="text-center"><td colspan="6"><p>' + error.responseText + '</p></td></tr>');
                        stateHistorial = false;
                    }
                });
            }

            function onSelectedIngeniero(idIngeniero) {
                $("#mostrarHistorial").modal("show");
                dni = idIngeniero;
                if (!stateHistorial) {
                    paginacionHistorial = 1;
                    loadTableHistorial(dni);
                    opcionHistorial = 0;
                }
            }

            function clearModalIngeniero() {
                $("#dni").val("")
                $("#Nombres").val("")
                $("#Apellidos").val("")
                $("#Genero").val("M")
                $("#Nacimiento").val("")
                $("#Estado_civil").val("S")
                $("#Ruc").val("")
                $("#Razon_social").val("")
                $("#Codigo").val("")
                $("#cbTramite").attr("checked", true);
                $("#Codigo").prop("disabled", $("#cbTramite").is(":checked"));
                $("#Condicion").val("O")
            }
        </script>
    </body>

    </html>
<?php }
