<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class NotaCreditoAdo
{
    public static function ListarNotasCredito($opcion, $buscar, $fechaInicio, $fechaFinal, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT 
            nc.idNotaCredito,             
            convert(VARCHAR, CAST(nc.Fecha AS DATE),103) AS FechadeRegistro, 
            nc.Hora, 
            nc.Serie, 
            nc.NumRecibo, 
            isnull(ep.NumeroRuc,p.NumDoc) AS NumeroDocumento,
            isnull(ep.Nombre,concat(p.Apellidos,' ',p.Nombres)) AS Persona,
            i.Serie AS SerieModificado,
            i.NumRecibo AS NumeracionModificado,
            isnull(nc.Xmlsunat,'') as Xmlsunat,
            isnull(nc.Xmldescripcion,'') as Xmldescripcion,
            sum(dn.Monto) AS Total
            FROM NotaCredito AS nc
            INNER JOIN TablaMotivoAnulacion AS ta ON ta.IdTablaMotivoAnulacion = nc.idMotivoAnulacion
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = nc.TipoComprobante
            INNER JOIN Ingreso AS i ON i.idIngreso = nc.idIngreso
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
            LEFT JOIN EmpresaPersona AS ep ON ep.IdEmpresa =i.idEmpresaPersona
            INNER JOIN NotaCreditoDetalle AS dn ON dn.idNotaCredito = nc.idNotaCredito
            WHERE
            ($opcion = 0)
            OR
            ($opcion = 1 AND nc.Fecha BETWEEN ? AND ?)
            OR
            ($opcion = 2 AND nc.Serie LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND nc.NumRecibo LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND CONCAT(nc.Serie,'-',nc.NumRecibo) LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND  isnull(ep.NumeroRuc,p.NumDoc) LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND isnull(ep.Nombre,concat(p.Apellidos,' ',p.Nombres)) LIKE CONCAT(?,'%'))
            GROUP BY 
            nc.idNotaCredito,
            nc.Fecha,
            nc.Hora, 
            nc.Serie, 
            nc.NumRecibo,
            ep.NumeroRuc,
            p.NumDoc,
            ep.Nombre,
            p.Apellidos,
            p.Nombres,
            i.Serie,
            i.NumRecibo,
            nc.Xmlsunat,
            nc.Xmldescripcion
            ORDER BY nc.Fecha DESC, nc.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdConcepto->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(5, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $posicionPagina, PDO::PARAM_INT);
            $cmdConcepto->bindParam(9, $filasPorPagina, PDO::PARAM_INT);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id" => $count + $posicionPagina,
                    "idNotaCredito" => $row["idNotaCredito"],
                    "FechadeRegistro" => $row["FechadeRegistro"],
                    "Hora" => $row["Hora"],
                    "Serie" => $row["Serie"],
                    "NumRecibo" => $row["NumRecibo"],
                    "NumeroDocumento" => $row["NumeroDocumento"],
                    "Persona" => $row["Persona"],
                    "SerieModificado" => $row["SerieModificado"],
                    "NumeracionModificado" => $row["NumeracionModificado"],
                    "Total" => $row["Total"],
                    "Xmlsunat" => $row["Xmlsunat"],
                    "Xmldescripcion" => NotaCreditoAdo::limitar_cadena($row["Xmldescripcion"], 100, "..."),
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) AS Total 
            FROM NotaCredito AS nc 
            INNER JOIN TablaMotivoAnulacion AS ta ON ta.IdTablaMotivoAnulacion = nc.idMotivoAnulacion
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = nc.TipoComprobante
            INNER JOIN Ingreso AS i ON i.idIngreso = nc.idIngreso
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
            LEFT JOIN EmpresaPersona AS ep ON ep.IdEmpresa =i.idEmpresaPersona
            WHERE
            ($opcion = 0)
            OR
            ($opcion = 1 AND nc.Fecha BETWEEN ? AND ?)
            OR
            ($opcion = 2 AND nc.Serie LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND nc.NumRecibo LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND CONCAT(nc.Serie,'-',nc.NumRecibo) LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND  isnull(ep.NumeroRuc,p.NumDoc) LIKE CONCAT(?,'%'))
            OR
            ($opcion = 2 AND isnull(ep.Nombre,concat(p.Apellidos,' ',p.Nombres)) LIKE CONCAT(?,'%'))");
            $comandoTotal->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(5, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(6, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(7, $buscar, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayIngresos, $resultTotal);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function limitar_cadena($cadena, $limite, $sufijo)
    {
        if (strlen($cadena) > $limite) {
            return substr($cadena, 0, $limite) . $sufijo;
        }
        return $cadena;
    }

    public static function DetalleNotaCreditoById($idNotaCredito)
    {
        try {
            $cmDetalleNotaCredito = Database::getInstance()->getDb()->prepare("SELECT 
            d.idNotaCreditoDetalle,            
            c.Concepto,            
            (d.Monto/d.Cantidad) AS Precio,
            d.Cantidad,
            d.Monto AS Total,
            i.Nombre,
            i.Valor,
            i.Codigo
            FROM NotaCreditoDetalle AS d 
            INNER JOIN Concepto AS c ON d.idConcepto = c.idConcepto
            INNER JOIN Impuesto AS i ON i.IdImpuesto = c.IdImpuesto
            WHERE d.idNotaCredito  = ? ");
            $cmDetalleNotaCredito->bindParam(1, $idNotaCredito, PDO::PARAM_INT);
            $cmDetalleNotaCredito->execute();
            $count = 0;

            $detalleNotaCredito = array();
            while ($row = $cmDetalleNotaCredito->fetch()) {
                $count++;
                array_push($detalleNotaCredito, array(
                    "Id" => $count,
                    "idNotaCreditoDetalle" => $row["idNotaCreditoDetalle"],
                    "Concepto" => $row["Concepto"],
                    "Precio" => $row["Precio"],
                    "Cantidad" => $row["Cantidad"],
                    "Total" => $row["Total"],
                    "Nombre" => $row["Nombre"],
                    "Valor" => $row["Valor"],
                    "Codigo" => $row["Codigo"],
                ));
            }
            return $detalleNotaCredito;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function ObtenerNotaCreditoXML($idNotaCredito)
    {
        try {
            $array = array();
            $totalsinimpuesto = 0;
            $opegravada =  0;
            $opeexogenerada = 0;
            $impuesto = 0;

            $cmdNotaCredito = Database::getInstance()->getDb()->prepare("SELECT 
            t.CodigoAlterno AS TipoDocumentoNotaCredito,
            t.Nombre AS Comprobante,
            nc.Serie AS SerieNotaCredito,
            nc.NumRecibo AS NumeracionNotaCredito,
            nc.Fecha AS FechaNotaCredito,
            nc.Hora as HoraNotaCredito,
            tc.CodigoAlterno,
            i.Serie,
            i.NumRecibo,
            ta.Codigo AS CodigoAnulacion, 
            ta.Nombre AS MotivoAnulacion,
            case when not e.IdEmpresa is null then 6 else 1 end as TipoDocumento,
            case when not e.IdEmpresa is null then 'R.U.C' else 'D.N.I' end as NombreDocumento,
            case when not e.IdEmpresa is null then 'Razón Social' else 'Nombres' end as TipoNombrePersona,
            isnull(e.NumeroRuc,p.idDNI) as NumeroDocumento,
            isnull(e.Nombre,concat(p.Apellidos,' ',p.Nombres)) as DatosPersona,
            isnull(e.Direccion,p.RUC) as Direccion,
            isnull(nc.CodigoHash,'') AS CodigoHash
            FROM  
            NotaCredito AS nc 
            INNER JOIN TipoComprobante AS t ON t.IdTipoComprobante = nc.TipoComprobante 
            INNER JOIN TablaMotivoAnulacion AS ta ON ta.IdTablaMotivoAnulacion = nc.idMotivoAnulacion
            INNER JOIN Ingreso AS i ON i.idIngreso = nc.idIngreso
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = i.TipoComprobante 
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
			LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona            
            WHERE nc.idNotaCredito = ?");
            $cmdNotaCredito->bindParam(1, $idNotaCredito, PDO::PARAM_INT);
            $cmdNotaCredito->execute();
            $resultNotaCredito = $cmdNotaCredito->fetchObject();

            $cmDetalleNotaCredito = Database::getInstance()->getDb()->prepare("SELECT 
            d.idNotaCreditoDetalle,            
            c.Concepto,            
            (d.Monto/d.Cantidad) AS Precio,
            d.Cantidad,
            d.Monto AS Total,
            i.Nombre,
            i.Valor,
            i.Codigo
            FROM NotaCreditoDetalle AS d 
            INNER JOIN Concepto AS c ON d.idConcepto = c.idConcepto
            INNER JOIN Impuesto AS i ON i.IdImpuesto = c.IdImpuesto
            WHERE d.idNotaCredito  = ?");
            $cmDetalleNotaCredito->bindParam(1, $idNotaCredito, PDO::PARAM_INT);
            $cmDetalleNotaCredito->execute();
            $count = 0;

            $detalleNotaCredito = array();
            while ($row = $cmDetalleNotaCredito->fetch()) {
                $count++;
                array_push($detalleNotaCredito, array(
                    "Id" => $count,
                    "idNotaCreditoDetalle" => $row["idNotaCreditoDetalle"],
                    "Concepto" => $row["Concepto"],
                    "Precio" => $row["Precio"],
                    "Cantidad" => $row["Cantidad"],
                    "Total" => $row["Total"],
                    "Nombre" => $row["Nombre"],
                    "Valor" => $row["Valor"],
                    "Codigo" => $row["Codigo"],
                ));
                $cantidad = $row["Cantidad"];
                $valorImpuesto = $row['Valor'];
                $preciobruto = $row['Precio'] / (($valorImpuesto / 100.00) + 1);

                $opegravada +=  $valorImpuesto == 0 ? 0 : $cantidad * $preciobruto;
                $opeexogenerada += $valorImpuesto == 0 ? $cantidad * $preciobruto : 0;

                $totalsinimpuesto += $cantidad * $preciobruto;
                $impuesto += $cantidad  * ($preciobruto * ($valorImpuesto / 100.00));
            }

            $cmdEmpresa = Database::getInstance()->getDb()->prepare("SELECT 
            TOP 1 NumeroDocumento,
            NombreComercial,
            RazonSocial,
            Domicilio,
            Telefono,
            PaginaWeb,
            Email,
            UsuarioSol,
            ClaveSol
            FROM Empresa");
            $cmdEmpresa->execute();
            $resultEmpresa = $cmdEmpresa->fetchObject();

            array_push(
                $array,
                $resultNotaCredito,
                $detalleNotaCredito,
                $resultEmpresa,
                array(
                    "opgravada" => $opegravada,
                    "opexonerada" =>   $opeexogenerada,
                    "totalsinimpuesto" => $totalsinimpuesto,
                    "totalimpuesto" => $impuesto,
                    "totalconimpuesto" => $totalsinimpuesto + $impuesto,
                )
            );
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function registrarNotaCredito($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $codigoSerieNumeracion = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Serie_Numero(?)");
            $codigoSerieNumeracion->bindParam(1, $body["idTipoNotaCredito"], PDO::PARAM_STR);
            $codigoSerieNumeracion->execute();
            $serie_numeracion = explode("-", $codigoSerieNumeracion->fetchColumn());

            $cmdIngreso = Database::getInstance()->getDb()->prepare("INSERT INTO NotaCredito(
                idIngreso,
                idMotivoAnulacion,
                TipoComprobante,
                Serie,
                NumRecibo,
                Fecha,
                Hora
                )VALUES(?,?,?,?,?,GETDATE(),GETDATE())");
            $cmdIngreso->bindParam(1, $body["idIngreso"], PDO::PARAM_STR);
            $cmdIngreso->bindParam(2, $body["idMotivoNotaCredito"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(3, $body["idTipoNotaCredito"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(4, $serie_numeracion[0], PDO::PARAM_STR);
            $cmdIngreso->bindParam(5, $serie_numeracion[1], PDO::PARAM_STR);
            $cmdIngreso->execute();

            $idNotaCredito = Database::getInstance()->getDb()->lastInsertId();

            foreach ($body["detalleComprobante"] as $value) {
                $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO NotaCreditoDetalle(
                    idNotaCredito,
                    idConcepto,
                    Cantidad,
                    Monto
                    )VALUES(?,?,?,?)");
                $cmdDetalle->bindParam(1, $idNotaCredito, PDO::PARAM_INT);
                $cmdDetalle->bindParam(2, $value['idConcepto'], PDO::PARAM_INT);
                $cmdDetalle->bindParam(3, $value['Cantidad'], PDO::PARAM_INT);
                $cmdDetalle->bindParam(4, $value['Total'], PDO::PARAM_INT);
                $cmdDetalle->execute();
            }
            Database::getInstance()->getDb()->commit();
            return 'Insertado';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function CambiarEstadoSunatNotaCredito($idNotaCredito, $codigo, $descripcion, $hash)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE NotaCredito SET 
            Xmlsunat = ? , Xmldescripcion = ?, CodigoHash = ? WHERE idNotaCredito = ?");
            $comando->bindParam(1, $codigo, PDO::PARAM_STR);
            $comando->bindParam(2, $descripcion, PDO::PARAM_STR);
            $comando->bindParam(3, $hash, PDO::PARAM_STR);
            $comando->bindParam(4, $idNotaCredito, PDO::PARAM_STR);
            $comando->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
