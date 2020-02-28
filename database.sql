CREATE DATABASE IF NOT EXISTS tareas;

USE tareas;

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment NOT null,
role          int(50),
name            varchar(100),
surname         varchar(200),
email           varchar(255),
password        varchar(255),
created_at      datetime,
CONSTRAINT pk_users  PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(NULL, 'ROLE_USER', 'David', 'Caro', 'david@hotmail.com', 'password', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Manolo', 'Perez', 'manolo@hotmail.com', 'password', CURTIME());
INSERT INTO users VALUES(NULL, 'ROLE_USER', 'Carlos', 'Sanchez', 'carlos@hotmail.com', 'password', CURTIME());

CREATE TABLE IF NOT EXISTS tasks(
id              int(955) auto_increment NOT null,
user_id         int(255) not null,
title           varchar(255),
receptor	    varchar(255),
content         text,
priority        varchar(20),
hours           int(100),
state	        varchar(255),
created_at      datetime,
adjunto         VARCHAR(999),
CONSTRAINT pk_tasks PRIMARY KEY(id),
CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;


CREATE TABLE IF NOT EXISTS rol(
idRol    int,
CONSTRAINT fk_rol_user FOREIGN KEY(idRol) REFERENCES users(role)

)


INSERT INTO tasks VALUES(NULL, 1, 'tarea 1', 'david','Contenido de prueba1', 'high', 40,'unfinished', CURTIME());
INSERT INTO tasks VALUES(NULL, 1, 'tarea 1', 'david','Contenido de prueba1', 'high', 40,'unfinished', CURTIME());
INSERT INTO tasks VALUES(NULL, 1, 'tarea 1', 'david','Contenido de prueba1', 'high', 40,'unfinished', CURTIME());



