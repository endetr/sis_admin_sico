<?php
/****************************************************************************************
*@package pXP
*@file Idioma.php
*@author  (ymedina)
*@date 13-07-2020 02:39:28
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                13-07-2020 02:39:28    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Idioma=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.Idioma.superclass.constructor.call(this,config);
        this.init();
        //this.load({params:{start:0, limit:this.tam_pag}})
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_idioma'
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
                filters:{pfiltro:'idi.estado_reg',type:'string'},
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
            config: {
                name: 'idioma',
                fieldLabel: 'idioma',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_parametros/control/Lenguaje/listarLenguaje',
                    id: 'id_lenguaje',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_lenguaje', 'nombre'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'len.nombre',funcionario: 'si'}
                }),
                valueField: 'nombre',
                displayField: 'nombre',
                gdisplayField: 'nombre',
                hiddenName: 'nombre',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 100,
                maxLength:50,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['idioma']);
                },
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'len.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config : {
                name : 'habla',
                fieldLabel : 'habla',
                allowBlank : true,
                emptyText : 'Tipo...',
                typeAhead : true,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'local',
                anchor: '80%',
                gwidth: 100,
                maxLength:50,
                store : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            type : 'ComboBox',
            id_grupo : 0,
            filters : {
                type : 'list',
                pfiltro : 'habla',
                options : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            grid : true,
            form : true
        },
        {
            config : {
                name : 'lee',
                fieldLabel : 'lee',
                allowBlank : true,
                emptyText : 'Tipo...',
                typeAhead : true,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'local',
                anchor: '80%',
                gwidth: 100,
                maxLength:50,
                store : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            type : 'ComboBox',
            id_grupo : 0,
            filters : {
                type : 'list',
                pfiltro : 'lee',
                options : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            grid : true,
            form : true
        },
        {
            config : {
                name : 'escribe',
                fieldLabel : 'escribe',
                allowBlank : true,
                emptyText : 'Tipo...',
                typeAhead : true,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'local',
                anchor: '80%',
                gwidth: 100,
                maxLength:50,
                store : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            type : 'ComboBox',
            id_grupo : 0,
            filters : {
                type : 'list',
                pfiltro : 'escribe',
                options : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            grid : true,
            form : true
        },
        {
            config : {
                name : 'entiende',
                fieldLabel : 'entiende',
                allowBlank : true,
                emptyText : 'Tipo...',
                typeAhead : true,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'local',
                anchor: '80%',
                gwidth: 100,
                maxLength:50,
                store : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            type : 'ComboBox',
            id_grupo : 0,
            filters : {
                type : 'list',
                pfiltro : 'entiende',
                options : ['Perfectamente', 'Regular', 'Muy Poco']
            },
            grid : true,
            form : true
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
                filters:{pfiltro:'idi.fecha_reg',type:'date'},
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
                filters:{pfiltro:'idi.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'idi.usuario_ai',type:'string'},
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
                filters:{pfiltro:'idi.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'idioma',
    ActSave:'../../sis_admin_sico/control/Idioma/insertarIdioma',
    ActDel:'../../sis_admin_sico/control/Idioma/eliminarIdioma',
    ActList:'../../sis_admin_sico/control/Idioma/listarIdioma',
    id_store:'id_idioma',
    fields: [
		{name:'id_idioma', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
        {name:'funcionario', type: 'string'},
		{name:'idioma', type: 'string'},
		{name:'habla', type: 'string'},
		{name:'lee', type: 'string'},
		{name:'escribe', type: 'string'},
		{name:'entiende', type: 'string'},
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
        field: 'id_idioma',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        console.log(this.maestro);
        this.store.baseParams={id_funcionario: this.maestro.id_funcionario};
        this.Cmp.idioma.store.baseParams.id_funcionario = this.maestro.id_funcionario;
        this.load({params:{start:0, limit:this.tam_pag}})
    },
    loadValoresIniciales:function()
    {
        Phx.vista.Idioma.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);
        this.Cmp.idioma.store.baseParams.id_funcionario = this.maestro.id_funcionario;
    }
    }
)
</script>
        
        