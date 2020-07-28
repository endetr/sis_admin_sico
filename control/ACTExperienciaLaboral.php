<?php
/****************************************************************************************
*@package pXP
*@file ACTExperienciaLaboral.php
*@author  (ymedina)
*@date 15-07-2020 06:02:45
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 06:02:45    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTExperienciaLaboral extends ACTbase{    
            
    function listarExperienciaLaboral(){
		$this->objParam->defecto('ordenacion','id_experiencia');

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (explab.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODExperienciaLaboral','listarExperienciaLaboral');
        } else{
        	$this->objFunc=$this->create('MODExperienciaLaboral');
            
        	$this->res=$this->objFunc->listarExperienciaLaboral($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarExperienciaLaboral(){
        $this->objFunc=$this->create('MODExperienciaLaboral');    
        if($this->objParam->insertar('id_experiencia')){
            $this->res=$this->objFunc->insertarExperienciaLaboral($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarExperienciaLaboral($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarExperienciaLaboral(){
        	$this->objFunc=$this->create('MODExperienciaLaboral');    
        $this->res=$this->objFunc->eliminarExperienciaLaboral($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>