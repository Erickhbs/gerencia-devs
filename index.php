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
    } catch (PDOException $e) {
        echo 'Falha na conexão: ' . $e->getMessage();
    }

?>

<?php
    /* todas as funcoes da aplicacao */

    //ver se o formulario de cadastro de associado foi enviado
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //pegando os valores
        $name = $_POST["name"];
        $email = $_POST["email"];
        $cpf = $_POST["cpf"];
        insertAssociado($name, $email, $cpf);
    }

    //funcao responsavel por inserir um novo associado \'POST'/
    function insertAssociado($name, $email, $cpf){
        try {
            global $pdo;

            //criando a query responsável por inserir o associado no bd
            $query = "INSERT INTO associado (name, email, cpf) VALUES (?,?,?);";

            //preparar e inserir na string
            $statement = $pdo->prepare($query);
            $statement->execute([$name, $email, $cpf]);

            //apenas para limpar o espaço da memoria
            $pdo = null;
            $statement = null;

            // Mensagem de confirmação e botão para voltar
            echo "<p>Associado cadastrado com sucesso!</p>";
            echo "<button onclick='window.location.href=\"\";'>Voltar</button>";

            die();

        } catch (PDOExeption $e) {
            die("falha na inserção: " . $e->getMessage());
        }
    }

    //funcao responsavel por deletar um associado \'DELETE'/
    function deleteAssociado(){}

    //funcao responsavel por ATUALIZAR um associado \'PUT'/
    function updateAssociado(){}

    //funcao responsavel por criar uma nova anuidade \'POST'/
    function createAnuidade(){}

    //funcao responsavel por deletar uma anuidade \'DELETE'/
    function deleteAnuidadeo(){}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>site</title>
        <style>

        </style>
    </head>
    <body>

        <h3>Cadastrar Associado</h3>
        <form action="" method="post">
            <input type="text" name="name" placeholder="nome e sobrenome" require><br>
            <input type="email" name="email" placeholder="email do associado" require><br>
            <input type="text" name="cpf" placeholder="cpf do associado" require><br>
            <button type="submit">Cadastrar</button><br>
        </form>

    </body>
</html>



