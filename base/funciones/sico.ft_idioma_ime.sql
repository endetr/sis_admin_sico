--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_idioma_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_idioma_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.tidioma'
 AUTOR:          (ymedina)
 FECHA:            13-07-2020 03:07:56
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                13-07-2020 03:07:56    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_idioma    INTEGER;

BEGIN

    v_nombre_funcion = 'sico.ft_idioma_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_IDI_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        13-07-2020 03:07:56
    ***********************************/

    IF (p_transaccion='SICO_IDI_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO sico.tidioma(
                estado_reg,
                id_funcionario,
                idioma,
                habla,
                lee,
                escribe,
                entiende,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.idioma,
                         v_parametros.habla,
                         v_parametros.lee,
                         v_parametros.escribe,
                         v_parametros.entiende,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_idioma into v_id_idioma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','idioma almacenado(a) con exito (id_idioma'||v_id_idioma||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_idioma',v_id_idioma::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_IDI_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        13-07-2020 03:07:56
        ***********************************/

    ELSIF (p_transaccion='SICO_IDI_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE sico.tidioma SET
                                    id_funcionario = v_parametros.id_funcionario,
                                    idioma = v_parametros.idioma,
                                    habla = v_parametros.habla,
                                    lee = v_parametros.lee,
                                    escribe = v_parametros.escribe,
                                    entiende = v_parametros.entiende,
                                    id_usuario_mod = p_id_usuario,
                                    fecha_mod = now(),
                                    id_usuario_ai = v_parametros._id_usuario_ai,
                                    usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_idioma=v_parametros.id_idioma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','idioma modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_idioma',v_parametros.id_idioma::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_IDI_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        13-07-2020 03:07:56
        ***********************************/

    ELSIF (p_transaccion='SICO_IDI_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM sico.tidioma
            WHERE id_idioma=v_parametros.id_idioma;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','idioma eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_idioma',v_parametros.id_idioma::varchar);

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