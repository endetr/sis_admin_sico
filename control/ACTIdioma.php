<?php
/****************************************************************************************
*@package pXP
*@file ACTIdioma.php
*@author  (ymedina)
*@date 13-07-2020 02:39:28
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                13-07-2020 02:39:28    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTIdioma extends ACTbase{    
            
    function listarIdioma(){
		$this->objParam->defecto('ordenacion','id_idioma');

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (idi.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODIdioma','listarIdioma');
        } else{
        	$this->objFunc=$this->create('MODIdioma');
            
        	$this->res=$this->objFunc->listarIdioma($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarIdioma(){
        $this->objFunc=$this->create('MODIdioma');    
        if($this->objParam->insertar('id_idioma')){
            $this->res=$this->objFunc->insertarIdioma($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarIdioma($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarIdioma(){
        	$this->objFunc=$this->create('MODIdioma');    
        $this->res=$this->objFunc->eliminarIdioma($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>