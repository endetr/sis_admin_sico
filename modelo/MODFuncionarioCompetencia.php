<?php
/****************************************************************************************
*@package pXP
*@file MODFuncionarioCompetencia.php
*@author  (ymedina)
*@date 14-07-2020 20:40:32
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                14-07-2020 20:40:32    ymedina             Creacion    
  #
*****************************************************************************************/

class MODFuncionarioCompetencia extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarFuncionarioCompetencia(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_funcionario_competencia_sel';
        $this->transaccion='SICO_FUNCOMP_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario','id_funcionario','int4');
                
        //Definicion de la lista del resultado del query
        $this->captura('id_fun_comp','int4');
        $this->captura('id_funcionario','int4');
        $this->captura('id_competencia','int4');
        $this->captura('nombre_competencia','varchar');
        $this->captura('nivel','int2');
        $this->captura('id_usuario_reg','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('id_usuario_ai','int4');
        $this->captura('usuario_ai','varchar');
        $this->captura('id_usuario_mod','int4');
        $this->captura('fecha_mod','timestamp');
        $this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('nombre_funcionario','varchar');
        $this->captura('gestion','int4');
        $this->captura('nivel_desc','varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarFuncionarioCompetencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_funcionario_competencia_ime';
        $this->transaccion='SICO_FUNCOMP_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('nivel','nivel','int2');
		$this->setParametro('id_atributo','id_atributo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarFuncionarioCompetencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_funcionario_competencia_ime';
        $this->transaccion='SICO_FUNCOMP_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_fun_comp','id_fun_comp','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('nivel','nivel','int2');
		$this->setParametro('id_atributo','id_atributo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarFuncionarioCompetencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_funcionario_competencia_ime';
        $this->transaccion='SICO_FUNCOMP_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_fun_comp','id_fun_comp','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>