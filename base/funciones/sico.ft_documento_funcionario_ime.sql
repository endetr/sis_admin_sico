--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_documento_funcionario_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_documento_funcionario_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sico.tdocumento_funcionario'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_documento    		   INTEGER;
    v_estructura		  	   VARCHAR;
    v_url				       VARCHAR;
    v_extencion				   VARCHAR;

BEGIN

    v_nombre_funcion = 'sico.ft_documento_funcionario_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_DOCFUN_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        ymedina
     #FECHA:        23-07-2020 14:39:56
    ***********************************/

    IF (p_transaccion='SICO_DOCFUN_INS') THEN

        BEGIN
            if (pxp.f_existe_parametro(p_tabla,'url')) then
                v_url = v_parametros.url;
            end if;
            if (pxp.f_existe_parametro(p_tabla,'extension')) then
                v_extencion = v_parametros.extension;
            end if;

            --Sentencia de la insercion
            INSERT INTO sico.tdocumento_funcionario(
                estado_reg,
                id_funcionario,
                tipo_documento,
                nombre_archivo,
                titulo,
                url,
                extension,
                id_usuario_reg,
                fecha_reg,
                id_usuario_ai,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
            ) VALUES (
                         'activo',
                         v_parametros.id_funcionario,
                         v_parametros.tipo_documento,
                         v_parametros.nombre_archivo,
                         v_parametros.titulo,
                         v_url,
                         v_extencion,
                         p_id_usuario,
                         now(),
                         v_parametros._id_usuario_ai,
                         v_parametros._nombre_usuario_ai,
                         null,
                         null
                     ) RETURNING id_documento into v_id_documento;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','documento funcionario almacenado(a) con exito (id_documento'||v_id_documento||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_documento',v_id_documento::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_DOCFUN_MOD'
         #DESCRIPCION:    Modificacion de registros
         #AUTOR:        ymedina
         #FECHA:        23-07-2020 14:39:56
        ***********************************/

    ELSIF (p_transaccion='SICO_DOCFUN_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE sico.tdocumento_funcionario SET
                                                   id_funcionario = v_parametros.id_funcionario,
                                                   tipo_documento = v_parametros.tipo_documento,
                                                   nombre_archivo = v_parametros.nombre_archivo,
                                                   titulo = v_parametros.titulo,
                                                   url = v_parametros.url,
                                                   extension = v_parametros.extension,
                                                   id_usuario_mod = p_id_usuario,
                                                   fecha_mod = now(),
                                                   id_usuario_ai = v_parametros._id_usuario_ai,
                                                   usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_documento=v_parametros.id_documento;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','documento funcionario modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_documento',v_parametros.id_documento::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_DOCFUN_ELI'
         #DESCRIPCION:    Eliminacion de registros
         #AUTOR:        ymedina
         #FECHA:        23-07-2020 14:39:56
        ***********************************/

    ELSIF (p_transaccion='SICO_DOCFUN_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM sico.tdocumento_funcionario
            WHERE id_documento=v_parametros.id_documento;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','documento funcionario eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_documento',v_parametros.id_documento::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
         #TRANSACCION:  'SICO_DOCFUN_ESTR'
         #DESCRIPCION:    dar estructura
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 17:56:17
        ***********************************/

    ELSIF (p_transaccion='SICO_DOCFUN_ESTR') THEN

        BEGIN
            --recuperamos los funcionarios encargado de los funcionarios solicitantes --#7

            WITH RECURSIVE path( id_funcionario, nombre_unidad, id_uo, gerencia, numero_nivel) AS (

                SELECT uofun.id_funcionario, uo.nombre_unidad, uo.id_uo,uo.gerencia, no.numero_nivel
                FROM orga.tuo_funcionario uofun
                         inner join orga.tuo uo on uo.id_uo = uofun.id_uo
                         inner join orga.tnivel_organizacional no on no.id_nivel_organizacional = uo.id_nivel_organizacional
                where uofun.fecha_asignacion <= now()::date and (uofun.fecha_finalizacion is null or uofun.fecha_finalizacion >= now()::date)
                  and uofun.estado_reg = 'activo' and uofun.id_funcionario =  v_parametros.id_funcionario
                UNION

                SELECT uofun.id_funcionario, uo.nombre_unidad, euo.id_uo_padre,uo.gerencia,no.numero_nivel
                FROM orga.testructura_uo euo
                         inner join orga.tuo uo on uo.id_uo = euo.id_uo_padre
                         inner join orga.tnivel_organizacional no on no.id_nivel_organizacional = uo.id_nivel_organizacional
                         inner join path hijo on hijo.id_uo = euo.id_uo_hijo
                         left join orga.tuo_funcionario uofun on uo.id_uo = uofun.id_uo and uofun.estado_reg = 'activo' and uofun.fecha_asignacion <= now()::date
                    and (uofun.fecha_finalizacion is null or uofun.fecha_finalizacion >= now()::date)
                --where euo.id_uo_hijo = 1145 and  numero_nivel not in (7,8,9)and id_funcionario is not null
            )
            SELECT
                pxp.aggarray(nombre_unidad)
            INTO
                v_estructura
            FROM path
            WHERE numero_nivel not in (7,8,9)and id_funcionario is not null;


            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','documento estructura');
            v_resp = pxp.f_agrega_clave(v_resp,'v_estructura',v_estructura::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*******************************
        #TRANSACCION:  SICO_DOCFUN_RUT
        #DESCRIPCION:	sube plantilla
        #AUTOR:		KPLIAN
        #FECHA:		28-06-2011
        ***********************************/
    elsif(p_transaccion='SICO_DOCFUN_RUT')then
        BEGIN

            UPDATE sico.tdocumento_funcionario SET
                                                   url = v_parametros.ruta_archivo,
                                                   nombre_archivo = v_parametros.nombre_archivos,
                                                   extension = v_parametros.file_extencion
            where id_documento = v_parametros.id_documento;

            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','documento eliminado con exito '||v_parametros.id_documento);
            v_resp = pxp.f_agrega_clave(v_resp,'id_documento',v_parametros.id_documento::varchar);
            return v_resp;
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