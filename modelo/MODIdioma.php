<?php
/****************************************************************************************
*@package pXP
*@file MODIdioma.php
*@author  (ymedina)
*@date 13-07-2020 02:39:28
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                13-07-2020 02:39:28    ymedina             Creacion    
  #
*****************************************************************************************/

class MODIdioma extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarIdioma(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_idioma_sel';
        $this->transaccion='SICO_IDI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('reporte','reporte','varchar');
                
        //Definicion de la lista del resultado del query
		$this->captura('id_idioma','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('idioma','varchar');
		$this->captura('habla','varchar');
		$this->captura('lee','varchar');
		$this->captura('escribe','varchar');
		$this->captura('entiende','varchar');
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
        //var_dump($this->respuesta);
        return $this->respuesta;
    }
            
    function insertarIdioma(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_idioma_ime';
        $this->transaccion='SICO_IDI_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('idioma','idioma','varchar');
		$this->setParametro('habla','habla','varchar');
		$this->setParametro('lee','lee','varchar');
		$this->setParametro('escribe','escribe','varchar');
		$this->setParametro('entiende','entiende','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarIdioma(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_idioma_ime';
        $this->transaccion='SICO_IDI_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_idioma','id_idioma','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('idioma','idioma','varchar');
		$this->setParametro('habla','habla','varchar');
		$this->setParametro('lee','lee','varchar');
		$this->setParametro('escribe','escribe','varchar');
		$this->setParametro('entiende','entiende','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarIdioma(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_idioma_ime';
        $this->transaccion='SICO_IDI_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_idioma','id_idioma','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>