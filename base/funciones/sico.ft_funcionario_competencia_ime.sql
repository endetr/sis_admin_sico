--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_funcionario_competencia_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_funcionario_competencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.tfuncionario_competencia'
 AUTOR:          (ymedina)
 FECHA:            14-07-2020 20:40:32
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                14-07-2020 20:40:32    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_fun_comp    INTEGER;
    v_atributo			INTEGER;
    v_id_funcionario	INTEGER;
    v_id_competencia	INTEGER;
    v_nivel				INTEGER;

BEGIN

    v_nombre_funcion = 'sico.ft_funcionario_competencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_FUNCOMP_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        14-07-2020 20:40:32
    ***********************************/

    IF (p_transaccion='SICO_FUNCOMP_INS') THEN
        v_atributo = null;
        if (pxp.f_existe_parametro(p_tabla,'id_atributo')) then
            v_atributo = v_parametros.id_atributo;
        end if;

        BEGIN
            --Sentencia de la insercion
            INSERT INTO sico.tfuncionario_competencia(
                estado_reg,
                id_funcionario,
                id_competencia,
                nivel,
                id_atributo,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.id_competencia,
                         v_parametros.nivel,
                         v_atributo,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_fun_comp into v_id_fun_comp;

            --historico
            INSERT INTO sico.thistorico_competencia
            (
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_funcionario,
                id_competencia,
                nivel_anterior,
                nivel_actual,
                justificacion
            )
            VALUES (
                       p_id_usuario,
                       null,
                       now(),
                       null,
                       'activo',
                       v_parametros.id_funcionario,
                       v_parametros.id_competencia,
                       null,
                       v_parametros.nivel,
                       'create'
                   );

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','funcionario competencia almacenado(a) con exito (id_fun_comp'||v_id_fun_comp||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_fun_comp',v_id_fun_comp::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_FUNCOMP_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        14-07-2020 20:40:32
        ***********************************/

    ELSIF (p_transaccion='SICO_FUNCOMP_MOD') THEN

        BEGIN
            v_atributo = null;
            if (pxp.f_existe_parametro(p_tabla,'id_atributo')) then
                v_atributo = v_parametros.id_atributo;
            end if;

            --Sentencia de la modificacion
            UPDATE sico.tfuncionario_competencia SET
                                                     id_funcionario = v_parametros.id_funcionario,
                                                     id_competencia = v_parametros.id_competencia,
                                                     nivel = v_parametros.nivel,
                                                     id_atributo = v_atributo,
                                                     id_usuario_mod = p_id_usuario,
                                                     fecha_mod = now(),
                                                     id_usuario_ai = v_parametros._id_usuario_ai,
                                                     usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_fun_comp=v_parametros.id_fun_comp;

            --historico
            INSERT INTO sico.thistorico_competencia
            (
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_funcionario,
                id_competencia,
                nivel_anterior,
                nivel_actual,
                justificacion
            )
            VALUES (
                       p_id_usuario,
                       null,
                       now(),
                       null,
                       'activo',
                       v_parametros.id_funcionario,
                       v_parametros.id_competencia,
                       null,
                       v_parametros.nivel,
                       'update'
                   );

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','funcionario competencia modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_fun_comp',v_parametros.id_fun_comp::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_FUNCOMP_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        14-07-2020 20:40:32
        ***********************************/

    ELSIF (p_transaccion='SICO_FUNCOMP_ELI') THEN

        BEGIN

            select 	id_funcionario, id_competencia, nivel
            into  v_id_funcionario, v_id_competencia, v_nivel
            from  sico.tfuncionario_competencia
            where  id_fun_comp = v_parametros.id_fun_comp;

            --Sentencia de la eliminacion
            DELETE FROM sico.tfuncionario_competencia
            WHERE id_fun_comp=v_parametros.id_fun_comp;

            --historico
            INSERT INTO sico.thistorico_competencia
            (
                id_usuario_reg,
                id_usuario_mod,
                fecha_reg,
                fecha_mod,
                estado_reg,
                id_funcionario,
                id_competencia,
                nivel_anterior,
                nivel_actual,
                justificacion
            )
            VALUES (
                       p_id_usuario,
                       null,
                       now(),
                       null,
                       'activo',
                       v_id_funcionario,
                       v_id_competencia,
                       null,
                       v_nivel,
                       'delete'
                   );

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','funcionario competencia eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_fun_comp',v_parametros.id_fun_comp::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    ELSE

        RAISE EXCEPTION 'Transaccion inexistente: %',p_transaccion;

    END IF;

EXCEPTION

    WHEN OTHERS THEN
        v_resp='';
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
        raise exception '%',v_resp;

END;
$body$
    LANGUAGE 'plpgsql'
    VOLATILE
    CALLED ON NULL INPUT
    SECURITY INVOKER
    PARALLEL UNSAFE
    COST 100;