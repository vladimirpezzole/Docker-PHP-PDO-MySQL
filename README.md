###Ambiente de Teste [ PHP + PDO MySQL + PHP MyADMIN ] com Docker

docker-compose.yml

```bash
xxxxxxxxxxxxx
```


Dockerfile

```bash
xxxxxxxxxxxxx
```

.env

```bash
xxxxxxxxxxxxx
```

<hr>

###Banco de Dados via Terminal ou PHPMyAdmin
Para acessar o **mysql-cli** via terminal **localmente** ou pelo **container** utilize os comandos:

**Localmente** >> pela porta **9306**, (configurada anteriormente), digite no terminal:
```bash
mysql -uroot -p123 -h127.0.0.1 -P9306
```

Pelo **Container** >> execute o comando abaixo para acessar primeiro o container **php_db**
```bash
docker exec -it php_db bash
```
e em seguida:
```bash
mysql -uroot -p123
```
para ter acesso ao Banco de dados.

Confira se o Database **db-Teste-PDO** está criado, com:
```bash
SHOW DATABASES;
```

Crie e alimente a Tabela **paises**  :
```bash
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
```


Ou se preferir utilize o **PHPMyAdmin >> [http://localhost:9015](http://localhost:9015)**

<hr>


docker-compose.yml

```bash
xxxxxxxxxxxxx
```