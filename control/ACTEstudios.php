<?php
/****************************************************************************************
*@package pXP
*@file ACTEstudios.php
*@author  (ymedina)
*@date 15-07-2020 06:03:28
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 06:03:28    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTEstudios extends ACTbase{    
            
    function listarEstudios(){
		$this->objParam->defecto('ordenacion','id_estudio');

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (estu.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEstudios','listarEstudios');
        } else{
        	$this->objFunc=$this->create('MODEstudios');
            
        	$this->res=$this->objFunc->listarEstudios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarEstudios(){
        $this->objFunc=$this->create('MODEstudios');    
        if($this->objParam->insertar('id_estudio')){
            $this->res=$this->objFunc->insertarEstudios($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarEstudios($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarEstudios(){
        	$this->objFunc=$this->create('MODEstudios');    
        $this->res=$this->objFunc->eliminarEstudios($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>