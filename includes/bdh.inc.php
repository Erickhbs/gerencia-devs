<?php
/* conexao com o MySQL para usar como bd */

//data source name ou dsn
$dsn = "mysql:host=localhost;dbname=gerencia_devs";

//usarei nome do usuario e senha padroes que vem junto ao software XAMPP
//mas pode ser mudado caso seu usuario e senha sejam outros :)
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    die(message("Falha na conexão". $e->getMessage(), false));
}