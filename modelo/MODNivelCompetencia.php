<?php
/****************************************************************************************
*@package pXP
*@file MODNivelCompetencia.php
*@author  (ymedina)
*@date 14-07-2020 15:33:35
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                14-07-2020 15:33:35    ymedina             Creacion    
  #
*****************************************************************************************/

class MODNivelCompetencia extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarNivelCompetencia(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_nivel_competencia_sel';
        $this->transaccion='SICO_NIVCOMP_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_nivel','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_competencia','int4');
		$this->captura('id_atributo','int4');
		$this->captura('nivel','int2');
		$this->captura('tipo','varchar');
		$this->captura('atributo','varchar');
		$this->captura('horas','float8');
		$this->captura('estado','bpchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('nombre','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarNivelCompetencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_nivel_competencia_ime';
        $this->transaccion='SICO_NIVCOMP_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('id_atributo','id_atributo','int4');
		$this->setParametro('nivel','nivel','int2');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('atributo','atributo','varchar');
		$this->setParametro('horas','horas','float8');
		$this->setParametro('estado','estado','bpchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarNivelCompetencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_nivel_competencia_ime';
        $this->transaccion='SICO_NIVCOMP_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_nivel','id_nivel','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('id_atributo','id_atributo','int4');
		$this->setParametro('nivel','nivel','int2');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('atributo','atributo','varchar');
		$this->setParametro('horas','horas','float8');
		$this->setParametro('estado','estado','bpchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarNivelCompetencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_nivel_competencia_ime';
        $this->transaccion='SICO_NIVCOMP_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_nivel','id_nivel','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>