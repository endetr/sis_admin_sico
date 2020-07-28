<?php
/****************************************************************************************
*@package pXP
*@file ACTAllegado.php
*@author  (ymedina)
*@date 15-07-2020 15:06:16
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 15:06:16    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTAllegado extends ACTbase{    
            
    function listarAllegado(){
		$this->objParam->defecto('ordenacion','id_allegado');

        if($this->objParam->getParametro('id_funcionario')!=''){
            $this->objParam->addFiltro(" (alleg.id_funcionario = ".$this->objParam->getParametro('id_funcionario')." )");
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAllegado','listarAllegado');
        } else{
        	$this->objFunc=$this->create('MODAllegado');
            
        	$this->res=$this->objFunc->listarAllegado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarAllegado(){
        $this->objFunc=$this->create('MODAllegado');    
        if($this->objParam->insertar('id_allegado')){
            $this->res=$this->objFunc->insertarAllegado($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarAllegado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarAllegado(){
        	$this->objFunc=$this->create('MODAllegado');    
        $this->res=$this->objFunc->eliminarAllegado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>