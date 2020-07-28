<?php
/****************************************************************************************
*@package pXP
*@file Allegado.php
*@author  (ymedina)
*@date 15-07-2020 15:06:16
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 15:06:16    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Allegado=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.Allegado.superclass.constructor.call(this,config);
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
                    name: 'id_allegado'
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
                filters:{pfiltro:'alleg.estado_reg',type:'string'},
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
                name: 'id_persona',
                fieldLabel: 'Personas',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_seguridad/control/Persona/listarPersona',
                    id: 'id_persona',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre_completo1',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_persona', 'nombre_completo1'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'p.nombre_completo1'}
                }),
                valueField: 'id_persona',
                displayField: 'nombre_completo1',
                gdisplayField: 'nombre_completo1',
                hiddenName: 'id_persona',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 100,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['nombre_completo1']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'p.nombre_completo1',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'tipo_relacion',
                fieldLabel: 'Tipo de Relación',
                allowBlank : false,
                triggerAction : 'all',
                lazyRender : true,
                mode : 'local',
                store : new Ext.data.ArrayStore({
                    fields : ['codigo', 'nombre'],
                    data : [['familiar', 'Carga Familiares, Conyugue, Hijos y Ascendientes'], ['emergencia', 'Notificaciones en Caso de Emergencia']]
                }),
                anchor : '80%',
                valueField : 'codigo',
                displayField : 'nombre',
                gwidth:100,
                renderer: function(value, p, record){
                    var aux;
                    switch (value) {
                        case 'familiar':
                            aux = 'Carga Familiares, Conyugue, Hijos y Ascendientes';
                            break;
                        case 'emergencia':
                            aux = 'Notificaciones en Caso de Emergencia';
                            break;
                        default:
                            aux = 'Otros';
                    }
                    return String.format('{0}', aux);
                }
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
                name: 'parentesco',
                fieldLabel: 'parentesco',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:15
            },
                type:'TextField',
                filters:{pfiltro:'alleg.parentesco',type:'string'},
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
                filters:{pfiltro:'alleg.fecha_reg',type:'date'},
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
                filters:{pfiltro:'alleg.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'alleg.usuario_ai',type:'string'},
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
                filters:{pfiltro:'alleg.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'allegado',
    ActSave:'../../sis_admin_sico/control/Allegado/insertarAllegado',
    ActDel:'../../sis_admin_sico/control/Allegado/eliminarAllegado',
    ActList:'../../sis_admin_sico/control/Allegado/listarAllegado',
    id_store:'id_allegado',
    fields: [
		{name:'id_allegado', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
        {name:'funcionario', type: 'string'},
		{name:'id_persona', type: 'numeric'},
        {name:'nombre_completo1', type: 'string'},
		{name:'tipo_relacion', type: 'string'},
		{name:'parentesco', type: 'string'},
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
        field: 'id_allegado',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onReloadPage:function(m){
        this.maestro=m;
        console.log(this.maestro);
        this.store.baseParams={id_funcionario: this.maestro.id_funcionario}
        this.load({params:{start:0, limit:this.tam_pag}})
    },
    loadValoresIniciales:function()
    {
        Phx.vista.Allegado.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);

    }
    }
)
</script>
        
        