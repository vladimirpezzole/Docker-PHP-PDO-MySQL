CREATE DATABASE Teste;

CREATE TABLE paises (
   id int NOT NULL AUTO_INCREMENT,
   code varchar(2) NOT NULL,
   name varchar(100) NOT NULL,
   PRIMARY KEY (id),
   UNIQUE (code)
);

INSERT INTO paises VALUES (null, 'BR', 'Brasil');
INSERT INTO paises VALUES (null, 'AR', 'Argentina');
INSERT INTO paises VALUES (null, 'UY', 'Uruguay');
INSERT INTO paises VALUES (null, 'CH', 'Chile');
INSERT INTO paises VALUES (null, 'PY', 'Paraguay');
INSERT INTO paises VALUES (null, 'PT', 'Portugal');
INSERT INTO paises VALUES (null, 'RU', 'Russia');
