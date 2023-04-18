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
   echo  "Conexão realizada com Sucesso!!!  :) <hr> ";
} catch (PDOException $e) {
   echo "Conexão falhou! :( <hr> " . $e->getMessage();
}

// Conecta ao Banco de Dados PDO MySQL
$query="SELECT * FROM $tablename";
$stmt = $conn->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Converte $results para JSON e exibe formatado na tela
$json = json_encode($results, JSON_PRETTY_PRINT);
echo '<hr>Resultado da Tabela >> ' . $dbname;
echo '<hr><pre>' . $json . '</pre><hr>';
