<?php

require_once '../database/DataBaseConexion.php';

class PersonaAdo
{

    public function construct()
    {
    }

    public static function getAll($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayPersonas = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona 
            where 
            idDNI = ?
            or
            CIP = ?
            or
            Nombres like concat(?,'%') 
            or 
            Apellidos like concat(?,'%')
            order by CAST(FechaReg as date) asc
            offset ? rows fetch next ? rows only");
            $comandoPersona->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(3, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(4, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(5, $posicionPagina, PDO::PARAM_INT);
            $comandoPersona->bindParam(6, $filasPorPagina, PDO::PARAM_INT);
            $comandoPersona->execute();
            $count = 0;
            while ($row = $comandoPersona->fetch()) {
                $count++;
                array_push($arrayPersonas, array(
                    'Id' => $count + $posicionPagina,
                    'idDNI' => $row['idDNI'],
                    'Nombres' => $row['Nombres'],
                    'Apellidos' => $row['Apellidos'],
                    'Sexo' => $row["Sexo"] == 'M' ? "MASCULINO" : "FEMENINO",
                    'EstadoCivil' => $row['EstadoCivil'],
                    'Ruc' => $row['RUC'],
                    'Cip' => $row['CIP'],
                    'Condicion' => $row['Condicion']
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Persona
            where 
            idDNI = ?
            or
            CIP = ?
            or
            Nombres like concat(?,'%') 
            or Apellidos like concat(?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayPersonas, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllModal($search, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayPersonas = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            CASE CIP
                WHEN 'T' THEN 'Tramite'
                ELSE CIP END AS Cip, 
            dbo.Persona.idDNI as Dni, dbo.Persona.Apellidos + ', ' + dbo.Persona.Nombres AS Ingeniero, 
            CASE dbo.Persona.Condicion
                WHEN 'T' THEN 'Transeunte'
                WHEN 'F' THEN 'Fallecido'
                WHEN 'R' THEN 'Retirado'
                WHEN 'V' THEN 'Vitalicio'
                ELSE 'Ordinario' END AS Condicion,
            CONVERT(VARCHAR,CAST(dbo.Colegiatura.FechaColegiado AS DATE), 103) AS FechaColegiado,
            CONVERT(VARCHAR,CAST(ISNULL(dbo.ULTIMACuota.FechaUltimaCuota,dbo.Colegiatura.FechaColegiado) AS DATE), 103) AS FechaUltimaCuota, 
            CASE dbo.Persona.Condicion
                WHEN 'T' THEN 0
                ELSE DATEDIFF(M, ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado), GETDATE()) END AS Deuda,
            CASE
                WHEN CAST (DATEDIFF(M,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
                ELSE 'No Habilitado' END AS Habilidad
            FROM dbo.Persona
            LEFT OUTER JOIN dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI AND dbo.Colegiatura.Principal = 1
            INNER JOIN dbo.Especialidad ON dbo.Especialidad.idEspecialidad = dbo.Colegiatura.idEspecialidad
            LEFT OUTER JOIN dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
            --INNER JOIN dbo.Capitulo ON dbo.Capitulo.idCapitulo = dbo.Especialidad.idCapitulo 
            WHERE  dbo.Persona.idDNI = ?
            OR dbo.Persona.CIP = ? 
            OR dbo.Persona.Apellidos LIKE CONCAT(?,'%')
            OR dbo.Persona.Nombres LIKE CONCAT(?,'%')
            ORDER BY dbo.Persona.Apellidos ASC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $comandoPersona->bindParam(1, $search, PDO::PARAM_INT);
            $comandoPersona->bindParam(2, $search, PDO::PARAM_STR);
            $comandoPersona->bindParam(3, $search, PDO::PARAM_STR);
            $comandoPersona->bindParam(4, $search, PDO::PARAM_STR);
            $comandoPersona->bindParam(5, $posicionPagina, PDO::PARAM_INT);
            $comandoPersona->bindParam(6, $filasPorPagina, PDO::PARAM_INT);
            $comandoPersona->execute();
            $count = 0;
            while ($row = $comandoPersona->fetch()) {
                $count++;
                array_push($arrayPersonas, array(
                    'Id' => $count + $posicionPagina,
                    'Cip' => $row['Cip'],
                    'Dni' => $row['Dni'],
                    'Ingeniero' => $row['Ingeniero'],
                    'FechaColegiado' => $row['FechaColegiado'],
                    'Condicion' => $row['Condicion'],
                    'FechaUltimaCuota' => $row['FechaUltimaCuota'],
                    'Deuda' => $row['Deuda'],
                    'Habilidad' => $row['Habilidad']
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM dbo.Persona
             LEFT OUTER JOIN
                  dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI
                  AND dbo.Colegiatura.Principal = 1
                  INNER JOIN
                  dbo.Especialidad ON dbo.Especialidad.idEspecialidad = dbo.Colegiatura.idEspecialidad
                  LEFT OUTER JOIN
                  dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
                  WHERE dbo.Persona.idDNI = ? 
                  or dbo.Persona.CIP = ? 
                  or dbo.Persona.Apellidos like concat(?,'%')
                  or dbo.Persona.Nombres like concat(?,'%')");
            $comandoTotal->bindParam(1, $search, PDO::PARAM_INT);
            $comandoTotal->bindParam(2, $search, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $search, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $search, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayPersonas, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getId($idPersona)
    {
        try {
            $array = array();
            //trae informacion del usuario (por su dni)
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.idUsuario,
            p.Nombres, 
            p.Apellidos, 
            p.Sexo, 
            cast(p.FechaNac as date) as FechaNacimiento, 
            p.EstadoCivil, 
            p.FechaReg, 
            p.RUC, 
            p.CIP, 
            p.Condicion, 
            p.TEMP, 
            p.RAZONSOCIAL
            FROM Persona AS p  WHERE p.idDNI = ?");
            $comandoPersona->bindParam(1, $idPersona, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();
            //trae la imagen del usuario
            $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
            idDNI,Foto
            FROM PersonaImagen WHERE idDNI = ?");
            $cmdImage->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdImage->execute();
            $image = null;

            if ($row = $cmdImage->fetch()) {
                $image = (object)array($row['idDNI'], base64_encode($row['Foto']));
            }

            array_push($array, $object, $image);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIdCobros($idPersona)
    {
        try {
            $array = array();
            //trae informacion del usuario (por su dni)
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.idUsuario,
            p.Nombres, 
            p.Apellidos, 
            p.Sexo, 
            cast(p.FechaNac as date) as FechaNacimiento, 
            p.EstadoCivil, 
            p.FechaReg, 
            p.RUC, 
            p.CIP, 
            p.Condicion, 
            p.TEMP, 
            p.RAZONSOCIAL
            FROM Persona AS p  WHERE p.idDNI = ?");
            $comandoPersona->bindParam(1, $idPersona, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();

            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT        
            CAST(dbo.Colegiatura.FechaColegiado AS DATE) as FechaColegiado,
            CAST(ISNULL(dbo.ULTIMACuota.FechaUltimaCuota,dbo.Colegiatura.FechaColegiado) AS DATE) AS UltimaCuota, 
            CAST(DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota,dbo.Colegiatura.FechaColegiado)) AS DATE) AS HabilitadoHasta     
            FROM dbo.Persona
            LEFT OUTER JOIN dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI AND dbo.Colegiatura.Principal = 1
            LEFT OUTER JOIN dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
            WHERE dbo.Persona.idDNI = ? ");
            $cmdColegiatura->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdColegiatura->execute();
            $resultColegiatura = null;
            if ($row = $cmdColegiatura->fetch()) {
                $dateUltimaCuota = new DateTime($row['UltimaCuota']);
                $dateHabilHasta = new DateTime($row['HabilitadoHasta']);
                $resultColegiatura = (object)array("FechaColegiado" => $row['FechaColegiado'], "UltimaCuota" => $dateUltimaCuota->format("m/Y"), "HabilitadoHasta" => $dateHabilHasta->format("m/Y"));
            }

            $cmdYears = Database::getInstance()->getDb()->prepare("SELECT 
            datediff(year,getdate(),dateadd(month,c.MesAumento,dateadd(year,30,c.FechaColegiado)))
			from Persona as p inner join Colegiatura as c
			on p.idDNI = c.idDNI and c.Principal = 1
            where p.idDNI = ?");
            $cmdYears->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdYears->execute();
            $resultYears =  $cmdYears->fetchColumn();

            $cmdDate = Database::getInstance()->getDb()->prepare("SELECT 
            dateadd(month,c.MesAumento,dateadd(year,30,c.FechaColegiado))
			from Persona as p inner join Colegiatura as c
			on p.idDNI = c.idDNI and c.Principal = 1
            where p.idDNI = ?");
            $cmdDate->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdDate->execute();
            $resultDate =  $cmdDate->fetchColumn();

            array_push($array, $object, $resultColegiatura, $resultYears, $resultDate);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getHistorialPagos($idPersona, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();

            $cmdHistorial = Database::getInstance()->getDb()->prepare("SELECT dbo.Ingreso.idIngreso, dbo.Ingreso.idDNI, CONCAT(dbo.Ingreso.Serie,' - ',dbo.Ingreso.NumRecibo) AS Recibo, 
            dbo.Ingreso.Fecha,dbo.Ingreso.Hora,
                CASE 
                    WHEN NOT idCuota IS NULL THEN RIGHT(CONVERT(VARCHAR(10), Cuota.FechaIni, 103), 7) + ' a ' + RIGHT(CONVERT(VARCHAR(10), Cuota.FechaFin, 103), 7) 
                        ELSE Ingreso.Observacion END AS Observacion, dbo.vINGRESOTotal.Total,
                            CASE 
                                WHEN NOT idCuota IS NULL THEN 1
                                WHEN NOT idAltaColegio IS NULL THEN 4 
                                WHEN NOT idHabilidad IS NULL THEN 5 
                                WHEN NOT idResidencia IS NULL THEN 6 
                                WHEN NOT idProyecto IS NULL THEN 7 
                                WHEN NOT idPeritaje IS NULL THEN 8 
                                ELSE 100 END AS TipoIngreso
                FROM dbo.Ingreso INNER JOIN dbo.vINGRESOTotal ON dbo.vINGRESOTotal.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.Cuota ON dbo.Cuota.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.AltaColegio ON dbo.AltaColegio.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.CERTHabilidad ON dbo.CERTHabilidad.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.CERTResidencia ON dbo.CERTResidencia.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.CERTProyecto ON dbo.CERTProyecto.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.Peritaje ON dbo.Peritaje.idIngreso = dbo.Ingreso.idIngreso
                WHERE (dbo.Ingreso.Estado = 'C') AND idDNI = ?
                ORDER BY dbo.Ingreso.Fecha DESC,dbo.Ingreso.Hora DESC
                offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdHistorial->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdHistorial->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $cmdHistorial->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $cmdHistorial->execute();
            $count = 0;
            $arrayHistorial = array();
            while ($row = $cmdHistorial->fetch()) {
                $count++;
                array_push($arrayHistorial, array(
                    "Id" => $count + $posicionPagina,
                    "IdIngreso" => $row["idIngreso"],
                    "Recibo" => $row["Recibo"],
                    "Fecha" => $row["Fecha"],
                    "Hora" => $row["Hora"],
                    "Concepto" => $row["TipoIngreso"],
                    "Monto" => number_format($row["Total"], 2, ".", ""),
                    "Observacion" => $row["Observacion"],
                ));
            }

            $cmdTotales = Database::getInstance()->getDb()->prepare("SELECT COUNT(dbo.Ingreso.idIngreso)
                FROM dbo.Ingreso INNER JOIN dbo.vINGRESOTotal ON dbo.vINGRESOTotal.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.Cuota ON dbo.Cuota.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.AltaColegio ON dbo.AltaColegio.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.CERTHabilidad ON dbo.CERTHabilidad.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.CERTResidencia ON dbo.CERTResidencia.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.CERTProyecto ON dbo.CERTProyecto.idIngreso = dbo.Ingreso.idIngreso 
                                LEFT OUTER JOIN dbo.Peritaje ON dbo.Peritaje.idIngreso = dbo.Ingreso.idIngreso
                WHERE (dbo.Ingreso.Estado = 'C') AND idDNI = ?");
            $cmdTotales->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdTotales->execute();
            $resultTotal = $cmdTotales->fetchColumn();

            array_push($array,  $arrayHistorial, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function update($persona)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona
            WHERE idDNI = ?");
            $comandoValidate->bindParam(1, $persona['dni'], PDO::PARAM_STR);
            $comandoValidate->execute();
            if ($comandoValidate->fetch()) {
                $comandoPersona = Database::getInstance()->getDb()->prepare("UPDATE Persona SET 
                Nombres = UPPER(?),
                Apellidos = UPPER(?),
                Sexo = ?,
                FechaNac = ?,
                EstadoCivil = ?,
                RUC = ?,
                RAZONSOCIAL = ?,
                CIP = ?,
                Condicion = ?
                WHERE idDNI = ?");

                $comandoPersona->bindParam(1, $persona['nombres'], PDO::PARAM_STR);
                $comandoPersona->bindParam(2, $persona['apellidos'], PDO::PARAM_STR);
                $comandoPersona->bindParam(3, $persona['sexo'], PDO::PARAM_STR);
                $comandoPersona->bindParam(4, $persona['nacimiento'], PDO::PARAM_STR);
                $comandoPersona->bindParam(5, $persona['estado_civil'], PDO::PARAM_STR);
                $comandoPersona->bindParam(6, $persona['ruc'], PDO::PARAM_STR);
                $comandoPersona->bindParam(7, $persona['rason_social'], PDO::PARAM_STR);
                $comandoPersona->bindParam(8, $persona['cip'], PDO::PARAM_STR);
                $comandoPersona->bindParam(9, $persona['condicion'], PDO::PARAM_STR);
                $comandoPersona->bindParam(10, $persona['dni'], PDO::PARAM_STR);
                $comandoPersona->execute();

                Database::getInstance()->getDb()->commit();
                return 'updated';
            } else {
                Database::getInstance()->getDb()->rollback();
                return 'noexists';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateImage($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $image = $body['image'] == null ? null : base64_decode($body['image']);

            $cmdImage = Database::getInstance()->getDb()->prepare('INSERT INTO PersonaImagen(idDNI,Foto)VALUES(?,?)');
            $cmdImage->bindParam(1, $body['dni'], PDO::PARAM_STR);
            $cmdImage->bindParam(2, $image,  PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
            $cmdImage->execute();

            Database::getInstance()->getDb()->commit();
            return 'updated';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insert($persona)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE idDNI = ?");
            $comandoValidate->bindParam(1, $persona['dni'], PDO::PARAM_STR);
            $comandoValidate->execute();
            if ($comandoValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "duplicate";
            } else {

                $comandoPersona = Database::getInstance()->getDb()->prepare("INSERT INTO Persona (idDNI,idUsuario,Nombres,Apellidos,Sexo,FechaNac,EstadoCivil,RUC,RAZONSOCIAL,CIP,Condicion)
                VALUES (?,'-1',UPPER(?),UPPER(?),?,?,?,?,?,?,?)");

                $comandoPersona->bindParam(1, $persona['dni'], PDO::PARAM_STR);
                $comandoPersona->bindParam(2, $persona['nombres'], PDO::PARAM_STR);
                $comandoPersona->bindParam(3, $persona['apellidos'], PDO::PARAM_STR);
                $comandoPersona->bindParam(4, $persona['sexo'], PDO::PARAM_STR);
                $comandoPersona->bindParam(5, $persona['nacimiento'], PDO::PARAM_STR);
                $comandoPersona->bindParam(6, $persona['estado_civil'], PDO::PARAM_STR);
                $comandoPersona->bindParam(7, $persona['ruc'], PDO::PARAM_STR);
                $comandoPersona->bindParam(8, $persona['rason_social'], PDO::PARAM_STR);
                $comandoPersona->bindParam(9, $persona['cip'], PDO::PARAM_STR);
                $comandoPersona->bindParam(10, $persona['condicion'], PDO::PARAM_STR);

                $comandoPersona->execute();
                Database::getInstance()->getDb()->commit();
                return 'create';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function delete()
    {
    }

    public static function getColegiatura($idDni)
    {
        try {
            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT c.idColegiado, s.idConsejo, s.Consejo, ca.idCapitulo ,ISNULL(ca.Capitulo,'CAPITULO NO REGISTRAD0') AS Capitulo, e.idEspecialidad ,UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
            convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, c.idUnivesidadEgreso AS idUnivEgreso,ISNULL(ue.Universidad,'UNIVERSIDAD NO REGISTRADA') AS UnivesidadEgreso, convert(VARCHAR,cast(c.FechaEgreso AS DATE),103) AS FechaEgreso, 
            u.idUniversidad, ISNULL(u.Universidad,'UNIVERSIDAD NO REGISTRADA') AS Universidad, Convert(VARCHAR,cast(c.FechaTitulacion AS DATE),103) AS FechaTitulacion, 
            c.Resolucion, c.Principal FROM Colegiatura  AS c
                LEFT JOIN Sede AS s ON s.idConsejo = c.idSede
                LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
				LEFT JOIN Universidad as ue ON ue.idUniversidad = c.idUnivesidadEgreso 
                LEFT JOIN Universidad AS u ON u.idUniversidad = c.idUniversidad where idDNI = ?");
            $cmdColegiatura->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdColegiatura->execute();

            $arrayColegiaturas = array();

            $count = 0;
            while ($row = $cmdColegiatura->fetch()) {
                $count++;
                array_push($arrayColegiaturas, array(
                    'Id' => $count,
                    'IdColegiatura' => $row['idColegiado'],
                    'IdSede' => $row['idConsejo'],
                    'sede' => $row['Consejo'],
                    'IdCapitulo' => $row['idCapitulo'],
                    'capitulo' => $row['Capitulo'],
                    'IdEspecialidad' => $row['idEspecialidad'],
                    'especialidad' => $row['Especialidad'],
                    'fechaColegiado' => $row['FechaColegiado'],
                    'IdUnivEgreso' => $row['idUnivEgreso'],
                    'universidadEgreso' => $row['UnivesidadEgreso'],
                    'fechaEgreso' => $row['FechaEgreso'],
                    'IdUnivTitulacion' => $row['idUniversidad'],
                    'universidadTitulacion' => $row['Universidad'],
                    'fechaTitulacion' => $row['FechaTitulacion'],
                    'resolucion' => $row['Resolucion'],
                    'principal' => $row['Principal']
                ));
            }

            return $arrayColegiaturas;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getDomicilio($idDni)
    {
        try {
            $cmdDomicilio = Database::getInstance()->getDb()->prepare("SELECT d.idDireccion,t.idTipo, ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo,
            UPPER(d.Direccion) AS Direccion, u.IdUbigeo, CONCAT((ISNULL (u.Departamento,'DEPARTAMENTO NO REGISTRADA')),' - ',
			(ISNULL (u.Provincia,'DEPARTAMENTO NO REGISTRADA')),' - ',(ISNULL (u.Distrito,'DEPARTAMENTO NO REGISTRADA')  )) AS Ubigeo FROM Direccion AS d
            LEFT JOIN Tipos AS t ON t.idTipo = d.Tipo 
            LEFT JOIN Ubigeo AS u ON u.idUbigeo = d.Ubigeo
            WHERE d.idDNI = ?");
            $cmdDomicilio->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdDomicilio->execute();

            $arrayDomicilios = array();
            $count = 0;
            while ($row = $cmdDomicilio->fetch()) {
                $count++;
                array_push($arrayDomicilios, array(
                    'Id' => $count,
                    'IdDireccion' => $row['idDireccion'],
                    'IdTipo' => $row['idTipo'],
                    'tipo' => $row['Tipo'],
                    'direccion' => $row['Direccion'],
                    'IdUbigeo' => $row['IdUbigeo'],
                    'ubigeo' => $row['Ubigeo']
                ));
            }
            return $arrayDomicilios;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getTelefono($idDni)
    {
        try {
            $cmdTelefono = Database::getInstance()->getDb()->prepare("SELECT a.idTelefono, t.idTipo, ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo , a.Telefono FROM Telefono AS a 
            LEFT JOIN Tipos AS t ON t.idTipo = a.Tipo WHERE a.idDNI = ?");
            $cmdTelefono->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdTelefono->execute();

            $arrayTelefonos = array();

            $count = 0;
            while ($row = $cmdTelefono->fetch()) {
                $count++;
                array_push($arrayTelefonos, array(
                    'Id' => $count,
                    'IdTelefono' => $row['idTelefono'],
                    'IdTipo' => $row['idTipo'],
                    'tipo' => $row['Tipo'],
                    'numero' => $row['Telefono'],
                ));
            }
            return $arrayTelefonos;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getConyuge($idDni)
    {
        try {
            $cmdConyuge = Database::getInstance()->getDb()->prepare('SELECT IdConyugue, UPPER(FullName) AS NombreCompleto, NumHijos FROM Conyuge WHERE idDNI = ?');
            $cmdConyuge->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdConyuge->execute();

            $arrayConyuge = array();

            $count = 0;
            while ($row = $cmdConyuge->fetch()) {
                $count++;
                array_push($arrayConyuge, array(
                    'Id' => $count,
                    'IdConyuge' => $row['IdConyugue'],
                    'NombreCompleto' => $row['NombreCompleto'],
                    'Hijos' => $row['NumHijos'],
                ));
            }
            return $arrayConyuge;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getExperiencia($idDni)
    {
        try {
            $cmdExperiencia = Database::getInstance()->getDb()->prepare("SELECT idExperiencia, UPPER(Entidad) AS Entidad, UPPER(ExpericienciaEn) AS  Experiencia,  
            CONVERT(VARCHAR,cast(FechaInicio AS DATE),103) AS FechaInicio, CONVERT(VARCHAR,cast(FechaFin AS DATE),103) AS FechaFin
             FROM Experiencia WHERE idPersona = ?");
            $cmdExperiencia->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdExperiencia->execute();

            $arrayExperiencia = array();

            $count = 0;
            while ($row = $cmdExperiencia->fetch()) {
                $count++;
                array_push($arrayExperiencia, array(
                    'Id' => $count,
                    'IdExperiencia' => $row['idExperiencia'],
                    'Entidad' => $row['Entidad'],
                    'Experiencia' => $row['Experiencia'],
                    'FechaInicio' => $row['FechaInicio'],
                    'FechaFin' => $row['FechaFin'],
                ));
            }
            return $arrayExperiencia;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getGradosyEstudios($idDni)
    {
        try {
            $cmdgradosyestudios = Database::getInstance()->getDb()->prepare("SELECT g.idEstudio, t.idTipo, UPPER(t.Descripcion) AS Grado, UPPER(Materia) AS Materia, u.idUniversidad, ISNULL(u.Universidad, 'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            CONVERT(VARCHAR, cast(g.FechaGrado AS DATE), 103) AS Fecha FROM Grados AS g LEFT JOIN Universidad AS u ON u.idUniversidad = g.idUniversidad
            LEFT JOIN Tipos AS t ON t.idTipo = g.Grado AND t.Categoria = 'D'
            WHERE g.idDNI = ?");
            $cmdgradosyestudios->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdgradosyestudios->execute();

            $arraygradosyestudios = array();

            $count = 0;
            while ($row = $cmdgradosyestudios->fetch()) {
                $count++;
                array_push($arraygradosyestudios, array(
                    'Id' => $count,
                    'IdEstudio' => $row['idEstudio'],
                    'IdTipo' => $row['idTipo'],
                    'Grado' => $row['Grado'],
                    'Materia' => $row['Materia'],
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                    'Fecha' => $row['Fecha'],
                ));
            }
            return $arraygradosyestudios;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCorreoyWeb($idDni)
    {
        try {
            $cmdcorreoyweb = Database::getInstance()->getDb()->prepare("SELECT w.idWeb, t.idTipo, ISNULL(t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, UPPER(w.Direccion) AS Direccion from Web AS w 
            INNER JOIN Tipos AS t ON t.idTipo = w.Tipo WHERE idDNI = ?");
            $cmdcorreoyweb->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdcorreoyweb->execute();

            $arraycorreoyweb = array();

            $count = 0;
            while ($row = $cmdcorreoyweb->fetch()) {
                $count++;
                array_push($arraycorreoyweb, array(
                    'Id' => $count,
                    'IdWeb' => $row['idWeb'],
                    'IdTipo' => $row['idTipo'],
                    'Tipo' => $row['Tipo'],
                    'Direccion' => $row['Direccion'],
                ));
            }

            return $arraycorreoyweb;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getaddcolegiatura()
    {
        try {
            $arrayAddColegiatura = array();

            $cmdsede = Database::getInstance()->getDb()->prepare('SELECT idConsejo ,UPPER(Consejo) AS Consejo from Sede');
            $cmdsede->execute();
            $arraySede = array();
            while ($row = $cmdsede->fetch()) {
                array_push($arraySede, array(
                    'IdConsejo' => $row['idConsejo'],
                    'Sede' => $row['Consejo'],
                ));
            }

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare('SELECT idEspecialidad, UPPER (Especialidad) AS Especialidad from Especialidad');
            $cmdEspecialidad->execute();
            $arrayEspecialidad = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidad, array(
                    'IdEspecialidad' => $row['idEspecialidad'],
                    'Especialidad' => $row['Especialidad'],
                ));
            }

            $cmdUniversidad = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, CONCAT(UPPER (Universidad),'  (',UPPER (siglas),')') AS Universidad from Universidad");
            $cmdUniversidad->execute();
            $arrayUniversidad = array();
            while ($row = $cmdUniversidad->fetch()) {
                array_push($arrayUniversidad, array(
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                ));
            }

            array_push($arrayAddColegiatura, $arraySede, $arrayEspecialidad, $arrayUniversidad);
            return $arrayAddColegiatura;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAddDomicilio()
    {
        try {
            $arrayAddDomicilio = array();

            $cmdTipo = Database::getInstance()->getDb()->prepare("SELECT idTipo, Descripcion FROM tipos WHERE Categoria = 'A'");
            $cmdTipo->execute();
            $arrayTipoDomicilio = array();
            while ($row = $cmdTipo->fetch()) {
                array_push($arrayTipoDomicilio, array(
                    'IdTipo' => $row['idTipo'],
                    'Descripcion' => $row['Descripcion']
                ));
            }

            $cmdUbicacion = Database::getInstance()->getDb()->prepare(" SELECT idUbigeo, CONCAT(Departamento, ' - ', Provincia, ' - ', 
            Distrito) AS Ubicacion FROM Ubigeo ");
            $cmdUbicacion->execute();
            $arrayUbicación = array();
            while ($row = $cmdUbicacion->fetch()) {
                array_push($arrayUbicación, array(
                    'IdUbicacion' => $row['idUbigeo'],
                    'Ubicacion' => $row['Ubicacion'],
                ));
            }

            array_push($arrayAddDomicilio, $arrayTipoDomicilio, $arrayUbicación);
            return $arrayAddDomicilio;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAddCelular()
    {
        try {
            $cmdCelular = Database::getInstance()->getDb()->prepare("SELECT idTipo, Descripcion FROM tipos WHERE Categoria = 'B'");
            $cmdCelular->execute();
            $arrayCelular = array();
            while ($row = $cmdCelular->fetch()) {
                array_push($arrayCelular, array(
                    'IdTipo' => $row['idTipo'],
                    'Tipo' => $row['Descripcion'],
                ));
            }
            return $arrayCelular;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAddEstudios()
    {
        try {
            $arrayEstudios = array();

            $cmdgrado = Database::getInstance()->getDb()->prepare("SELECT idTipo, UPPER(Descripcion) AS Descripcion FROM tipos WHERE Categoria = 'D'");
            $cmdgrado->execute();
            $arrayGrado = array();
            while ($row = $cmdgrado->fetch()) {
                array_push($arrayGrado, array(
                    'IdGrado' => $row['idTipo'],
                    'Grado' => $row['Descripcion'],
                ));
            }

            $cmdUniversidad = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, CONCAT(UPPER (Universidad),'  (',UPPER (siglas),')') AS Universidad from Universidad");
            $cmdUniversidad->execute();
            $arrayUniversidad = array();
            while ($row = $cmdUniversidad->fetch()) {
                array_push($arrayUniversidad, array(
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                ));
            }
            array_push($arrayEstudios, $arrayGrado, $arrayUniversidad);

            return $arrayEstudios;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCorreo()
    {
        try {
            $cmdcorreo = Database::getInstance()->getDb()->prepare("SELECT idTipo, UPPER(Descripcion) AS Descripcion FROM tipos WHERE Categoria = 'C'");
            $cmdcorreo->execute();
            $arraycorreo = array();
            while ($row = $cmdcorreo->fetch()) {
                array_push($arraycorreo, array(
                    'IdCorreo' => $row['idTipo'],
                    'Correoyweb' => $row['Descripcion'],
                ));
            }

            return $arraycorreo;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public static function getPicture($idDni)
    {
        try {
            $cmdfoto = Database::getInstance()->getDb()->prepare("SELECT UPPER(P.Nombres) AS Nombre, ISNULL(i.Foto, 0) AS Foto FROM PersonaImagen AS i 
            LEFT JOIN Persona AS p ON P.idDNI = i.idDNI WHERE I.idDNI = ?");
            $cmdfoto->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdfoto->execute();

            $arrayFoto = array();

            while ($row = $cmdfoto->fetch()) {
                array_push($arrayFoto, array(
                    'Nombre' => $row['Tipo'],
                    'Foto' => $row['Direccion'],
                ));
            }
            return $arrayFoto;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insertColegiatura($colegiatura)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Colegiatura WHERE UPPER(Resolucion) = UPPER(?)');
            $cmdSelect->bindParam(1, $colegiatura['resolucion'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Colegiatura WHERE idDNI = ?');
                $cmdSelect->bindParam(1, $colegiatura['dni'], PDO::PARAM_STR);
                $cmdSelect->execute();
                if ($cmdSelect->fetch()) {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Colegiatura (
                        idDNI,
                        idSede,
                        idEspecialidad, 
                        FechaColegiado,
                        idUnivesidadEgreso, 
                        FechaEgreso,
                        idUniversidad,
                        FechaTitulacion,
                        Resolucion, 
                        Principal,
                        Resolucion15,
                        MesAumento)
                    VALUES(?,?,?,?,?,?,?,?,?,0,0,0)");

                    $comandoInsert->bindParam(1, $colegiatura['dni'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $colegiatura['sede'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(3, $colegiatura['especialidad'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(4, $colegiatura['fechacolegiacion'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $colegiatura['universidadegreso'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(6, $colegiatura['fechaegreso'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(7, $colegiatura['universidadtitulacion'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(8, $colegiatura['fechatitulo'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(9, $colegiatura['resolucion'], PDO::PARAM_STR);

                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return 'Insertado';
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Colegiatura (
                        idDNI,
                        idSede,
                        idEspecialidad, 
                        FechaColegiado,
                        idUnivesidadEgreso, 
                        FechaEgreso,
                        idUniversidad,
                        FechaTitulacion,
                        Resolucion, 
                        Principal,
                        Resolucion15,
                        MesAumento)
                    VALUES(?,?,?,?,?,?,?,?,?,1,0,0)");

                    $comandoInsert->bindParam(1, $colegiatura['dni'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $colegiatura['sede'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(3, $colegiatura['especialidad'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(4, $colegiatura['fechacolegiacion'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $colegiatura['universidadegreso'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(6, $colegiatura['fechaegreso'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(7, $colegiatura['universidadtitulacion'], PDO::PARAM_INT);
                    $comandoInsert->bindParam(8, $colegiatura['fechatitulo'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(9, $colegiatura['resolucion'], PDO::PARAM_STR);

                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return 'Insertado';
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertDomicilio($domicilio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Direccion (idDNI, Tipo, Ubigeo, Direccion) VALUES (?,?,?,?)');

            $comandoInsert->bindParam(1, $domicilio['dni'], PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $domicilio['tipo'], PDO::PARAM_INT);
            $comandoInsert->bindParam(3, $domicilio['departamento'], PDO::PARAM_INT);
            $comandoInsert->bindParam(4, $domicilio['direccion'], PDO::PARAM_INT);

            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            return 'Insertado';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertCelular($celular)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Telefono WHERE Telefono = ?');
            $cmdSelect->bindParam(1, $celular['numero'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Telefono (idDNI, Tipo, Telefono) VALUES (?,?,?)');

                $comandoInsert->bindParam(1, $celular['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $celular['tipo'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $celular['numero'], PDO::PARAM_INT);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertConyuge($conyuge)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Conyuge WHERE UPPER(FullName) = UPPER(?)');
            $cmdSelect->bindParam(1, $conyuge['conyuge'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Conyuge (idDNI, FullName, NumHijos) VALUES (?,UPPER(?),?)');

                $comandoInsert->bindParam(1, $conyuge['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $conyuge['conyuge'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $conyuge['hijos'], PDO::PARAM_INT);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertExperiencia($experiencia)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Experiencia WHERE UPPER(Entidad) = UPPER(?) AND UPPER(ExpericienciaEn) = UPPER(?)');
            $cmdSelect->bindParam(1, $experiencia['entidad'], PDO::PARAM_STR);
            $cmdSelect->bindParam(2, $experiencia['experiencia'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Experiencia (idPersona, Entidad, ExpericienciaEn, FechaInicio, FechaFin) 
            VALUES (?,UPPER(?),UPPER(?),?,?);");

                $comandoInsert->bindParam(1, $experiencia['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $experiencia['entidad'], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $experiencia['experiencia'], PDO::PARAM_STR);
                $comandoInsert->bindParam(4, $experiencia["fechaInicio"], PDO::PARAM_STR);
                $comandoInsert->bindParam(5, $experiencia["fechaFin"], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertEstudios($estudios)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Grados WHERE Grado = ? AND UPPER(Materia) = UPPER(?) AND idUniversidad = ?');
            $cmdSelect->bindParam(1, $estudios['grado'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $estudios['materia'], PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $estudios['universidad'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Grados (idDNI, Materia, Grado, idUniversidad, FechaGrado) VALUES (?,UPPER(?),?,?,?);');

                $comandoInsert->bindParam(1, $estudios['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $estudios['materia'], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $estudios['grado'], PDO::PARAM_INT);
                $comandoInsert->bindParam(4, $estudios['universidad'], PDO::PARAM_INT);
                $comandoInsert->bindParam(5, $estudios["fechaEstudios"], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertCorreo($correo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Web WHERE LOWER(Direccion) = ? AND Tipo = ?');
            $cmdSelect->bindParam(1, $correo['correo'], PDO::PARAM_STR);
            $cmdSelect->bindParam(2, $correo['tipo'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Web (idDNI, Tipo, Direccion) VALUES (?,?,LOWER(?));');

                $comandoInsert->bindParam(1, $correo['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $correo['tipo'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $correo['correo'], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateColegiatura($colegiatura)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Colegiatura SET
                idSede = ?,
                idEspecialidad = ?, 
                FechaColegiado = ?,
                idUnivesidadEgreso = ?, 
                FechaEgreso = ?,
                idUniversidad = ?,
                FechaTitulacion = ?,
                Resolucion = ?
                WHERE idColegiado = ?");

            $cmdUpdate->bindParam(1, $colegiatura['sede'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(2, $colegiatura['especialidad'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(3, $colegiatura['fechacolegiacion'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(4, $colegiatura['universidadegreso'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(5, $colegiatura['fechaegreso'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(6, $colegiatura['universidadtitulacion'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(7, $colegiatura['fechatitulo'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(8, $colegiatura['resolucion'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(9, $colegiatura['idcolegiatura'], PDO::PARAM_INT);

            $cmdUpdate->execute();
            Database::getInstance()->getDb()->commit();
            return 'Actualizado';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteColegiatura($colegiatura)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Colegiatura WHERE idColegiado = ?");
            $comandSelect->bindParam(1, $colegiatura["idcolegiatura"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateDomicilio($domicilio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Direccion WHERE idDireccion <> ? AND UPPER(Direccion) = UPPER(?) AND Ubigeo = ?');
            $cmdSelect->bindParam(1, $domicilio['idDireccion'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $domicilio['direccion'], PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $domicilio['departamento'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Direccion SET
                Tipo = ?,
                Ubigeo = ?, 
                Direccion = ?
                WHERE idDireccion = ?");

                $cmdUpdate->bindParam(1, $domicilio['tipo'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $domicilio['departamento'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(3, $domicilio['direccion'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(4, $domicilio['idDireccion'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteDomicilio($domicilio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Direccion WHERE idDireccion = ?");
            $comandSelect->bindParam(1, $domicilio["iddomicilio"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateTelefono($telefono)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Telefono WHERE idTelefono <> ? AND Telefono = ?');
            $cmdSelect->bindParam(1, $telefono['idTelefono'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $telefono['numero'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Telefono SET
                Tipo = ?,
                Telefono = ?
                WHERE idTelefono = ?");

                $cmdUpdate->bindParam(1, $telefono['tipo'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $telefono['numero'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $telefono['idTelefono'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteTelefono($telefono)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Telefono WHERE idTelefono = ?");
            $comandSelect->bindParam(1, $telefono["idtelefono"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateConyuge($conyuge)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Conyuge WHERE idConyugue <> ? AND FullName = ?');
            $cmdSelect->bindParam(1, $conyuge['idConyuge'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $conyuge['Conyuge'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Conyuge SET
                FullName = ?,
                NumHijos = ?
                WHERE idConyugue = ?");

                $cmdUpdate->bindParam(1, $conyuge['Conyuge'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(2, $conyuge['hijos'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(3, $conyuge['idConyuge'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteConyuge($conyuge)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Conyuge WHERE IdConyugue = ?");
            $comandSelect->bindParam(1, $conyuge["idconyuge"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateExperiencia($experiencia)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Experiencia WHERE idExperiencia <> ? AND UPPER(Entidad) = UPPER(?) AND UPPER(ExpericienciaEn) = UPPER(?)');
            $cmdSelect->bindParam(1, $experiencia['idexperiencia'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $experiencia['entidad'], PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $experiencia['experiencia'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Experiencia SET
                Entidad = UPPER(?),
                ExpericienciaEn = UPPER(?),
                FechaInicio = ?,
                FechaFin = ?
                WHERE idExperiencia = ?");

                $cmdUpdate->bindParam(1, $experiencia['entidad'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(2, $experiencia['experiencia'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $experiencia['inicio'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(4, $experiencia['fin'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(5, $experiencia['idexperiencia'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteExperiencia($experiencia)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Experiencia WHERE idExperiencia = ?");
            $comandSelect->bindParam(1, $experiencia["idexperiencia"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateEstudios($estudios)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Grados WHERE idEstudio <> ? AND Grado = ? AND UPPER(Materia) = UPPER(?) AND idUniversidad = ?');
            $cmdSelect->bindParam(1, $estudios['IdEstudio'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $estudios['Grado'], PDO::PARAM_INT);
            $cmdSelect->bindParam(3, $estudios['Materia'], PDO::PARAM_STR);
            $cmdSelect->bindParam(4, $estudios['Universidad'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Grados SET
                Grado = ?,
                Materia = UPPER(?),
                idUniversidad = ?,
                FechaGrado = ?
                WHERE idEstudio = ?");

                $cmdUpdate->bindParam(1, $estudios['Grado'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $estudios['Materia'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $estudios['Universidad'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(4, $estudios['Fecha'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(5, $estudios['IdEstudio'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteEstudio($estudio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Grados WHERE idEstudio = ?");
            $comandSelect->bindParam(1, $estudio["idestudio"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateCorreo($correo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Web WHERE idWeb <> ? AND Tipo = ? AND LOWER(Direccion) = LOWER(?)');
            $cmdSelect->bindParam(1, $correo['IdCorreo'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $correo['Tipo'], PDO::PARAM_INT);
            $cmdSelect->bindParam(3, $correo['Direccion'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Web SET
                Tipo = ?,
                Direccion = LOWER(?)
                WHERE idWeb = ?");

                $cmdUpdate->bindParam(1, $correo['Tipo'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $correo['Direccion'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $correo['IdCorreo'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteCorreo($correo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Web WHERE idWeb = ?");
            $comandSelect->bindParam(1, $correo["IdCorreo"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getHabilidadIngeniero($opcion, $search, $tipoHabilidad, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayHabilidad = array();
            $comandoHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
            CASE CIP
                WHEN 'T' THEN 'Tramite'
                ELSE CIP END AS Cip, 
            dbo.Persona.idDNI as Dni, 
            dbo.Persona.Apellidos ,
            dbo.Persona.Nombres, 
            dbo.Persona.Condicion as CodigoCondicion,
            CASE dbo.Persona.Condicion
                WHEN 'T' THEN 'Transeunte'
                WHEN 'F' THEN 'Fallecido'
                WHEN 'R' THEN 'Retirado'
                WHEN 'V' THEN 'Vitalicio'
                ELSE 'Ordinario' END AS Condicion,
            ISNULL(dbo.Especialidad.Especialidad,'NO ESPECIFICADO') AS Especialidad,
            CAST(dbo.Colegiatura.FechaColegiado AS DATE)  AS FechaColegiado,
            CAST(ISNULL(dbo.ULTIMACuota.FechaUltimaCuota,dbo.Colegiatura.FechaColegiado) AS DATE) AS FechaUltimaCuota,             
            CASE
                WHEN CAST (DATEDIFF(M,DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
                ELSE 'No Habilitado' END AS Habilidad,
            CAST(DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota,dbo.Colegiatura.FechaColegiado)) AS DATE) AS HabilitadoHasta           
            FROM dbo.Persona
            LEFT OUTER JOIN dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI AND dbo.Colegiatura.Principal = 1
            INNER JOIN dbo.Especialidad ON dbo.Especialidad.idEspecialidad = dbo.Colegiatura.idEspecialidad
            LEFT OUTER JOIN dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
            WHERE $opcion = 0
            OR $opcion = 1 and dbo.Persona.idDNI = ? 
            OR $opcion = 1 and dbo.Persona.CIP = ? 
            OR $opcion = 1 and dbo.Persona.Apellidos LIKE CONCAT(?,'%')
            OR $opcion = 1 and dbo.Persona.Nombres LIKE CONCAT(?,'%')
            OR $opcion = 2 and $tipoHabilidad = 0
            OR $opcion = 2 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado)) , GETDATE()) AS INT) <=0
            OR $opcion = 2 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado)) , GETDATE()) AS INT) >0
            ORDER BY dbo.Persona.Apellidos ASC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $comandoHabilidad->bindParam(1, $search, PDO::PARAM_INT);
            $comandoHabilidad->bindParam(2, $search, PDO::PARAM_STR);
            $comandoHabilidad->bindParam(3, $search, PDO::PARAM_STR);
            $comandoHabilidad->bindParam(4, $search, PDO::PARAM_STR);
            $comandoHabilidad->bindParam(5, $posicionPagina, PDO::PARAM_INT);
            $comandoHabilidad->bindParam(6, $filasPorPagina, PDO::PARAM_INT);
            $comandoHabilidad->execute();
            $count = 0;
            while ($row = $comandoHabilidad->fetch()) {
                $count++;
                $dateFechaColegiado = new DateTime($row['FechaColegiado']);
                $dateFechaUltimaCuota = new DateTime($row['FechaUltimaCuota']);
                $dateHabilidadHasta = new DateTime($row['HabilitadoHasta']);
                array_push($arrayHabilidad, array(
                    'Id' => $count + $posicionPagina,
                    'Cip' => $row['Cip'],
                    'Dni' => $row['Dni'],
                    'Apellidos' => $row['Apellidos'],
                    'Nombres' => $row['Nombres'],
                    'Condicion' => $row['Condicion'],
                    'CodigoCondicion' => $row['CodigoCondicion'],
                    'Especialidad' => $row['Especialidad'],
                    'Colegiatura' => $row['FechaColegiado'],
                    'FechaColegiado' => $dateFechaColegiado->format("d/m/Y"),
                    'FechaUltimaCuota' => $dateFechaUltimaCuota->format("m/Y"),
                    'UltimaCuota' => $row['FechaUltimaCuota'],
                    'Habilidad' => $row['Habilidad'],
                    'HabilitadoHasta' =>  $dateHabilidadHasta->format("m/Y")
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM dbo.Persona
             LEFT OUTER JOIN
                  dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI
                  AND dbo.Colegiatura.Principal = 1
                  INNER JOIN
                  dbo.Especialidad ON dbo.Especialidad.idEspecialidad = dbo.Colegiatura.idEspecialidad
                  LEFT OUTER JOIN
                  dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
                  WHERE $opcion = 0
                  or $opcion = 1 and dbo.Persona.idDNI = ? 
                  or $opcion = 1 and dbo.Persona.CIP = ? 
                  or $opcion = 1 and dbo.Persona.Apellidos like concat(?,'%')
                  or $opcion = 1 and dbo.Persona.Nombres like concat(?,'%')
                  or $opcion = 2 and $tipoHabilidad = 0
                  or $opcion = 2 and $tipoHabilidad = 1 and CAST (DATEDIFF(M,DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado)) , GETDATE()) AS INT) <=0
                  or $opcion = 2 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,3,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado)) , GETDATE()) AS INT) >0");
            $comandoTotal->bindParam(1, $search, PDO::PARAM_INT);
            $comandoTotal->bindParam(2, $search, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $search, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $search, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayHabilidad, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //Funciones Ruber

    public static function getCountConditionPerson()
    {

        try {
            $cmdOrdinario = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='O'");
            $cmdTranseunte = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='T'");
            $cmdFallecido = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='F'");
            $cmdRetirado = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='R'");
            $cmdVitalicio = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='V'");
            $cmdTotalPersonas = Database::getInstance()->getDb()->prepare('SELECT count(1) FROM Persona');
            $cmdTotalHabilitados = Database::getInstance()->getDb()->prepare('SELECT  count(1) FROM ULTIMACuota WHERE DATEDIFF(M,GETDATE(), FechaUltimaCuota) >= 0');
            $cmdTotalInhabilitados = Database::getInstance()->getDb()->prepare('SELECT  count(1) FROM ULTIMACuota WHERE DATEDIFF(M,GETDATE(), FechaUltimaCuota) < 0');

            $cmdOrdinario->execute();
            $cmdTranseunte->execute();
            $cmdFallecido->execute();
            $cmdRetirado->execute();
            $cmdVitalicio->execute();
            $cmdTotalPersonas->execute();
            $cmdTotalHabilitados->execute();
            $cmdTotalInhabilitados->execute();

            $resultCondicion = [
                'Ordinario' => $cmdOrdinario->fetchColumn(),
                'Transeunte' => $cmdTranseunte->fetchColumn(),
                'Fallecido' => $cmdFallecido->fetchColumn(),
                'Retirado' => $cmdRetirado->fetchColumn(),
                'Vitalicio' => $cmdVitalicio->fetchColumn(),
                'Personas' => $cmdTotalPersonas->fetchColumn(),
                'Habilitados' => $cmdTotalHabilitados->fetchColumn(),
                'Inhabilitados' => $cmdTotalInhabilitados->fetchColumn()
            ];

            return $resultCondicion;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
