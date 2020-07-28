<?php
/****************************************************************************************
*@package pXP
*@file Residencia.php
*@author  (ymedina)
*@date 15-07-2020 14:21:03
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 14:21:03    ymedina            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Residencia=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.Residencia.superclass.constructor.call(this,config);
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
                    name: 'id_residencia'
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
                filters:{pfiltro:'resi.estado_reg',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
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
        },
        {
            config:{
                name: 'direccion',
                fieldLabel: 'direccion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:200
            },
                type:'TextField',
                filters:{pfiltro:'resi.direccion',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'ciudad',
                fieldLabel: 'ciudad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:50
            },
                type:'TextField',
                filters:{pfiltro:'resi.ciudad',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'telefono',
                fieldLabel: 'telefono',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:30
            },
                type:'TextField',
                filters:{pfiltro:'resi.telefono',type:'string'},
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
                filters:{pfiltro:'resi.fecha_reg',type:'date'},
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
                filters:{pfiltro:'resi.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'resi.usuario_ai',type:'string'},
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
                filters:{pfiltro:'resi.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'residencia',
    ActSave:'../../sis_admin_sico/control/Residencia/insertarResidencia',
    ActDel:'../../sis_admin_sico/control/Residencia/eliminarResidencia',
    ActList:'../../sis_admin_sico/control/Residencia/listarResidencia',
    id_store:'id_residencia',
    fields: [
		{name:'id_residencia', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
        {name:'desc_funcionario', type: 'numeric'},
		{name:'direccion', type: 'string'},
		{name:'ciudad', type: 'string'},
		{name:'telefono', type: 'string'},
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
        field: 'id_residencia',
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
        Phx.vista.Residencia.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);

    }
    }
)
</script>
        
        