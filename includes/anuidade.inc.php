<?php
require './includes/bdh.inc.php';
require './includes/pagamento.inc.php';

//funcao para ver se ja existe uma anuidade no ano especifico
    function seeIfAnuidadeExists($ano){
        global $pdo;
        $query = "SELECT COUNT(*) FROM anuidade WHERE a_year = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$ano]);
        $anuidadeExistente = $statement->fetchColumn();
        return $anuidadeExistente;
    }

    //funcao responsavel por criar uma nova anuidade \'POST'/
    function createAnuidade($ano, $valor){
        global $pdo;
        try {

            if (seeIfAnuidadeExists($ano) > 0) {
               return;
            }

            //criando a query responsável por inserir o associado no bd
            $query = "INSERT INTO anuidade (a_year, a_value) VALUES (?,?);";

            //preparar e inserir na string
            $statement = $pdo->prepare($query);
            $statement->execute([$ano, $valor]);

            createPagamento(null, $ano);

            //apenas para limpar o espaço da memoria
            $statement = null;

            // Mensagem de confirmação e botão para voltar
            

            die();

        } catch (PDOException $e) {
            die("falha na inserção: " . $e->getMessage());
        }
    }

    //funcao responsavel por deletar uma anuidade \'DELETE'/
    function deleteAnuidadeo($ano){
        global $pdo;
        try {
           
        } catch (PDOException $e) {
            die("falha ao excluir: " . $e->getMessage());
        }
    }
