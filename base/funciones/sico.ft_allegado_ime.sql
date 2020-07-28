CREATE OR REPLACE FUNCTION sico.ft_allegado_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_allegado_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.tallegado'
 AUTOR:          (ymedina)
 FECHA:            15-07-2020 15:06:16
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 15:06:16    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_allegado    INTEGER;

BEGIN

    v_nombre_funcion = 'sico.ft_allegado_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_ALLEG_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        15-07-2020 15:06:16
    ***********************************/

    IF (p_transaccion='SICO_ALLEG_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO sico.tallegado(
                estado_reg,
                id_funcionario,
                id_persona,
                tipo_relacion,
                parentesco,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.id_persona,
                         v_parametros.tipo_relacion,
                         v_parametros.parentesco,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_allegado into v_id_allegado;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','allegado almacenado(a) con exito (id_allegado'||v_id_allegado||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_allegado',v_id_allegado::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_ALLEG_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 15:06:16
        ***********************************/

    ELSIF (p_transaccion='SICO_ALLEG_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE sico.tallegado SET
                                      id_funcionario = v_parametros.id_funcionario,
                                      id_persona = v_parametros.id_persona,
                                      tipo_relacion = v_parametros.tipo_relacion,
                                      parentesco = v_parametros.parentesco,
                                      id_usuario_mod = p_id_usuario,
                                      fecha_mod = now(),
                                      id_usuario_ai = v_parametros._id_usuario_ai,
                                      usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_allegado=v_parametros.id_allegado;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','allegado modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_allegado',v_parametros.id_allegado::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_ALLEG_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 15:06:16
        ***********************************/

    ELSIF (p_transaccion='SICO_ALLEG_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM sico.tallegado
            WHERE id_allegado=v_parametros.id_allegado;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','allegado eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_allegado',v_parametros.id_allegado::varchar);

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