<?php 
    /* conexao com o MySQL para usar como bd */
    executeInitialSQL();

    include_once 'includes/bdh.inc.php';
    include_once 'includes/associado.inc.php';
    include_once 'includes/func-helper.inc.php';
    include_once 'includes/anuidade.inc.php';
    include_once 'includes/pagamento.inc.php';
    include_once 'includes/formhandler.inc.php';
    
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
                <br>
               <?php 
                    if($navegacao == "cadastro_associado"){
                        require './html/associadoform.php';
                        echo '<br>';
                    }else if($navegacao == "cadastro_anuidade"){
                        require './html/anuidadeform.php';
                        echo '<br>';
                    }else{
                        require './html/inicio.php';
                        echo '<br>';
                    }
               ?>
               <br>
            </div>
        </section>
    </body>
</html>