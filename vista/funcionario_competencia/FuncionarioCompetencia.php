<?php
/****************************************************************************************
*@package pXP
*@file FuncionarioCompetencia.php
*@author  (ymedina)
*@date 14-07-2020 20:40:32
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                14-07-2020 20:40:32    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.FuncionarioCompetencia=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.FuncionarioCompetencia.superclass.constructor.call(this,config);
        this.init();
        this.iniciarEventos();
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
    iniciarEventos : function () {
        this.Cmp.id_competencia.on('select',function(c,r,i){
            this.Cmp.nivel.store.baseParams.id_competencia = r.data.id_competencia;
        },this);
        this.Cmp.id_gestion.on('select',function(c,r,i){
            this.Cmp.id_competencia.store.baseParams.id_gestion = r.data.id_gestion;
        },this);

    },
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_fun_comp'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                name:'id_funcionario',
                origen:'FUNCIONARIO',
                fieldLabel:'Funcionario',
                allowBlank:true,
                hidden: true,
                gwidth:200,
                valueField: 'id_funcionario',
                gdisplayField: 'desc_funcionario',
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
            grid:true,
            form:true
        } ,
        {
            config: {
                name: 'id_gestion',
                fieldLabel: 'Gestion',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_parametros/control/Gestion/listarGestion',
                    id: 'id_gestion',
                    root: 'datos',
                    sortInfo: {
                        field: 'gestion',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_gestion', 'gestion'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'gestion'}
                }),
                valueField: 'id_gestion',
                displayField: 'gestion',
                gdisplayField: 'gestion',
                hiddenName: 'id_gestion',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['gestion']);
                },
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'gestion',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_competencia',
                fieldLabel: 'competencias',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_formacion/control/Competencia/listarCompetencia',
                    id: 'id_competencia',
                    root: 'datos',
                    sortInfo: {
                        field: 'competencia',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_competencia', 'competencia','tipo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'c.competencia'}
                }),
                valueField: 'id_competencia',
                displayField: 'competencia',
                gdisplayField: 'competencia',
                hiddenName: 'id_competencia',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_competencia']);
                },
                tpl: new Ext.XTemplate([
                    '<tpl for=".">',
                    '<div class="x-combo-list-item">',
                    '<p><b>Competencia:</b><span style="color: green; font-weight:bold;"> {competencia}</span></p></p>',
                    '<p><b>Id:</b> <span style="color: blue; font-weight:bold;">{tipo}</span></p>',
                    '</div></tpl>'
                ]),
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'c.competencia',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'nivel',
                fieldLabel: 'nivel',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_formacion/control/CompetenciaNivel/listarCompetenciaNivel',
                    id: 'id_competencia_nivel',
                    root: 'datos',
                    sortInfo: {
                        field: 'nivel',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_competencia_nivel', 'nivel'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'comniv.nivel'}
                }),
                valueField: 'id_competencia_nivel',
                displayField: 'nivel',
                gdisplayField: 'nivel',
                hiddenName: 'id_competencia_nivel',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nivel_desc']);
                },
                listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
                    }
                },
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'comniv.nivel',type: 'string'},
            grid: true,
            form: true
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
                filters:{pfiltro:'funcomp.fecha_reg',type:'date'},
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
                filters:{pfiltro:'funcomp.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'funcomp.usuario_ai',type:'string'},
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
                filters:{pfiltro:'funcomp.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'funcionario competencia',
    ActSave:'../../sis_admin_sico/control/FuncionarioCompetencia/insertarFuncionarioCompetencia',
    ActDel:'../../sis_admin_sico/control/FuncionarioCompetencia/eliminarFuncionarioCompetencia',
    ActList:'../../sis_admin_sico/control/FuncionarioCompetencia/listarFuncionarioCompetencia',
    id_store:'id_fun_comp',
    fields: [
		{name:'id_fun_comp', type: 'numeric'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'id_competencia', type: 'numeric'},
        {name:'nombre_competencia', type: 'string'},
		{name:'nivel', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'gestion', type: 'numeric'},
        {name:'nivel_desc', type: 'varchar'},
        
    ],
    sortInfo:{
        field: 'id_fun_comp',
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
        Phx.vista.FuncionarioCompetencia.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);

    },
    }
)
</script>
        
        