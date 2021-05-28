<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

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
            <!-- modal detalle del ingreso -->
            <div class="row">
                <div class="modal fade" id="mostrarDetalleIngreso" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-group">
                                    </i> Detalle del Ingreso
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th width="50%">Concepto</th>
                                                        <th width="15%">Precio</th>
                                                        <th width="15%">Cantidad</th>
                                                        <th width="15%">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbDetalleIngreso">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal history enginner  -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin"> Comprobantes(Boletas, Facturas) <small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/sunat_logo.png" width="28" /> Estados SUNAT:</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/accept.svg" width="28" /> Aceptado</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/unable.svg" width="28" /> Rechazado</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/reuse.svg" width="28" /> Pendiente de Envío</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/error.svg" width="28" /> Comunicación de Baja (Anulado)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Fecha de inicio:</label>
                                <input type="date" class="form-control pull-right" id="fechaInicio">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Fecha de fin:</label>
                                <input type="date" class="form-control pull-right" id="fechaFinal">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Opción</label>
                                <div class="input-group">
                                    <button class="btn btn-primary" id="btnEnvioMasivo"><i class="fa fa-gg-circle"></i> Envío masivo a sunat</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Generar excel</label>
                                <div class="input-group">
                                    <button class="btn btn-success" id="btnExcel"><i class="fa fa-file-excel-o"></i> Excel por fechas</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Filtrar por serie, numeración o cliente(Presione Enter)</label>
                                <div class="input-group">
                                    <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary" id="btnRecargar">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Comprobantes</label>
                                <select class="form-control" id="cbComprobantes">
                                    <option value="">- Seleccione -</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                        <th style="width:5%;">#</th>
                                        <th style="width:10%;">Opciones</th>
                                        <th style="width:10%;">Fecha</th>
                                        <th style="width:10%;">Comprobante</th>
                                        <th style="width:15%;">Cliente</th>
                                        <th style="width:10%;">Estado</th>
                                        <th style="width:10%;">Total</th>
                                        <th style="width:10%;">Estado Sunat</th>
                                        <th style="width:20%;">Observaciones Sunat</th>
                                    </thead>
                                    <tbody id="tbTable">

                                    </tbody>

                                </table>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
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

            let arrayIngresos = [];

            $(document).ready(function() {

                $("#fechaInicio").val(tools.getCurrentDate());

                $("#fechaFinal").val(tools.getCurrentDate());

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

                $("#btnEnvioMasivo").click(function() {
                    tools.ModalDialog("Ingreso", "Está seguro de continuar con el envío?", function(value) {
                        if (value == true) {
                            for (let ingresos of arrayIngresos) {
                                if (ingresos.estado == "C") {
                                    if (ingresos.xmlsunat !== "0") {
                                        firmaMasivaXml(ingresos.idIngreso);
                                    }
                                }
                            }
                        }
                    });
                });

                $("#btnEnvioMasivo").keypress(function(event) {
                    if (event.keyCode === 13) {
                        tools.ModalDialog("Ingreso", "Está seguro de continuar con el envío?", function(value) {
                            if (value == true) {
                                for (let ingresos of arrayIngresos) {
                                    if (ingresos.estado == "C") {
                                        if (ingresos.xmlsunat !== "0") {
                                            firmaMasivaXml(ingresos.idIngreso);
                                        }
                                    }
                                }
                            }
                        });
                    }
                    event.preventDefault();
                });

                $("#btnExcel").click(function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            openExcel($("#fechaInicio").val(), $("#fechaFinal").val());
                        }
                    }
                });

                $("#fechaInicio").on("change", function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0);
                            opcion = 0;
                        }
                    }
                });

                $("#fechaFinal").on("change", function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0);
                            opcion = 0;
                        }
                    }
                });

                $("#buscar").keyup(function(event) {
                    if (event.keyCode == 13) {
                        if ($("#buscar").val().trim() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(1, $("#buscar").val().trim(), "", "", 0);
                                opcion = 1;
                            }
                        }
                    }
                });

                $("#btnRecargar").click(function() {
                    loadInitIngresos();
                });

                $("#btnRecargar").keypress(function(event) {
                    if (event.keyCode === 13) {
                        loadInitIngresos();
                    }
                    event.preventDefault();
                });

                $("#cbComprobantes").change(function() {
                    if ($("#cbComprobantes").val() != '') {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(2, "", "", "", $("#cbComprobantes").val());
                            opcion = 2;
                        }
                    }
                });

                loadComprobantes();
                loadInitIngresos();

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0);
                        break;
                    case 1:
                        loadTableIngresos(1, $("#buscar").val().trim(), "", "", 0);
                        break;
                    case 2:
                        loadTableIngresos(2, "", "", "", $("#cbComprobantes").val());
                        break;
                }
            }

            function loadInitIngresos() {
                if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                    if (!state) {
                        paginacion = 1;
                        loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0);
                        opcion = 0;
                    }
                }
            }

            function loadTableIngresos(opcion, buscar, fechaInicio, fechaFinal, comprobante) {
                $.ajax({
                    url: "../app/controller/ListarIngresos.php",
                    method: "GET",
                    data: {
                        "type": "allIngresos",
                        "opcion": opcion,
                        "buscar": buscar,
                        "fechaInicio": fechaInicio,
                        "fechaFinal": fechaFinal,
                        "comprobante": comprobante,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        arrayIngresos = [];
                        state = true;
                    },
                    success: function(result) {

                        if (result.estado == 1) {
                            arrayIngresos = result.data;
                            if (arrayIngresos.length == 0) {
                                tbTable.empty();
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="9"><p>No hay ingresos para mostrar.</p></td></tr>'
                                );
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html("0");
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            } else {
                                tbTable.empty();
                                for (let ingresos of arrayIngresos) {

                                    let btnAnular = '<button class="btn btn-danger btn-xs" onclick="anularIngreso(\'' + ingresos.idIngreso + '\')">' +
                                        '<i class="fa fa-ban"></i></br>Anular' +
                                        '</button>';
                                    let btnPdf = '<button class="btn btn-default btn-xs" onclick="openPdf(\'' + ingresos.idIngreso + '\')">' +
                                        '<i class="fa fa-file-pdf-o"></i></br>P.D.F' +
                                        '</button>';
                                    let btnDetalle = '<button class="btn btn-warning btn-xs" onclick="openDetalle(\'' + ingresos.idIngreso + '\')">' +
                                        '<i class="fa fa-eye"></i></br>Detalle' +
                                        '</button>';

                                    let estadosunat = ingresos.estado === "C" ?
                                        (ingresos.xmlsunat === "" ?
                                            '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + ingresos.idIngreso + '\',\'' + ingresos.estado + '\')"><img src="./images/reuse.svg" width="30" /></button>' :
                                            ingresos.xmlsunat === "0" ?
                                            '<button class="btn btn-default btn-xs"><img src="./images/accept.svg" width="30"/></button>' :
                                            '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + ingresos.idIngreso + '\',\'' + ingresos.estado + '\')"><img src="./images/unable.svg" width="30"/></button>') :
                                        (ingresos.xmlsunat === "" ?
                                            '<button class="btn btn-default btn-xs" onclick="resumenDiarioXml(\'' + ingresos.idIngreso + '\',\'' + ingresos.serie + "-" + ingresos.numRecibo + '\',\'' + tools.getDateYYMMDD(ingresos.fecha) + '\')"><img src="./images/reuse.svg" width="30" /></button>' :
                                            '<button class="btn btn-default btn-xs"><img src="./images/error.svg" width="30"/></button>');

                                    let observacionsunat =
                                        (ingresos.xmldescripcion === "" ? "Por Generar Xml y Enviar" : ingresos.xmldescripcion);

                                    tbTable.append('<tr>' +
                                        '<td style="text-align: center;color: #2270D1;">' +
                                        '' + ingresos.id + '' +
                                        '</td>' +
                                        '<td>' + btnPdf + ' ' + btnDetalle + '</td>' +
                                        '<td>' + ingresos.fecha + '<br>' + tools.getTimeForma(ingresos.hora, true) + '</td>' +
                                        '<td>' + ingresos.serie + '-' + ingresos.numRecibo + '</td>' +
                                        '<td>' + ingresos.idDNI + '</br>' + ingresos.nombres + ' ' + ingresos.apellidos + '</td>' +
                                        '<td>' + (ingresos.estado == "C" ? '<span class="text-green">Pagado</span>' : '<span class="text-red">Anulado</span>') + '</td>' +
                                        '<td>' + tools.formatMoney(ingresos.total) + '</td>' +
                                        '<td style="text-align: center;">' + estadosunat + '</td>' +
                                        '<td>' + observacionsunat + '</td>' +
                                        '</tr>'
                                    );
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            }
                        } else {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>' + result.mensaje + '</p></td></tr>'
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

            function facturarXml(idIngreso, estado) {
                tools.ModalDialog("Ingreso", "¿Está seguro de continuar con el envío?", function(value) {
                    if (value == true) {
                        if (estado === "C") {
                            $.ajax({
                                url: "../app/examples/boleta.php",
                                method: "GET",
                                data: {
                                    "idIngreso": idIngreso
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Ventas", "Firmando xml y enviando a la sunat.");
                                },
                                success: function(result) {
                                    let object = result;
                                    if (object.state === true) {
                                        if (object.accept === true) {
                                            tools.ModalAlertSuccess("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                        } else {
                                            tools.ModalAlertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                        }
                                    } else {
                                        tools.ModalAlertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Ventas", "Error en el momento de firmar el xml: " + error.responseText);
                                }
                            });
                        }
                    }
                });
            }

            function resumenDiarioXml(idIngreso, comprobante, resumen) {
                tools.ModalDialog("¿Realmente Deseas Anular el Documento?", "Se anulará el documento: " + comprobante + ", y se creará el siguiente resumen individual: RC-" + resumen + "-1, estás seguro de anular el documento? los cambios no se podrán revertir!", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "./examples/resumen.php",
                            method: "GET",
                            data: {
                                "idIngreso": idIngreso
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Ventas", "Firmando xml y enviando a la sunat.");
                            },
                            success: function(result) {
                                let object = result;
                                if (object.state === true) {
                                    if (object.accept === true) {
                                        tools.ModalAlertSuccess("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                    } else {
                                        tools.ModalAlertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                    }
                                } else {
                                    tools.ModalAlertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Ventas", "Error en el momento de firmar el xml: " + error.responseText);
                            }
                        });

                    }
                });
            }

            function firmaMasivaXml(idIngreso) {
                $.ajax({
                    url: "../app/examples/boleta.php",
                    method: "GET",
                    data: {
                        "idIngreso": idIngreso
                    },
                    beforeSend: function() {
                        tools.ModalAlertInfo("Ventas", "Firmando xml y enviando a la sunat.");
                    },
                    success: function(result) {
                        let object = result;
                        if (object.state === true) {
                            if (object.accept === true) {
                                tools.ModalAlertSuccess("Ventas", "Resultado: Código " + object.code + " " + object.description);
                            } else {
                                tools.ModalAlertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                            }
                        } else {
                            tools.ModalAlertWarning("Ventas", "Resultado: Código " + object.code + " " + object.description);
                        }
                    },
                    error: function(error) {
                        tools.ModalAlertError("Ventas", "Error en el momento de firmar el xml: " + error.responseText);
                    }
                });
            }

            function loadComprobantes() {
                $.ajax({
                    url: "../app/controller/ComprobanteController.php",
                    method: "GET",
                    data: {
                        "type": "comprobante"
                    },
                    beforeSend: function() {
                        $("#cbComprobantes").empty();
                        $("#cbComprobantes").append('<option value="">- Seleccione -</option>');
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            for (let value of result.data) {
                                $("#cbComprobantes").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>');
                            }
                        }
                    },
                    error: function(error) {

                    }
                });
            }

            function openExcel(fechaInicio, fechaFinal) {
                window.open("../app/sunat/excelventa.php?opcion=0&txtFechaInicial=" + fechaInicio + "&txtFechaFinal=" + fechaFinal + "&comprobante=0", "_blank");
            }

            function openPdf(idIngreso) {
                window.open("../app/sunat/pdfingresos.php?idIngreso=" + idIngreso, "_blank");
            }

            function openDetalle(idIngreso) {
                $("#mostrarDetalleIngreso").modal("show");
                $.ajax({
                    url: "../app/controller/IngresoController.php",
                    method: "GET",
                    data: {
                        "type": "detalleingreso",
                        "idIngreso": idIngreso,
                    },
                    beforeSend: function() {
                        $("#tbDetalleIngreso").empty();
                        $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');

                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#tbDetalleIngreso").empty();
                            if (result.detalles.length == 0) {
                                $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>No hay datos para Mostrar</p></td></tr>');
                            } else {
                                for (let detalle of result.detalles) {
                                    $("#tbDetalleIngreso").append('<tr>' +
                                        '<td>' + detalle.Id + '</td>' +
                                        '<td>' + detalle.Concepto + '</td>' +
                                        '<td>' + tools.formatMoney(detalle.Precio) + '</td>' +
                                        '<td>' + tools.formatMoney(detalle.Cantidad) + '</td>' +
                                        '<td>' + tools.formatMoney(detalle.Total) + '</td>' +
                                        '</tr>');
                                }
                            }
                        } else {
                            $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>' + result.message + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>' + error.responseText + '</p></td></tr>');

                    }
                });
            }

            function anularIngreso(idIngreso) {
                tools.ModalDialogInputText("Ingreso", "¿Está seguro de anular el comprobante?", function(value) {
                    if (value.dismiss == "cancel") {} else if (value.value.length == 0) {
                        tools.ModalAlertWarning("Ingreso", "No ingreso ningún motivo :(");
                    } else {
                        $.ajax({
                            url: "../app/controller/IngresoController.php",
                            method: 'POST',
                            data: {
                                "type": "deleteIngreso",
                                "idIngreso": idIngreso,
                                "idUsuario": 1,
                                "motivo": value.value.toUpperCase(),
                                "fecha": tools.getCurrentDate(),
                                "hora": tools.getCurrentTime()
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Ingreso", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Ingreso", result.message);
                                    loadInitIngresos();
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning("Ingreso", result.message);
                                } else {
                                    tools.ModalAlertWarning("Ingreso", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Ingreso", "Se produjo un error: " + error.responseText);
                            }
                        });
                    }
                });
            }
        </script>
    </body>

    </html>

<?php }