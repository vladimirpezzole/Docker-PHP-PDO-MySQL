### Ambiente de Teste [ PHP Apache + PDO MySQL + PHP MyADMIN ] com Docker

Ambiente **AMP** para teste com  **PDO MySQL** utilizando o **Docker Compose**.

Para instalar tenha o GIT instalado e clone o repositório:

```bash
git clone https://github.com/vladimirpezzole/Docker-PHP-PDO-MySQL.git
```

Depois verifique as configurações do **Docker Compose**, **Dockerfile** e as variáveis em **.env** e execute:

```bash
docker compose up -d
```
*Obs. se a versão do **Docker CLI versão 2.0.0**, for anterior, use >> **`docker-compose`** com hífen(-).*


<hr>


### Docker Compose, Dockerfile e .env

No arquivo >> **docker-compose.yml** estão configurados 3 serviços

- container database **php_db** com image: **mysql:5.7** na porta **9306**
- container db_admin **php_myadmin** com image: **phpmyadmin/phpmyadmin:5** na porta **9015**
- container app **php_web** com build de image: **php:8.0-apache** na porta **9016**





**`docker-compose.yml`**:
```bash
version: '3'

services:
  database:
    image: mysql:5.7
    container_name: php_db
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_DATABASE: ${MYSQL_DATABASE}
      MYSQL_USER: ${MYSQL_USER}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "${MYSQL_PORT}:3306"

  db_admin:
    image: phpmyadmin/phpmyadmin:5
    container_name: php_myadmin
    ports:
      - '${MYADMIN_PORT}:80'
    environment:
      - PMA_HOST=database
      - PMA_ABSOLUTE_URI=http://localhost:${MYADMIN_PORT}/
    depends_on:
      database:
        condition: service_healthy
    volumes:
      - db_admin_data:/var/www/html

  app:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: php_web
    ports:
      - '${WEB_PORT}:80'
    working_dir: /var/www/html
    volumes:
      - ./public:/var/www/html
    depends_on:
      database:
        condition: service_healthy

volumes:
  db_data:
  db_admin_data:
```

**Dockerfile** do **Apache** com a extensão **pdo pdo_mysql** estã em >> **`docker/Dockerfile`**

```bash
FROM php:8.0-apache
RUN docker-php-ext-install pdo pdo_mysql
```

As variaveis do **Docker Compose** para **Banco de Dados** e **Portas utilizas** estão no arquivo >> **`.env`**

```bash
MYSQL_ROOT_PASSWORD=123
MYSQL_DATABASE=db-Teste-PDO
MYSQL_USER=devuser
MYSQL_PASSWORD=123

# Portas utilizadas
MYSQL_PORT=9306
MYADMIN_PORT=9015
WEB_PORT=9016
```

<hr>


### Banco de Dados via Terminal ou PHPMyAdmin


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

Crie e alimente a Tabela **paises** *(sem acento) * :
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


### Index de Teste de conexão

** `index.html` **

```bash
<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 
 <?php 
 	require_once "connect.php";
 ?>

 </body>
</html>
```



**Arquivo `connect.php` ** com teste e exibição.


```bash
<?php
$servername = "database";
$username = "root";
$password = "123";
$dbname = "db-Teste-PDO";
$port = "3306";
$tablename = "paises";

// Testa o Banco de Dados PDO MySQL
try {
   $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Conexão realizada com Sucesso!";
} catch (PDOException $e) {
   echo "Conexão falhou! :( " . $e->getMessage();
}

// Conecta ao Banco de Dados PDO MySQL
$query="SELECT * FROM $tablename";
$stmt = $conn->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Converte $results para JSON e exibe formatado na tela
$json = json_encode($results, JSON_PRETTY_PRINT);
echo '<hr>Resultado da Tabela >> ' . $dbname;
echo '<hr><pre>' . $json . '</pre><hr>';

```


<hr>