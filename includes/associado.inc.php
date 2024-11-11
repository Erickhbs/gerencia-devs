<?php
require './includes/bdh.inc.php';
require './includes/pagamento.inc.php';

function seeIfAssociadoExists($email, $cpf) {
    global $pdo;
    $query = "SELECT COUNT(*) FROM associado WHERE email = ? OR cpf = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$email, $cpf]);
    $associadoExistente = $statement->fetchColumn();
    return $associadoExistente > 0;
}

//funcao responsavel por inserir um novo associado \'POST'/
function createAssociado($name, $email, $cpf){
    global $pdo;
    try {

        // Verifica se já existe um associado com o mesmo email ou CPF
        if (seeIfAssociadoExists($email, $cpf)) {
            return;
        }

        //criando a query responsável por inserir o associado no bd
        $query = "INSERT INTO associado (name, email, cpf) VALUES (?,?,?);";

        //preparar e inserir na string
        $statement = $pdo->prepare($query);
        $statement->execute([$name, $email, $cpf]);

        //apenas para limpar o espaço da memoria
        $statement = null;
        $query = null;

        // Pegando o id do novo associado
        $associadoId = $pdo->lastInsertId();
        //criando as tabelas pagementos para o novo associado
        if(seeIfPaymentExists($associadoId) == 0){
            createPagamentoPerAnuidade($associadoId);
        }

        die();


    } catch (PDOException $e) {
        die(response("Falha na inserção: " . $e->getMessage(), false));
    }
}

//funcao responsavel por deletar um associado \'DELETE'/
function deleteAssociado(){
    
}

//funcao responsavel por ATUALIZAR um associado \'PUT'/
function updateAssociado(){}