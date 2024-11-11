<?php 
    require 'includes\bdh.inc.php';   

    //criei esta variavel para fazer a função de controller
    $navegacao = $_GET['navegacao'] ?? '';
    $page = isset($_GET['navegacao']) ? $_GET['navegacao'] : 'inicio';

?>



<!-- pagina html -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>site</title>
        <link rel="stylesheet" href="./css/main.css">
    </head>
    <body>
        <nav class="sidebar">
            <?php require './html/header.html'; ?>
            <?php require './html/menu.html'; ?>
        </nav>
        <section class="panel">
            <div class="panel-info">
               <?php 
                    if($navegacao == "cadastro_associado"){
                        require './html/associado.html';
                    }else if($navegacao == "cadastro_anuidade"){
                        require './html/anuidade.html';
                    }else{
                        require './html/inicio.html';
                    }
               ?>
            </div>
        </section>
    </body>
</html>



<!-- 

            <h1>Navegação</h1>
            <"ul>
                <li><a href="?navegacao=cadastro_anuidade">Anuidade</a></li>
                <li><a href="?navegacao=cadastro_associado">Associados</a></li>
                <li>Sobre</li>
            </ul>"


            if($navegacao == "cadastro_associado"){
                echo
                '<h3>Cadastrar Associado</h3>
                <form action="" method="post">
                    <input type="hidden" name="action" value="create_associado">
                    <input type="text" name="name" placeholder="nome e sobrenome" required><br>
                    <input type="email" name="email" placeholder="email do associado" required><br>
                    <input type="text" name="cpf" placeholder="cpf do associado" required><br>
                    <button type="submit">Cadastrar</button><br>
                </form>';
            }else if($navegacao == "cadastro_anuidade"){
                echo 
                '
                <h3>Cadastrar anuidade</h3>
                <form action="" method="post">
                <input type="hidden" name="action" value="create_anuidade">
                    <input type="number" name="ano" placeholder="anuidade" min="' . date("Y") . '" required><br>
                    <input type="number" name="valor" placeholder="valor da anuidade" required><br>
                    <button type="submit">Cadastrar</button><br>
                </form>
                ';
            }
        -->