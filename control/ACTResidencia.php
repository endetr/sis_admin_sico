<?php
/****************************************************************************************
*@package pXP
*@file ACTResidencia.php
*@author  (ymedina)
*@date 15-07-2020 14:21:03
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 14:21:03    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTResidencia extends ACTbase{    
            
    function listarResidencia(){
		$this->objParam->defecto('ordenacion','id_residencia');

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (resi.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODResidencia','listarResidencia');
        } else{
        	$this->objFunc=$this->create('MODResidencia');
            
        	$this->res=$this->objFunc->listarResidencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarResidencia(){
        $this->objFunc=$this->create('MODResidencia');    
        if($this->objParam->insertar('id_residencia')){
            $this->res=$this->objFunc->insertarResidencia($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarResidencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarResidencia(){
        	$this->objFunc=$this->create('MODResidencia');    
        $this->res=$this->objFunc->eliminarResidencia($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>