--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_residencia_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_residencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.tresidencia'
 AUTOR:          (ymedina)
 FECHA:            15-07-2020 14:21:03
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 14:21:03    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_residencia    INTEGER;

BEGIN

    v_nombre_funcion = 'sico.ft_residencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_RESI_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        15-07-2020 14:21:03
    ***********************************/

    IF (p_transaccion='SICO_RESI_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO sico.tresidencia(
                estado_reg,
                id_funcionario,
                direccion,
                ciudad,
                telefono,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.direccion,
                         v_parametros.ciudad,
                         v_parametros.telefono,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_residencia into v_id_residencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','residencia almacenado(a) con exito (id_residencia'||v_id_residencia||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_residencia',v_id_residencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_RESI_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 14:21:03
        ***********************************/

    ELSIF (p_transaccion='SICO_RESI_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE sico.tresidencia SET
                                        id_funcionario = v_parametros.id_funcionario,
                                        direccion = v_parametros.direccion,
                                        ciudad = v_parametros.ciudad,
                                        telefono = v_parametros.telefono,
                                        id_usuario_mod = p_id_usuario,
                                        fecha_mod = now(),
                                        id_usuario_ai = v_parametros._id_usuario_ai,
                                        usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_residencia=v_parametros.id_residencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','residencia modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_residencia',v_parametros.id_residencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_RESI_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 14:21:03
        ***********************************/

    ELSIF (p_transaccion='SICO_RESI_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM sico.tresidencia
            WHERE id_residencia=v_parametros.id_residencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','residencia eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_residencia',v_parametros.id_residencia::varchar);

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