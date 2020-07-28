<?php
/****************************************************************************************
 *@package pXP
 *@file MODDocumentoFuncionario.php
 *@author  (ymedina)
 *@date 15-07-2020 17:56:17
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
#0                15-07-2020 17:56:17    ymedina             Creacion
#
 *****************************************************************************************/

class MODDocumentoFuncionario extends MODbase{

    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }

    function listarDocumentoFuncionario(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sico.ft_documento_funcionario_sel';
        $this->transaccion='SICO_DOCFUN_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_documento','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('id_funcionario','int4');
        $this->captura('tipo_documento','varchar');
        $this->captura('nombre_archivo','varchar');
        $this->captura('titulo','varchar');
        $this->captura('url','varchar');
        $this->captura('extension','varchar');
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

    function insertarDocumentoFuncionario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_documento_funcionario_ime';
        $this->transaccion='SICO_DOCFUN_INS';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('tipo_documento','tipo_documento','varchar');
        $this->setParametro('nombre_archivo','nombre_archivo','varchar');
        $this->setParametro('titulo','titulo','varchar');
        $this->setParametro('url','url','varchar');
        $this->setParametro('extension','extension','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function modificarDocumentoFuncionario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_documento_funcionario_ime';
        $this->transaccion='SICO_DOCFUN_MOD';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_documento','id_documento','int4');
        $this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('id_funcionario','id_funcionario','int4');
        $this->setParametro('tipo_documento','tipo_documento','varchar');
        $this->setParametro('nombre_archivo','nombre_archivo','varchar');
        $this->setParametro('titulo','titulo','varchar');
        $this->setParametro('url','url','varchar');
        $this->setParametro('extension','extension','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function eliminarDocumentoFuncionario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_documento_funcionario_ime';
        $this->transaccion='SICO_DOCFUN_ELI';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_documento','id_documento','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function subirPlantilla(){


        $cone = new conexion();
        $link = $cone->conectarpdo();
        $copiado = false;
        try {

            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->beginTransaction();

            //var_dump('nada ', $this->arregloFiles['file_documento']['name']); exit;
            $nombre_archivo = $this->arregloFiles['file_documento']['name'];
            $tipo_carpeta = $this->objParam->getParametro('tipo_documento');
            $file_extencion = substr($nombre_archivo, strrpos($nombre_archivo, '.')+1);

            if ($nombre_archivo == "") {
                throw new Exception("El archivo no puede estar vacio");
            }

            $this->procedimiento='sico.ft_documento_funcionario_ime';
            $this->transaccion='SICO_DOCFUN_RUT';
            $this->tipo_procedimiento='IME';

            //var_dump('nada ', $this->objParam->getParametro('tipo_documento')); exit;

            //validar que no sea un arhvio en blanco
            $file_name = $this->getFileName2('file_documento', 'id_documento', $tipo_carpeta,'');

            //manda como parametro la url completa del archivo
            $this->aParam->addParametro('ruta_archivo', $file_name[2]);
            $this->arreglo['ruta_archivo'] = $file_name[2];
            $this->setParametro('ruta_archivo','ruta_archivo','varchar');

            $this->aParam->addParametro('nombre_archivos',  $nombre_archivo);
            $this->arreglo['nombre_archivos'] =  $nombre_archivo;
            $this->setParametro('nombre_archivos','nombre_archivos','varchar');

            $this->aParam->addParametro('file_extencion',  $file_extencion);
            $this->arreglo['file_extencion'] =  $file_extencion;
            $this->setParametro('file_extencion','file_extencion','varchar');


            //Define los parametros para la funcion
            $this->setParametro('id_documento','id_documento','integer');


            //Ejecuta la instruccion
            $this->armarConsulta();
            $stmt = $link->prepare($this->consulta);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);


            if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                throw new Exception("Error al ejecutar en la bd", 3);
            }



            if($resp_procedimiento['tipo_respuesta'] == 'EXITO'){

                //revisamos si ya existe el archivo la verison anterior sera mayor a cero
                $respuesta = $resp_procedimiento['datos'];
                //var_dump($respuesta);


                //cipiamos el nuevo archivo
                //function setFile($nombre, $variable_id, $blank = true, $tamano = '', $tipo_archivo = null, $folder = '',$subfijo=''){
                $this->setFile('file_documento','id_documento', false,100000 ,array('doc','pdf','docx','jpg','jpeg','bmp','gif','png','PDF','DOC','DOCX','xls','xlsx','XLS','XLSX','rar'), $tipo_carpeta);
            }

            $link->commit();
            $this->respuesta=new Mensaje();
            $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            $this->respuesta->setDatos($respuesta);

        }
        catch (Exception $e) {


            $link->rollBack();


            $this->respuesta=new Mensaje();
            if ($e->getCode() == 3) {//es un error de un procedimiento almacenado de pxp
                $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            } else if ($e->getCode() == 2) {//es un error en bd de una consulta
                $this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
            } else {//es un error lanzado con throw exception
                throw new Exception($e->getMessage(), 2);
            }
        }

        return $this->respuesta;

    }

    function datosFuncionario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_documento_funcionario_sel';// nombre procedimiento almacenado
        $this->transaccion='SICO_DATFUN_SEL';//nombre de la transaccion
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario','id_funcionario','int4');

        $this->captura('email_empresa','varchar');
        $this->captura('interno','varchar');
        $this->captura('fecha_ingreso','date');
        $this->captura('desc_person','text');
        $this->captura('ci','varchar');
        $this->captura('num_documento','integer');
        $this->captura('telefono1','varchar');
        $this->captura('celular1','varchar');
        $this->captura('correo','varchar');
        $this->captura('telefono_ofi','varchar');
        $this->captura('antiguedad_anterior','integer');
        $this->captura('estado_civil','varchar');
        $this->captura('genero','varchar');
        $this->captura('fecha_nacimiento','date');
        $this->captura('nombre_lugar','varchar');
        $this->captura('nacionalidad','varchar');
        $this->captura('discapacitado','varchar');
        $this->captura('carnet_discapacitado','varchar');
        $this->captura('profesion','varchar');
        $this->captura('codigo_rciva','varchar');
        $this->captura('nombre_archivo_foto','text');
        $this->captura('codigo','varchar');

        //Ejecuta la funcion
        $this->armarConsulta();
        //echo $this->getConsulta(); exit;
        $this->ejecutarConsulta();
        return $this->respuesta;
    }

    function getEstructuraFuncionario(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sico.ft_documento_funcionario_ime';
        $this->transaccion='SICO_DOCFUN_ESTR';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_funcionario','id_funcionario','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        //var_dump($this->respuesta);
        return $this->respuesta;
    }


}
?>