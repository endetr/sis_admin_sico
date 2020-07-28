/********************************************I-DAT-YMR-SICO-0-27/07/2020********************************************/
-------insertamos el sistema------------

INSERT INTO segu.tsubsistema ("codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES (E'SICO', E'administracion sico', E'2020-07-27', E'SICO', E'activo', E'admin_sico', NULL);

-----------Estructura del menu-------------
select pxp.f_insert_tgui ('ADMINISTRACION SICO', '', 'SICO', 'si', 1, '', 1, '', '', 'SICO');
select pxp.f_insert_tgui ('Administración de datos personales', 'Administración de datos personales', 'ADM_DAT_PER', 'si', 1, '', 2, '', '', 'SICO');
select pxp.f_insert_tgui ('Datos Personales', 'Datos Personales', 'DATPER', 'si', 2, 'sis_admin_sico/vista/datos_personales/DatosPersonales.php', 3, '', 'DatFuncionario', 'SICO');
select pxp.f_insert_tgui ('configuración', 'configuración', 'CONFSICO', 'si', 2, '', 2, '', '', 'SICO');

/********************************************F-DAT-YMR-SICO-0-27/07/2020**********************************************/

