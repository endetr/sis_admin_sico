--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sico.ft_funcionario_competencia_sel (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        administracion sico
 FUNCION:         sico.ft_funcionario_competencia_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sico.tfuncionario_competencia'
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

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'sico.ft_funcionario_competencia_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'SICO_FUNCOMP_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        ymedina
     #FECHA:        14-07-2020 20:40:32
    ***********************************/

    IF (p_transaccion='SICO_FUNCOMP_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
						funcomp.id_fun_comp,
                        funcomp.id_funcionario,
                        funcomp.id_competencia,
                        (comp.competencia)::character varying  as nombre_competencia,
                        funcomp.nivel,
                        funcomp.id_usuario_reg,
                        funcomp.fecha_reg,
                        funcomp.id_usuario_ai,
                        funcomp.usuario_ai,
                        funcomp.id_usuario_mod,
                        funcomp.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        (vfun.desc_funcionario1)::character varying as nombre_funcionario,
                        g.gestion,
                        cn.nivel as nivel_desc
                        FROM sigefo.tcompetencia comp
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = comp.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = comp.id_usuario_mod
                        JOIN sico.tfuncionario_competencia funcomp ON funcomp.id_competencia = comp.id_competencia
                        JOIN orga.vfuncionario vfun ON vfun.id_funcionario = funcomp.id_funcionario
                        LEFT join sigefo.tgestion_competencia gc on gc.id_competencia=comp.id_competencia
                        LEFT join param.tgestion g on g.id_gestion=gc.id_gestion
                        LEFT JOIN sigefo.tcompetencia_nivel cn on comp.id_competencia = cn.id_competencia
                        WHERE  ';

            --Definicion de la respuesta
            if (pxp.f_existe_parametro(p_tabla,'id_funcionario')) then
                v_consulta:=v_consulta||' funcomp.id_funcionario = '||v_parametros.id_funcionario;
            else
                v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            end if;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'SICO_FUNCOMP_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        ymedina
         #FECHA:        14-07-2020 20:40:32
        ***********************************/

    ELSIF (p_transaccion='SICO_FUNCOMP_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(*)
                        FROM sigefo.tcompetencia comp
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = comp.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = comp.id_usuario_mod
                        JOIN sico.tfuncionario_competencia funcomp ON funcomp.id_competencia = comp.id_competencia
                        WHERE ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

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