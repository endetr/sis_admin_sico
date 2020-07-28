<?php
/****************************************************************************************
*@package pXP
*@file ACTDocumentoFuncionario.php
*@author  (ymedina)
*@date 15-07-2020 17:56:17
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 17:56:17    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTDocumentoFuncionario extends ACTbase{    
            
    function listarDocumentoFuncionario(){
		$this->objParam->defecto('ordenacion','id_documento');

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (docfun.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODDocumentoFuncionario','listarDocumentoFuncionario');
        } else{
        	$this->objFunc=$this->create('MODDocumentoFuncionario');
            
        	$this->res=$this->objFunc->listarDocumentoFuncionario($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarDocumentoFuncionario(){
        $this->objFunc=$this->create('MODDocumentoFuncionario');
        if($this->objParam->insertar('id_documento')){
            $this->res=$this->objFunc->insertarDocumentoFuncionario($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarDocumentoFuncionario($this->objParam);
        }

        if($this->res->getTipo()=='ERROR'){
            $this->res->imprimirRespuesta($this->res-> generarMensajeJson());
            exit;
        }

        $id_documento = $this->res->getDatos()['id_documento'];
        //var_dump('JEJE', $id_documento); exit;
        $this->objParam->addParametro('id_documento', $id_documento);

        $this->objFunc=$this->create('MODDocumentoFuncionario');
        $this->res=$this->objFunc->subirPlantilla($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function subirPlantilla(){
        $this->objFunc=$this->create('MODDocumentoFuncionario');
        $this->res=$this->objFunc->subirPlantilla($this->objParam);

        /*$this->objFunSeguridad=$this->create('MODDocumento');
        $this->res=$this->objFunSeguridad->subirPlantilla($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());*/
    }
                        
    function eliminarDocumentoFuncionario(){
        	$this->objFunc=$this->create('MODDocumentoFuncionario');    
        $this->res=$this->objFunc->eliminarDocumentoFuncionario($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteFuncionario() {

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (idi.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }
        $this->objFunc=$this->create('MODIdioma');
        $idiomas = $this->objFunc->listarIdioma($this->objParam);


        $this->objFunc = $this->create('MODReporte');
        $resultRepExistencias = $this->objFunc->listarItemsPorAlmacenFecha($this->objParam);

        if($resultRepExistencias->getTipo()=='ERROR'){
            $resultRepExistencias->imprimirRespuesta($resultRepExistencias-> generarMensajeJson());
            exit;
        }

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
        $this->objParam->addParametro('titulo_archivo','holas');
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
        $this->objParam->addParametro('datos_proyecto',$idiomas->getDatos());

        $reporte = new REjecucionCC($this->objParam);
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