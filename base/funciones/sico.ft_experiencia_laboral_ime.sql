--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_experiencia_laboral_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_experiencia_laboral_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.texperiencia_laboral'
 AUTOR:          (ymedina)
 FECHA:            15-07-2020 06:02:45
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 06:02:45    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_experiencia    INTEGER;

BEGIN

    v_nombre_funcion = 'sico.ft_experiencia_laboral_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_EXPLAB_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        15-07-2020 06:02:45
    ***********************************/

    IF (p_transaccion='SICO_EXPLAB_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO sico.texperiencia_laboral(
                estado_reg,
                id_funcionario,
                empresa,
                cargo,
                fecha_inicio,
                fecha_fin,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.empresa,
                         v_parametros.cargo,
                         v_parametros.fecha_inicio,
                         v_parametros.fecha_fin,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_experiencia into v_id_experiencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','experiencia laboral almacenado(a) con exito (id_experiencia'||v_id_experiencia||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_experiencia',v_id_experiencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_EXPLAB_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 06:02:45
        ***********************************/

    ELSIF (p_transaccion='SICO_EXPLAB_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE sico.texperiencia_laboral SET
                                                 id_funcionario = v_parametros.id_funcionario,
                                                 empresa = v_parametros.empresa,
                                                 cargo = v_parametros.cargo,
                                                 fecha_inicio = v_parametros.fecha_inicio,
                                                 fecha_fin = v_parametros.fecha_fin,
                                                 id_usuario_mod = p_id_usuario,
                                                 fecha_mod = now(),
                                                 id_usuario_ai = v_parametros._id_usuario_ai,
                                                 usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_experiencia=v_parametros.id_experiencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','experiencia laboral modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_experiencia',v_parametros.id_experiencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_EXPLAB_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 06:02:45
        ***********************************/

    ELSIF (p_transaccion='SICO_EXPLAB_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM sico.texperiencia_laboral
            WHERE id_experiencia=v_parametros.id_experiencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','experiencia laboral eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_experiencia',v_parametros.id_experiencia::varchar);

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