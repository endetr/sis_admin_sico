--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_estudios_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_estudios_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.testudios'
 AUTOR:          (ymedina)
 FECHA:            15-07-2020 06:03:28
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                15-07-2020 06:03:28    ymedina             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_estudio    INTEGER;

BEGIN

    v_nombre_funcion = 'sico.ft_estudios_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_ESTU_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        15-07-2020 06:03:28
    ***********************************/

    IF (p_transaccion='SICO_ESTU_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO sico.testudios(
                estado_reg,
                id_funcionario,
                nivel,
                institucion,
                localidad,
                fecha_inicio,
                fecha_fin,
                titulo,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.nivel,
                         v_parametros.institucion,
                         v_parametros.localidad,
                         v_parametros.fecha_inicio,
                         v_parametros.fecha_fin,
                         v_parametros.titulo,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_estudio into v_id_estudio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','estudios almacenado(a) con exito (id_estudio'||v_id_estudio||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_estudio',v_id_estudio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_ESTU_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 06:03:28
        ***********************************/

    ELSIF (p_transaccion='SICO_ESTU_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE sico.testudios SET
                                      id_funcionario = v_parametros.id_funcionario,
                                      nivel = v_parametros.nivel,
                                      institucion = v_parametros.institucion,
                                      localidad = v_parametros.localidad,
                                      fecha_inicio = v_parametros.fecha_inicio,
                                      fecha_fin = v_parametros.fecha_fin,
                                      titulo = v_parametros.titulo,
                                      id_usuario_mod = p_id_usuario,
                                      fecha_mod = now(),
                                      id_usuario_ai = v_parametros._id_usuario_ai,
                                      usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_estudio=v_parametros.id_estudio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','estudios modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_estudio',v_parametros.id_estudio::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_ESTU_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 06:03:28
        ***********************************/

    ELSIF (p_transaccion='SICO_ESTU_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM sico.testudios
            WHERE id_estudio=v_parametros.id_estudio;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','estudios eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_estudio',v_parametros.id_estudio::varchar);

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