<?php
/****************************************************************************************
 *@package pXP
 *@file gen-DocumentoFuncionario.php
 *@author  (ymedina)
 *@date 23-07-2020 14:39:56
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
#0                23-07-2020 14:39:56    ymedina            Creacion
#

 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.DocumentoFuncionario=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.DocumentoFuncionario.superclass.constructor.call(this,config);
                this.init();
                var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
                if(dataPadre){
                    this.onEnablePanel(this, dataPadre);
                }
                else
                {
                    this.bloquearMenus();
                };
                this.addButton('btnReporte', {
                    text : 'Exportar Documento',
                    iconCls : 'bballot',
                    disabled : false,
                    handler : this.BVerDocumento,
                    tooltip : '<b>Exportar Documento</b>'
                });
                //this.load({params:{start:0, limit:this.tam_pag}})
            },

            Atributos:[
                {
                    //configuracion del componente
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_documento'
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
                    filters:{pfiltro:'docfun.estado_reg',type:'string'},
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
                } ,
                {
                    config:{
                        name: 'tipo_documento',
                        fieldLabel: 'Tipo Documento',
                        allowBlank : false,
                        triggerAction : 'all',
                        lazyRender : true,
                        mode : 'local',
                        store : new Ext.data.ArrayStore({
                            fields : ['codigo', 'nombre'],
                            data : [['desempeno', 'Desempeño'], ['estudio', 'Estudio'], ['experiencia', 'Experiencia'], ['familia', 'Familia'], ['generales', 'Generales'], ['otros', 'Otros'], ['proyecto', 'Proyecto'], ['servicio', 'Servicio']]
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
                        name: 'nombre_archivo',
                        fieldLabel: 'nombre_archivo',
                        allowBlank: true,
                        inputType:'hidden',
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:150
                    },
                    type:'TextField',
                    filters:{pfiltro:'docfun.nombre_archivo',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'titulo',
                        fieldLabel: 'Detalle - Titulo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:350
                    },
                    type:'TextField',
                    filters:{pfiltro:'docfun.titulo',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    //configuracion del componente
                    config:{
                        fieldLabel: "Archivo",
                        gwidth: 130,
                        labelSeparator:'',
                        inputType:'file',
                        name: 'file_documento',
                        maxLength:150,
                        anchor:'100%',
                        validateValue:function(archivo){
                            var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
                            var extenciones = ['doc','pdf','docx','jpg','jpeg','bmp','gif','png','PDF','DOC','DOCX','xls','xlsx','XLS','XLSX','rar'];
                            if(extenciones.includes(extension)){
                                this.markInvalid('solo se admiten archivos WORD');
                                return false
                            }
                            else{
                                this.clearInvalid();
                                return true
                            }
                        }
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        name: 'url',
                        fieldLabel: 'url',
                        allowBlank: true,
                        inputType:'hidden',
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:200
                    },
                    type:'TextField',
                    hidden: true,
                    form:true
                },
                {
                    config:{
                        name: 'extension',
                        fieldLabel: 'extension',
                        allowBlank: true,
                        anchor: '80%',
                        inputType:'hidden',
                        gwidth: 100,
                        maxLength:5
                    },
                    type:'TextField',
                    hidden: true,
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
                    filters:{pfiltro:'docfun.fecha_reg',type:'date'},
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
                    filters:{pfiltro:'docfun.id_usuario_ai',type:'numeric'},
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
                    filters:{pfiltro:'docfun.usuario_ai',type:'string'},
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
                    filters:{pfiltro:'docfun.fecha_mod',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                }
            ],
            tam_pag:50,
            title:'documento funcionario',
            ActSave:'../../sis_admin_sico/control/DocumentoFuncionario/insertarDocumentoFuncionario',
            ActDel:'../../sis_admin_sico/control/DocumentoFuncionario/eliminarDocumentoFuncionario',
            ActList:'../../sis_admin_sico/control/DocumentoFuncionario/listarDocumentoFuncionario',
            fileUpload:true,
            id_store:'id_documento',
            fields: [
                {name:'id_documento', type: 'numeric'},
                {name:'estado_reg', type: 'string'},
                {name:'id_funcionario', type: 'numeric'},
                {name:'desc_funcionario', type: 'string'},
                {name:'tipo_documento', type: 'string'},
                {name:'nombre_archivo', type: 'string'},
                {name:'titulo', type: 'string'},
                {name:'url', type: 'string'},
                {name:'extension', type: 'string'},
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
                field: 'id_documento',
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
                Phx.vista.DocumentoFuncionario.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_funcionario').setValue(this.maestro.id_funcionario);

            },
            BVerDocumento : function() {
                //var rec = this.sm.getSelected();
                var record=this.sm.getSelected().data;
                console.log('antes ', record);
                var data = "id=" + record['id_documento'];
                data += "&extension=" + record['extension'];
                data += "&sistema=sis_admin_sico";
                data += "&clase=Documento";
                data += "&url="+record['url'];
                console.log('yamkk  ', data);
                //return  String.format('{0}',"<div style='text-align:center'><a target=_blank href = '../../../lib/lib_control/CTOpenFile.php?"+ data+"' align='center' width='70' height='70'>Abrir</a></div>");
                window.open('../../../lib/lib_control/CTOpenFile.php?' + data);
                //window.open('../../../lib/lib_control/CTOpenFile.php?' + 'id=386999&extension=docx&sistema=sis_workflow&clase=DocumentoWf&url=./../../../uploaded_files/sis_workflow/DocumentoWf/685aa0a2beb95f5c54d97077c1af0681.docx');
                      //                                                      id=35&extension=&sistema=sis_admin_sico&clase=Documento&url=./../../../uploaded_files/sis_admin_sico/DocumentoFuncionario/b25f36e5d7d70699e41dd54f2a0fcd3d_v.docx
            },

        }
    )
</script>