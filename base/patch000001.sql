/***********************************I-SCP-YMR-SICO-0-27/07/2020****************************************/
CREATE TABLE sico.tidioma (
                              id_funcionario INTEGER NOT NULL,
                              id_idioma SERIAL,
                              idioma VARCHAR(50),
                              habla VARCHAR(15),
                              lee VARCHAR(15),
                              escribe VARCHAR(15),
                              entiende VARCHAR(15),
                              CONSTRAINT tidioma_pkey PRIMARY KEY(id_idioma),
                              CONSTRAINT fk_tidioma__id_funcionario FOREIGN KEY (id_funcionario)
                                  REFERENCES orga.tfuncionario(id_funcionario)
                                  ON DELETE NO ACTION
                                  ON UPDATE NO ACTION
                                  NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.tidioma.id_idioma
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.tresidencia (
                                  id_residencia SERIAL,
                                  id_funcionario INTEGER NOT NULL,
                                  direccion VARCHAR(200),
                                  ciudad VARCHAR(50),
                                  telefono VARCHAR(30),
                                  CONSTRAINT tresidencia_pkey PRIMARY KEY(id_residencia),
                                  CONSTRAINT fk_tfun_comp__id_funcionario FOREIGN KEY (id_funcionario)
                                      REFERENCES orga.tfuncionario(id_funcionario)
                                      ON DELETE NO ACTION
                                      ON UPDATE NO ACTION
                                      NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.tresidencia.id_residencia
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.thistorico_competencia (
                                             id_historico SERIAL,
                                             id_funcionario INTEGER NOT NULL,
                                             id_competencia INTEGER NOT NULL,
                                             nivel_anterior SMALLINT,
                                             nivel_actual SMALLINT,
                                             justificacion VARCHAR(255),
                                             CONSTRAINT thistorico_competencia_pkey PRIMARY KEY(id_historico),
                                             CONSTRAINT fk_thistorico__id_competencia FOREIGN KEY (id_competencia)
                                                 REFERENCES sigefo.tcompetencia(id_competencia)
                                                 ON DELETE NO ACTION
                                                 ON UPDATE NO ACTION
                                                 NOT DEFERRABLE,
                                             CONSTRAINT fk_thistorico__id_funcionario FOREIGN KEY (id_funcionario)
                                                 REFERENCES orga.tfuncionario(id_funcionario)
                                                 ON DELETE NO ACTION
                                                 ON UPDATE NO ACTION
                                                 NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.thistorico_competencia.id_historico
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.tfuncionario_competencia (
                                               id_fun_comp SERIAL,
                                               id_funcionario INTEGER NOT NULL,
                                               id_competencia INTEGER NOT NULL,
                                               nivel SMALLINT,
                                               id_atributo INTEGER,
                                               CONSTRAINT tfuncionario_competencia_pkey PRIMARY KEY(id_fun_comp),
                                               CONSTRAINT fk_tfun_comp__id_competencia FOREIGN KEY (id_competencia)
                                                   REFERENCES sigefo.tcompetencia(id_competencia)
                                                   ON DELETE NO ACTION
                                                   ON UPDATE NO ACTION
                                                   NOT DEFERRABLE,
                                               CONSTRAINT fk_tfun_comp__id_funcionario FOREIGN KEY (id_funcionario)
                                                   REFERENCES orga.tfuncionario(id_funcionario)
                                                   ON DELETE NO ACTION
                                                   ON UPDATE NO ACTION
                                                   NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.tfuncionario_competencia.id_fun_comp
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.texperiencia_laboral (
                                           id_experiencia SERIAL,
                                           id_funcionario INTEGER NOT NULL,
                                           empresa VARCHAR(100),
                                           cargo VARCHAR(100),
                                           localidad VARCHAR(50),
                                           fecha_inicio DATE,
                                           fecha_fin DATE,
                                           CONSTRAINT texperiencia_laboral_pkey PRIMARY KEY(id_experiencia),
                                           CONSTRAINT fk_texperiencia_laboral__id_funcionario FOREIGN KEY (id_funcionario)
                                               REFERENCES orga.tfuncionario(id_funcionario)
                                               ON DELETE NO ACTION
                                               ON UPDATE NO ACTION
                                               NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.texperiencia_laboral.id_experiencia
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.testudios (
                                id_estudio SERIAL,
                                id_funcionario INTEGER NOT NULL,
                                nivel VARCHAR(30),
                                institucion VARCHAR(100),
                                localidad VARCHAR(50),
                                fecha_inicio DATE,
                                fecha_fin DATE,
                                titulo VARCHAR(100),
                                CONSTRAINT testudios_pkey PRIMARY KEY(id_estudio),
                                CONSTRAINT fk_testudios__id_funcionario FOREIGN KEY (id_funcionario)
                                    REFERENCES orga.tfuncionario(id_funcionario)
                                    ON DELETE NO ACTION
                                    ON UPDATE NO ACTION
                                    NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.testudios.id_estudio
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.tdocumento_funcionario (
                                             id_documento SERIAL,
                                             id_funcionario INTEGER NOT NULL,
                                             tipo_documento VARCHAR(15),
                                             nombre_archivo VARCHAR(150),
                                             titulo VARCHAR(350),
                                             url VARCHAR(200),
                                             extension VARCHAR(5),
                                             CONSTRAINT tdocumento_funcionario_pkey PRIMARY KEY(id_documento),
                                             CONSTRAINT fk_tdocumento_id_funcionario FOREIGN KEY (id_funcionario)
                                                 REFERENCES orga.tfuncionario(id_funcionario)
                                                 ON DELETE NO ACTION
                                                 ON UPDATE NO ACTION
                                                 NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);

COMMENT ON COLUMN sico.tdocumento_funcionario.id_documento
    IS 'Identificador de la tabla';

---------------------------SQL----------------------------------------
CREATE TABLE sico.tallegado (
                                id_allegado SERIAL,
                                id_funcionario INTEGER NOT NULL,
                                id_persona INTEGER NOT NULL,
                                tipo_relacion VARCHAR(50),
                                parentesco VARCHAR(15),
                                CONSTRAINT tallegado_pkey PRIMARY KEY(id_allegado),
                                CONSTRAINT fk_tallegado__id_funcionario FOREIGN KEY (id_funcionario)
                                    REFERENCES orga.tfuncionario(id_funcionario)
                                    ON DELETE NO ACTION
                                    ON UPDATE NO ACTION
                                    NOT DEFERRABLE,
                                CONSTRAINT fk_tallegado__id_persona FOREIGN KEY (id_persona)
                                    REFERENCES segu.tpersona(id_persona)
                                    ON DELETE NO ACTION
                                    ON UPDATE NO ACTION
                                    NOT DEFERRABLE
) INHERITS (pxp.tbase)
  WITH (oids = false);


COMMENT ON COLUMN sico.tallegado.id_allegado
    IS 'Identificador de la tabla';
COMMENT ON COLUMN sico.tallegado.id_funcionario
    IS 'Id del funcionario que tiene a los allegados';

/***********************************F-SCP-EGS-SICO-0-27/07/2020**********************************************/
