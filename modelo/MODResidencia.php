<?php
/****************************************************************************************
*@package pXP
*@file MODResidencia.php
*@author  (ymedina)
*@date 15-07-2020 14:21:03
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 14:21:03    ymedina             Creacion    
  #
*****************************************************************************************/

class MODResidencia extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarResidencia(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_residencia_sel';
        $this->transaccion='SICO_RESI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario','id_funcionario','int4');
                
        //Definicion de la lista del resultado del query
		$this->captura('id_residencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('direccion','varchar');
		$this->captura('ciudad','varchar');
		$this->captura('telefono','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_funcionario','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarResidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_residencia_ime';
        $this->transaccion='SICO_RESI_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('direccion','direccion','varchar');
		$this->setParametro('ciudad','ciudad','varchar');
		$this->setParametro('telefono','telefono','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarResidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_residencia_ime';
        $this->transaccion='SICO_RESI_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_residencia','id_residencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('direccion','direccion','varchar');
		$this->setParametro('ciudad','ciudad','varchar');
		$this->setParametro('telefono','telefono','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarResidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_residencia_ime';
        $this->transaccion='SICO_RESI_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_residencia','id_residencia','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>