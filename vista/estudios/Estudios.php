<?php
/****************************************************************************************
*@package pXP
*@file Estudios.php
*@author  (ymedina)
*@date 15-07-2020 06:03:28
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 06:03:28    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Estudios=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.Estudios.superclass.constructor.call(this,config);
        this.init();
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        }
        else
        {
            this.bloquearMenus();
        }
        //this.load({params:{start:0, limit:this.tam_pag}})
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_estudio'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:10
            },
                type:'TextField',
                filters:{pfiltro:'estu.estado_reg',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name:'id_funcionario',
                hiddenName: 'id_funcionario',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'id_funcionario',
                allowBlank:false,
                hidden: true,
                gwidth: 100,
                anchor: '80%',
                valueField: 'id_funcionario',
                gdisplayField: 'funcionario',
                baseParams: { es_combo_solicitud : 'si' },
                renderer:function(value, p, record){return String.format('{0}', record.data['funcionario']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario2',type:'string'},
            bottom_filter:true,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'nivel',
                fieldLabel: 'nivel',
                allowBlank : false,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'local',
                store : new Ext.data.ArrayStore({
                    fields : ['codigo', 'nombre'],
                    data : [['primario', 'Primario'], ['secundario', 'Secundario'], ['universitario', 'Universitario'], ['certificado', 'Certificado'], ['comercial', 'Comercial'], ['diplomado', 'Diplomado'], ['licenciatura', 'Licenciatura'], ['maestria', 'Maestría'], ['postgrado', 'Postgrado'], ['otros', ' Otros']]
                }),
                anchor: '80%',
                gwidth: 100,
                maxLength:30,
                valueField : 'codigo',
                displayField : 'nombre'
            },
            type:'ComboBox',
            filters:{pfiltro:'tipflo.tipo_relacion',type:'string'},
            id_grupo:1,
            bottom_filter: true,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'institucion',
                fieldLabel: 'institucion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:100
            },
                type:'TextField',
                filters:{pfiltro:'estu.institucion',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'localidad',
                fieldLabel: 'localidad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:50
            },
                type:'TextField',
                filters:{pfiltro:'estu.localidad',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'fecha_inicio',
                fieldLabel: 'fecha_inicio',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
                type:'DateField',
                filters:{pfiltro:'estu.fecha_inicio',type:'date'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'fecha_fin',
                fieldLabel: 'fecha_fin',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
                type:'DateField',
                filters:{pfiltro:'estu.fecha_fin',type:'date'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'titulo',
                fieldLabel: 'titulo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:100
            },
                type:'TextField',
                filters:{pfiltro:'estu.titulo',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'usr_reg',
                fieldLabel: 'Creado por',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'usu1.cuenta',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'fecha_reg',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'estu.fecha_reg',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'id_usuario_ai',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'estu.id_usuario_ai',type:'numeric'},
                id_grupo:1,
                grid:false,
                form:false
		},
        {
            config:{
                name: 'usuario_ai',
                fieldLabel: 'Funcionaro AI',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:300
            },
                type:'TextField',
                filters:{pfiltro:'estu.usuario_ai',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'usr_mod',
                fieldLabel: 'Modificado por',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'usu2.cuenta',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'fecha_mod',
                fieldLabel: 'Fecha Modif.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'estu.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'estudios',
    ActSave:'../../sis_admin_sico/control/Estudios/insertarEstudios',
    ActDel:'../../sis_admin_sico/control/Estudios/eliminarEstudios',
    ActList:'../../sis_admin_sico/control/Estudios/listarEstudios',
    id_store:'id_estudio',
    fields: [
		{name:'id_estudio', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
        {name:'funcionario', type: 'string'},
		{name:'nivel', type: 'string'},
		{name:'institucion', type: 'string'},
		{name:'localidad', type: 'string'},
		{name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'titulo', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        
    ],
    sortInfo:{
        field: 'id_estudio',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        this.store.baseParams={id_funcionario: this.maestro.id_funcionario}
        this.load({params:{start:0, limit:this.tam_pag}})
    },
    loadValoresIniciales:function()
    {
        Phx.vista.Estudios.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);

    }
    }
)
</script>
        
        