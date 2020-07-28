<?php
/****************************************************************************************
*@package pXP
*@file MODAllegado.php
*@author  (ymedina)
*@date 15-07-2020 15:06:16
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                15-07-2020 15:06:16    ymedina             Creacion    
  #
*****************************************************************************************/

class MODAllegado extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarAllegado(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_allegado_sel';
        $this->transaccion='SICO_ALLEG_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario','id_funcionario','int4');
                
        //Definicion de la lista del resultado del query
		$this->captura('id_allegado','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('id_persona','int4');
		$this->captura('tipo_relacion','varchar');
		$this->captura('parentesco','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('funcionario','varchar');
        $this->captura('nombre_completo1','varchar');
        $this->captura('celular1','varchar');
        $this->captura('telefono1','varchar');
        $this->captura('direccion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarAllegado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_allegado_ime';
        $this->transaccion='SICO_ALLEG_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('tipo_relacion','tipo_relacion','varchar');
		$this->setParametro('parentesco','parentesco','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarAllegado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_allegado_ime';
        $this->transaccion='SICO_ALLEG_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_allegado','id_allegado','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('tipo_relacion','tipo_relacion','varchar');
		$this->setParametro('parentesco','parentesco','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarAllegado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_allegado_ime';
        $this->transaccion='SICO_ALLEG_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_allegado','id_allegado','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>