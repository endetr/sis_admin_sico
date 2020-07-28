--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_documento_funcionario_sel (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_documento_funcionario_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sico.tdocumento_funcionario'
 AUTOR:          (ymedina)
 FECHA:            23-07-2020 14:39:56
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                23-07-2020 14:39:56    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'sico.ft_documento_funcionario_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_DOCFUN_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina
     #FECHA:        23-07-2020 14:39:56
    ***********************************/

    IF (p_transaccion='SICO_DOCFUN_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        docfun.id_documento,
                        docfun.estado_reg,
                        docfun.id_funcionario,
                        docfun.tipo_documento,
                        docfun.nombre_archivo,
                        docfun.titulo,
                        docfun.url,
                        docfun.extension,
                        docfun.id_usuario_reg,
                        docfun.fecha_reg,
                        docfun.id_usuario_ai,
                        docfun.usuario_ai,
                        docfun.id_usuario_mod,
                        docfun.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        (vfun.desc_funcionario1)::character varying as desc_funcionario
                        FROM sico.tdocumento_funcionario docfun
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = docfun.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = docfun.id_usuario_mod
                        JOIN orga.vfuncionario vfun ON vfun.id_funcionario = docfun.id_funcionario
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'SICO_DOCFUN_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        ymedina
         #FECHA:        23-07-2020 14:39:56
        ***********************************/

    ELSIF (p_transaccion='SICO_DOCFUN_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_documento)
                         FROM sico.tdocumento_funcionario docfun
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = docfun.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = docfun.id_usuario_mod
                         WHERE ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'SICO_DATFUN_SEL'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 17:56:17
        ***********************************/

    ELSIF (p_transaccion='SICO_DATFUN_SEL') THEN

        BEGIN

            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT 	 FUNCIO.email_empresa,
                                     FUNCIO.interno,
                                     FUNCIO.fecha_ingreso,
                                     PERSON.nombre_completo2 AS desc_person,
                                     PERSON.ci,
                                     PERSON.num_documento,
                                     PERSON.telefono1,
                                     PERSON.celular1,
                                     PERSON.correo,
                                     FUNCIO.telefono_ofi,
                                     FUNCIO.antiguedad_anterior,
                                     PERSON2.estado_civil,
                                     PERSON2.genero,
                                     PERSON2.fecha_nacimiento,
                                     LUG.nombre as nombre_lugar,
                                     PERSON2.nacionalidad,
                                     PERSON2.discapacitado,
                                     PERSON2.carnet_discapacitado,
                                     cat.descripcion as profesion,
                                     FUNCIO.codigo_rciva,
                                     PERSON2.nombre_archivo_foto,
                                     FUNCIO.codigo
                              FROM orga.tfuncionario FUNCIO
                                   INNER JOIN SEGU.vpersona PERSON ON PERSON.id_persona = FUNCIO.id_persona
                                   INNER JOIN SEGU.tpersona PERSON2 ON PERSON2.id_persona = FUNCIO.id_persona
                                   LEFT JOIN param.tlugar LUG on LUG.id_lugar = PERSON2.id_lugar
                                   left join param.tcatalogo cat on cat.codigo = funcio.profesion
                              WHERE FUNCIO.id_funcionario = '||v_parametros.id_funcionario;

            --Definicion de la respuesta
            --v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'SICO_DATFUN_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 17:56:17
        ***********************************/

    ELSIF (p_transaccion='SICO_DATFUN_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros

            v_consulta:='SELECT COUNT(id_funcionario)
                         FROM orga.tfuncionario FUNCIO
                                   INNER JOIN SEGU.vpersona PERSON ON PERSON.id_persona = FUNCIO.id_persona
                                   INNER JOIN SEGU.tpersona PERSON2 ON PERSON2.id_persona = FUNCIO.id_persona
                                   LEFT JOIN param.tlugar LUG on LUG.id_lugar = PERSON2.id_lugar
                                   left join param.tcatalogo cat on cat.codigo = funcio.profesion
                              WHERE FUNCIO.id_funcionario = '||v_parametros.id_funcionario;

            --Definicion de la respuesta
            --v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    ELSE

        RAISE EXCEPTION 'Transaccion inexistente';

    END IF;

EXCEPTION

    WHEN OTHERS THEN
        v_resp='';
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
        RAISE EXCEPTION '%',v_resp;
END;
$body$
    LANGUAGE 'plpgsql'
    VOLATILE
    CALLED ON NULL INPUT
    SECURITY INVOKER
    PARALLEL UNSAFE
    COST 100;