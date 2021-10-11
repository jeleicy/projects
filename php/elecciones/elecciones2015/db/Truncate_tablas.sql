/*PARA ELECCIONES*/

truncate encuesta_observador;
truncate estatus;
truncate planillas_verificadas;
truncate recuperacion;
truncate votos;

/*TABLAS GENERICAS*/

truncate asignacion;
truncate asignacion_operador;
truncate candidato;
truncate centro;
truncate universo_mesa;

/*Otros Queries*/

create table centros_aux (
	id_centro int,
	codigo_centro varchar(20),
	cod_mesa int,
	nro_votantes int
);


select 'insert into candidato (nombre,partido,id_eleccion,id_estado, id_municipio,codm,tendencia) values ("OPOSICION","OPOSICION",1,'||id_estado||','||id_municipio||'0,0);' from municipio order by 1,2