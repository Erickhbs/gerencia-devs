<?php 
    function executeInitialSQL() {
        global $pdo;
        
        try {
            $sql = file_get_contents('initial-bd.sql');

            $queries = explode(';', $sql);
            
            foreach ($queries as $query) {
                if (trim($query)) {
                    $pdo->exec($query);
                }
            }

            echo "Seed executado com sucesso.";
        } catch (PDOException $e) {
            echo "Erro ao executar o seed: " . $e->getMessage();
        }
    }


    include_once 'includes/bdh.inc.php';
    include_once 'includes/associado.inc.php';
    include_once 'includes/func-helper.inc.php';
    include_once 'includes/anuidade.inc.php';
    include_once 'includes/pagamento.inc.php';
    include_once 'includes/formhandler.inc.php';
    
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