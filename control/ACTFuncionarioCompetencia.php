<?php
/****************************************************************************************
*@package pXP
*@file ACTFuncionarioCompetencia.php
*@author  (ymedina)
*@date 14-07-2020 20:40:32
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                14-07-2020 20:40:32    ymedina             Creacion    
  #
*****************************************************************************************/

class ACTFuncionarioCompetencia extends ACTbase{    
            
    function listarFuncionarioCompetencia(){
		$this->objParam->defecto('ordenacion','id_fun_comp');

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODFuncionarioCompetencia','listarFuncionarioCompetencia');
        } else{
        	$this->objFunc=$this->create('MODFuncionarioCompetencia');
            
        	$this->res=$this->objFunc->listarFuncionarioCompetencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarFuncionarioCompetencia(){
        $this->objFunc=$this->create('MODFuncionarioCompetencia');    
        if($this->objParam->insertar('id_fun_comp')){
            $this->res=$this->objFunc->insertarFuncionarioCompetencia($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarFuncionarioCompetencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarFuncionarioCompetencia(){
        	$this->objFunc=$this->create('MODFuncionarioCompetencia');    
        $this->res=$this->objFunc->eliminarFuncionarioCompetencia($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>