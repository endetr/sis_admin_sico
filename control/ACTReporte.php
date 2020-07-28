<?php
/**
 * @Package pxP
 * @file    ACTAlmacen.php
 * @author  Gonzalo Sarmiento
 * @date    21-09-2012
 * @descripcion Clase que recibe los parametros enviados por la vista para luego ser mandadas a la capa Modelo
 */
require_once (dirname(__FILE__) . '/../reportes/RFuncionario.php');

class ACTReporte extends ACTbase {

    function reporteFuncionario() {

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" idi.id_funcionario = ".$this->objParam->getParametro('id_funcionario'));
        }

        $this->objFunc=$this->create('MODIdioma');
        $idiomas = $this->objFunc->listarIdioma($this->objParam);

        $this->objFunc=$this->create('MODDocumentoFuncionario');
        $datosPersona = $this->objFunc->datosFuncionario($this->objParam);

        $this->objFunc=$this->create('MODEstudios');
        $datosEstudio = $this->objFunc->listarEstudios($this->objParam);

        $this->objFunc=$this->create('MODAllegado');
        $datosAllegados = $this->objFunc->listarAllegado($this->objParam);

        $this->objFunc=$this->create('MODExperienciaLaboral');
        $datosExperiencia = $this->objFunc->listarExperienciaLaboral($this->objParam);

        $this->objFunc=$this->create('MODFuncionarioCompetencia');
        $datosCompetencia = $this->objFunc->listarFuncionarioCompetencia($this->objParam);

        $this->objFunc=$this->create('MODResidencia');
        $datosResidencia = $this->objFunc->listarResidencia($this->objParam);

        $this->objFunc=$this->create('MODDocumentoFuncionario');
        $datosEstructura = $this->objFunc->getEstructuraFuncionario($this->objParam);


        /*$datosPersona->imprimirRespuesta($datosPersona-> generarMensajeJson());
            exit;*/

        //var_dump($resultRepExistencias->getDatos());exit;

        /*$dataSource = new DataSource();
        $resultData = $resultRepExistencias->getDatos();
        $lastNombreClasificacion = $resultData[0]['clasificacion'];
        $dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        $mainDataSet = array();
        $costoTotal = 0;
        foreach ($resultData as $row) {
            if ($row['clasificacion'] != $lastNombreClasificacion) {
                $costoTotal += $totalCostoClasificacion;
                $mainDataSet[] = array("nombreClasificacion" => $lastNombreClasificacion, "totalClasificacion" => $totalCostoClasificacion);
                $dataSourceClasificacion->setDataSet($dataSetClasificacion);
                $dataSourceClasificacion->putParameter('totalCosto', $totalCostoClasificacion);
                $dataSourceClasificacion->putParameter('nombreClasificacion', $lastNombreClasificacion);
                $dataSourceArray[] = $dataSourceClasificacion;

                $lastNombreClasificacion = $row['clasificacion'];
                $dataSourceClasificacion = new DataSource();
                $dataSetClasificacion = Array();
                $totalCostoClasificacion = 0;
            }
            $dataSetClasificacion[] = $row;
            $totalCostoClasificacion += $row['costo'];
        }
        $costoTotal += $totalCostoClasificacion;
        $mainDataSet[] = array("nombreClasificacion" => $lastNombreClasificacion, "totalClasificacion" => $totalCostoClasificacion);
        $dataSourceClasificacion->setDataSet($dataSetClasificacion);
        $dataSourceClasificacion->putParameter('totalCosto', $totalCostoClasificacion);
        $dataSourceClasificacion->putParameter('nombreClasificacion', $lastNombreClasificacion);
        $dataSourceArray[] = $dataSourceClasificacion;

        $dataSource->putParameter('clasificacionDataSources', $dataSourceArray);
        $dataSource->putParameter('costoTotal', $costoTotal);
        $dataSource->putParameter('fechaHasta', $fechaHasta);
        $dataSource->putParameter('almacen', $this->objParam->getParametro('almacen'));
        $dataSource->putParameter('mostrar_costos', $this->objParam->getParametro('mostrar_costos'));
        $dataSource->setDataSet($mainDataSet);

        $reporte = new RFuncionario();

        $reporte->setDataSource($dataSource);
        $nombreArchivo = 'Existencias.pdf';
        $reportWriter = new ReportWriter($reporte, dirname(__FILE__) . '/../../reportes_generados/' . $nombreArchivo);
        $reportWriter->writeReport(ReportWriter::PDF);*/

        $nombreArchivo = uniqid(md5(session_id()).'-REPCC') . '.pdf';
        $tamano = 'LETTER';
        $orientacion = 'P';
        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo','Curriculum');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos_idiomas',$idiomas->getDatos());
        $this->objParam->addParametro('datos_persona',$datosPersona->getDatos());
        $this->objParam->addParametro('datos_estudio',$datosEstudio->getDatos());
        $this->objParam->addParametro('datos_allegado',$datosAllegados->getDatos());
        $this->objParam->addParametro('datos_experiencia',$datosExperiencia->getDatos());
        $this->objParam->addParametro('datos_competencia',$datosCompetencia->getDatos());
        $this->objParam->addParametro('datos_residencia',$datosResidencia->getDatos());
        $this->objParam->addParametro('datos_estructura',$datosEstructura->getDatos());

        $reporte = new RFuncionario($this->objParam);
        $reporte->datosHeader($this->objParam);
        $reporte->generarReporte1($this->objParam);
        $reporte->output($reporte->url_archivo,'F');

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

}
?>
