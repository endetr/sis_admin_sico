<?php
/****************************************************************************************
*@package pXP
*@file MODExperienciaLaboral.php
*@author  (ymedina)
*@date 15-07-2020 06:02:45
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 06:02:45    ymedina             Creacion    
  #
*****************************************************************************************/

class MODExperienciaLaboral extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarExperienciaLaboral(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_experiencia_laboral_sel';
        $this->transaccion='SICO_EXPLAB_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario','id_funcionario','int4');
                
        //Definicion de la lista del resultado del query
		$this->captura('id_experiencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('empresa','varchar');
		$this->captura('cargo','varchar');
		$this->captura('localidad','varchar');
		$this->captura('fecha_inicio','date');
		$this->captura('fecha_fin','date');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('funcionario','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarExperienciaLaboral(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_experiencia_laboral_ime';
        $this->transaccion='SICO_EXPLAB_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('empresa','empresa','varchar');
		$this->setParametro('cargo','cargo','varchar');
		$this->setParametro('localidad','localidad','varchar');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_fin','fecha_fin','date');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarExperienciaLaboral(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_experiencia_laboral_ime';
        $this->transaccion='SICO_EXPLAB_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_experiencia','id_experiencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('empresa','empresa','varchar');
		$this->setParametro('cargo','cargo','varchar');
		$this->setParametro('localidad','localidad','varchar');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_fin','fecha_fin','date');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarExperienciaLaboral(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_experiencia_laboral_ime';
        $this->transaccion='SICO_EXPLAB_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_experiencia','id_experiencia','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>