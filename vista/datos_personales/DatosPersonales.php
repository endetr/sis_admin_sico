<?php
/**
 *@package pXP
 *@file gen-SistemaDist.php
 *@author  (fprudencio)
 *@date 20-09-2011 10:22:05
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.DatFuncionario = {
        require:'../../../sis_admin_sico/vista/datos_personales/Funcionario.php',
        requireclase:'Phx.vista.funcionario',
        title:'Funcionario',
        constructor: function(config) {
            Phx.vista.DatFuncionario.superclass.constructor.call(this,config);
        },
        bedit:false,
        bnew:false,
        bdel:false,
        bsave:false,
        tabsouth: [{
            url: '../../../sis_admin_sico/vista/idioma/Idioma.php',
            title: '<span style="color: #008000;" ><b>Idioma</b></span>',
            height: '40%',
            cls: 'Idioma',
            params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
         },
         {
             url: '../../../sis_admin_sico/vista/estudios/Estudios.php',
             title: '<span style="color: #008000;" ><b>Estudios</b></span>',
             height: '40%',
             cls: 'Estudios',
             params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
         },
        {
            url: '../../../sis_admin_sico/vista/allegado/Allegado.php',
            title: '<span style="color: #008000;" ><b>Allegado</b></span>',
            height: '40%',
            cls: 'Allegado',
            params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
        },
        {
            url: '../../../sis_admin_sico/vista/residencia/Residencia.php',
            title: '<span style="color: #008000;" ><b>Residencia</b></span>',
            height: '40%',
            cls: 'Residencia',
            params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
        },
         {
             url: '../../../sis_admin_sico/vista/experiencia_laboral/ExperienciaLaboral.php',
             title: '<span style="color: #008000;" ><b>Experiencia Laboral</b></span>',
             height: '40%',
             cls: 'ExperienciaLaboral',
             params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
         },
         {
            url: '../../../sis_admin_sico/vista/funcionario_competencia/FuncionarioCompetencia.php',
            title: '<span style="color: #008000;" ><b>Competencias</b></span>',
            height: '40%',
            cls: 'FuncionarioCompetencia',
            params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
         },
        {
            url: '../../../sis_admin_sico/vista/documento_funcionario/DocumentoFuncionario.php',
            title: '<span style="color: #008000;" ><b>Documentos</b></span>',
            height: '40%',
            cls: 'DocumentoFuncionario',
            params: { nombre_tabla: 'orga.tfuncionario', tabla_id: 'id_funcionario'}
        }],
        EnableSelect : function (n, extra) {
            var miExtra = {codigos_tipo_relacion:''};
            if (extra != null && typeof extra === 'object') {
                miExtra = Ext.apply(extra, miExtra)
            }
            Phx.vista.DatFuncionario.superclass.EnableSelect.call(this,n,miExtra);
        }
    };
</script>