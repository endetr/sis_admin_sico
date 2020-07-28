<?php
/****************************************************************************************
*@package pXP
*@file MODEstudios.php
*@author  (ymedina)
*@date 15-07-2020 06:03:28
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 06:03:28    ymedina             Creacion    
  #
*****************************************************************************************/

class MODEstudios extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarEstudios(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_estudios_sel';
        $this->transaccion='SICO_ESTU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario','id_funcionario','int4');
                
        //Definicion de la lista del resultado del query
		$this->captura('id_estudio','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('nivel','varchar');
		$this->captura('institucion','varchar');
		$this->captura('localidad','varchar');
		$this->captura('fecha_inicio','date');
		$this->captura('fecha_fin','date');
		$this->captura('titulo','varchar');
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
            
    function insertarEstudios(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_estudios_ime';
        $this->transaccion='SICO_ESTU_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('nivel','nivel','varchar');
		$this->setParametro('institucion','institucion','varchar');
		$this->setParametro('localidad','localidad','varchar');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('titulo','titulo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarEstudios(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_estudios_ime';
        $this->transaccion='SICO_ESTU_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_estudio','id_estudio','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('nivel','nivel','varchar');
		$this->setParametro('institucion','institucion','varchar');
		$this->setParametro('localidad','localidad','varchar');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('titulo','titulo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarEstudios(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_estudios_ime';
        $this->transaccion='SICO_ESTU_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_estudio','id_estudio','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>