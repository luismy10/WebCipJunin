<?php

    define('_MPDF_PATH', '/lib');
    require('./lib/mpdf/vendor/autoload.php');

    $Nombreingeniero = '';
        $Apellidosingeniero = '';
        $ConsejoDepartamental = 'JUNIN';
        $NumeroCIP = '';
        
        $FechaIncorporacion = '';
        $DiaIncorporacion = '';
        $MesIncorporacion = '';
        $AnioIncorporacion = '';

        $Especialidad = '';
        $Modalidad = '';
        $Proyecto = '';
        $Propietario = '';
        $Monto = '';
        $MontoenLetras = 'CINCUENTA NUEVOS SOLES CON 00 SOLES';
        $Departamento = '';
        $Provincia = '';
        $Distrito = '';
        $UrbAahhPpjjAsoc = '';
        $JrAvCallePasaje = '';

        $FechaVencimiento = '';
        $DiaVencimiento = '';
        $MesVencimiento = '';
        $AnioVencimiento = '';

        $LugarRegistro = 'Huancayo'; //modificar****************************************************

        $FechaRegistro = '';
        $DiaRegistro = '';
        $Mes = '';
        

 
        $html .= '<html>
            <head>
                <style>
                    body {
                        font-family: Comic Sans;
                        font-size: 9pt;
                        color:#44413f;
                        background: #fcfdf8;
                    }
                    #headerCert{
                        height: 20%;
                        width: 100%;
                        background-image: url("cabeceraCertificado.png") no-repeat fixed center;
                        background-size: cover;
                    }
                    #bodyCert{
                        height: 73.3%;
                        width: 100%;
                        background-image: url("fondoCertificados.png") no-repeat fixed center;
                        background-size: cover;
                        font-size:9.5pt;
                        background-repeat: no-repeat;
                    }
                    
                </style>
            </head>
            <body>
                <!--############################################## cabecera ###############################################################################-->
                <div id="headerCert">
                    <div style="width:100%; height:7.5%;text-align: left;">
                        <div style="width:22%; height:7.5%;; float:left; text-align:center;">                          
                             <img src="logoCipJunin.png" alt="" width="70px"; height="70px" style="padding-top:10px;">                                                  
                        </div>
                        <div style="width:55%; height:7.5%; float:left">
                            <div style="color: #c55f52; text-decoration: underline; font-size:14px; font-weight:bold; width:100%; text-align:center; padding-top:20px;">
                                COLEGIO DE INGENIEROS DEL PERÚ
                            </div>
                            <div style="color: #c55f52; font-size:17px; font-weight:bold; width:100%; text-align:center; padding-top:5px;">
                                Certificado De Habilidad
                            </div>
                        </div>
                        <div style="width:20%; height:7.5%; float:left">
                            <img src="codigoBarras.png" alt="" width="114px"; height="59px" style="padding-top:30px; padding-left:20px;">
                        </div>
                    </div>
                    <div style="width:100%; padding-left: 42px;" face:"georgia";>
                        El ingeniero (a):___________________________________________________________________________________________________________________
                    </div>
                    <div style="width:100%; padding-left: 42px; padding-top: 5px;">
                        Adscrito al Consejo Departamental de:___________________________________________Registro CIP N°:________________________________
                    </div>
                    <div style="width:100%; padding-left: 42px; padding-top: 5px;">
                        Fecha de Incorporación:__________________________Especialidad:___________________________________________________________________
                    </div>
                    <div style="width:100%; padding-left: 42px; padding-top: 8px;">
                        EL INGENIERO SE ENCUENTRA COLEGIADO Y HÁBIL, para el siguiente detalle:
                    </div>
                    <div style="width:100%; padding-left: 25px; padding-top: 8px;">
                        <div style="width:12%; font-weight:bold; float:left; text-align:center;padding-top:5px; font-size:8pt;">ASUNTO</div>
                        <div style="width:83%; border:1px solid black; float:left; height:25px;"></div>
                    </div>
                    <div style="width:74%; padding-left: 25px; padding-top: 3px; float:left;">
                        <div style="width:100%;">
                            <div style="width:15.5%; font-weight:bold; float:left; text-align:center; font-size:8pt;">ENTIDAD O <br> PROPIETARIO</div>
                            <div style="width:83.5%; border:1px solid black; float:left; height:25px;"></div>
                        </div>
                        <div style="width:100%; padding-top: 0px;">
                            <div style="width:15.5%; font-weight:bold; float:left; text-align:center; font-size:8pt; padding-top:5px">LUGAR </div>
                            <div style="width:83.5%; border:1px solid black; float:left; height:25px;"></div>
                        </div>
                    </div>
                    <div style="width:20%; float:left;">
                        <table style="width:90%; border-collapse: collapse; margin-top:3px;">
                            <tr>
                                <th colspan="3" style="color:white; border:1px solid #c55f52; background:#c55f52; width:60px; height: 25px; font-size:9px; margin-left:0">El presente documento tiene <br>vigencia hasta</th>      
                            </tr>
                            <tr>
                                <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Día</td>
                                <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Mes</td>
                                <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">AÑO</td>
                            </tr>
                            <tr>
                                <td style="width:20px; height:22px; text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;">06</td>
                                <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;">07</td>
                                <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;">2021</td>
                            </tr>
                        </table>
                    </div>
                    <div style="width:100%; height:20px; padding-left: 42px; padding-top: 5px;">
                        <div style="float:left; width:40%; height:20px; padding-left: 2px;">

                        </div>
                        <div style="float:left; width:55%; height:20px; margin-top: 3px; text-align:right;">
                                ___________________, de_________ del 20_____
                        </div>
                    </div>
                </div>
                <!--############################################### Fin de la cabecera #############################################################-->

                <!--########################################################## Cuerpo del documento ###################################################-->
                <div id="bodyCert">
                    <div style="width:100%;text-align: left; margin-top:30px;">
                        <div style="width:27%; height:7.5%; float:left; text-align:right;">
                            <div>
                                <img src="logoCipJunin.png" alt="" width="90px"; height="90px" style="padding-top:10px;">
                            </div>
                            <div style="font-size:10px; width:95%;">Ley N° 24648 </div>                                             
                        </div>
                        <div style="width:53%; height:7.5%; float:left; padding-left:10px;">
                            <div style="color: #c55f52; text-decoration: underline; font-size:14px; font-weight:bold; width:100%; text-align:center; padding-top:25px;">
                                COLEGIO DE INGENIEROS DEL PERÚ
                            </div>
                            <div style="color: #c55f52; font-size:22px; font-weight:bold; width:100%; text-align:center; padding-top:10px;">
                                Certificado De Habilidad
                            </div>
                        </div>
                        <div style="width:18%; height:7.5%; float:left">
                            <img src="codigoBarras.png" alt="" width="110px"; height="55px" style="padding-top:5px;">
                        </div>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top:10px;">
                        Los que suscriben certifican que:
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top:10px;">
                        El ingeniero (a):____________________________________________________________________________________________
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 10px;">
                        Adscrito al Consejo Departamental de:_____________________________________________________________________
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 10px;">
                        Con Registro de Matrícula del CIP N°:_______________________Fecha de Incorporación:______________________
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 10px;">
                        Especialidad:_______________________________________________________________________________________________
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 20px; font-size:8.7pt;">
                        De conformidad con la Ley N° 28858, Ley que complementa a la Ley N° 16053 del Ejercicio Profesional y el Estatuto                        
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 2px; font-size:8.9pt;">
                    del Colegio de Ingenieros Del Perú, SE ENCUENTRA COLEGIADO Y HÁBIL, en consecuencia está autorizado para <br>
                    ejercer la profesión de Ingeniero(a).
                    </div>                 
                    <div style="width:100%; padding-left: 135px; padding-top: 25px;">
                        <div style="width:15%; font-weight:bold; float:left; text-align:center;padding-top:8px; font-size:8pt;">ASUNTO</div>
                        <div style="width:80%; border:1px solid black; float:left; height:35px;"></div>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 8px;">
                        <div style="width:15%; font-weight:bold; float:left; text-align:center; font-size:8pt;">ENTIDAD <br> O <br> PROPIETARIO</div>
                        <div style="width:80%; border:1px solid black; float:left; padding-top:8px; height:30px;"></div>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 5px;">
                        <div style="width:15%; font-weight:bold; float:left; text-align:center;padding-top:5px; font-size:8pt;">LUGAR</div>
                        <div style="width:80%; border:1px solid black; float:left; height:35px;"></div>
                    </div>
                    <!--######################################### Fin Cuerpo del documento ##################################################################-->

                    <!--################################################## Pie del Documento ###############################################################-->
                    <div style="width:100%; padding-left: 135px; padding-top:20px;">
                        <div style="width:30%; height:40px; padding-left: 200px;">
                            <table style="width:90%; border-collapse: collapse;">
                                <tr>
                                    <th colspan="3" style="color:white; border:1px solid #c55f52; background:#c55f52; width:60px; height: 35px; font-size:9px; margin-left:0">El presente documento tiene <br>vigencia hasta</th>      
                                </tr>
                                <tr>
                                    <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Día</td>
                                    <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Mes</td>
                                    <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">AÑO</td>
                                </tr>
                                <tr>
                                    <td style="width:20px; height:22px; text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;">06</td>
                                    <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;">07</td>
                                    <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;">2021</td>
                                </tr>
                            </table>
                        </div>
                        <div style=" width:70%; height:40px;  padding-top:55px; font-size:11pt; font-weight:bold; padding-left:135px">
                            ______________________, de___________ del 20_____
                        </div>
                        <div style=" width:70%; height:40px;  padding-top:0px; font-size:15pt; font-weight:bold; padding-left:170px">
                            VÁLIDO SOLO ORIGINAL
                        </div>
                        <div style="width:100%; height:40px;  padding-top:25px; font-size:9pt; font-weight:bold; padding-bottom:0px!important">
                            <div style="float:left; width:40%; text-align:center; padding-left:70px; font-size:9px;">
                                _____________________________________________<br><br>
                                Ing. Carlos Fernando Herrera Descalzi<br> Decano Nacional <br> del Colegio de Ingenieros del Perú
                            </div>
                            <div style="float:left; width:35%; text-align:center; padding-left:10px;font-size:9px; ">
                            _____________________________________________<br><br>
                                Consejo Departamental <br> del Colegio de Ingenieros del Perú
                            </div>
                        </div>
                    </div>
                    <!--################################################## Fin del Pie del Documento ###############################################################-->
                </div>                
            </body>
        </html>';

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P'
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle(" CIP-JUNIN");
        $mpdf->SetAuthor("Cip Junin");
        // $mpdf->SetWatermarkText(("ANULADO"));   // anulada
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha =  0.5;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        // Output a PDF file directly to the browser
        $mpdf->Output(" CIP-JUNIN.pdf", 'I');
    
