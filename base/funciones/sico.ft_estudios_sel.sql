--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_estudios_sel (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_estudios_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sico.testudios'
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

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'sico.ft_estudios_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_ESTU_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina
     #FECHA:        15-07-2020 06:03:28
    ***********************************/

    IF (p_transaccion='SICO_ESTU_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        estu.id_estudio,
                        estu.estado_reg,
                        estu.id_funcionario,
                        estu.nivel,
                        estu.institucion,
                        estu.localidad,
                        estu.fecha_inicio,
                        estu.fecha_fin,
                        estu.titulo,
                        estu.id_usuario_reg,
                        estu.fecha_reg,
                        estu.id_usuario_ai,
                        estu.usuario_ai,
                        estu.id_usuario_mod,
                        estu.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        (vfun.desc_funcionario1)::character varying as funcionario
                        FROM sico.testudios estu
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = estu.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = estu.id_usuario_mod
                        JOIN orga.vfuncionario vfun ON vfun.id_funcionario = estu.id_funcionario
                        WHERE  ';

            if (pxp.f_existe_parametro(p_tabla,'id_funcionario')) then
                v_consulta:=v_consulta||' estu.id_funcionario = '||v_parametros.id_funcionario;
            else
                v_consulta:=v_consulta||v_parametros.filtro;
                v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            end if;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'SICO_ESTU_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        ymedina
         #FECHA:        15-07-2020 06:03:28
        ***********************************/

    ELSIF (p_transaccion='SICO_ESTU_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_estudio)
                         FROM sico.testudios estu
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = estu.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = estu.id_usuario_mod
                         WHERE ';

            --Definicion de la respuesta
            if (pxp.f_existe_parametro(p_tabla,'id_funcionario')) then
                v_consulta:=v_consulta||' estu.id_funcionario = '||v_parametros.id_funcionario;
            else
                v_consulta:=v_consulta||v_parametros.filtro;
            end if;

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