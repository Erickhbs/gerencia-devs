<?php 
    /* conexao com o MySQL para usar como bd */
    //data source name ou dsn
    $dsn = "mysql:host=localhost;dbname=gerencia_devs";
    //usarei nome do usuario e senha padroes que vem jinto ao software XAMPP
    $dbusername = "root";
    $dbpassword = "";

    try {
        $pdo = new PDO($dsn, $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'falha na conexao'. $e->getMessage();
    }

?>

<?php
    /* todas as funcoes da aplicacao */


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>

        </style>
    </head>
    <body>
        <h3>Cadastrar Associado</h3>

        <form action="" method="post">
            <input type="text" name="nome" placeholder="nome e sobrenome"><br>
            <input type="email" name="email" placeholder="email do associado"><br>
            <input type="text" name="cpf" placeholder="cpf do associado"><br>
            <button>Cadastrar</button>
        </form>

    </body>
</html>



