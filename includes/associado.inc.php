<?php

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
                return message("Já existe um associado cadastrado com o email ou CPF fornecido", false);
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

            // Mensagem de confirmação e botão para voltar
            

            die();


        } catch (PDOException $e) {
            die(response("Falha na inserção: " . $e->getMessage(), false));
        }
    }

    //funcao responsavel por deletar um associado \'DELETE'/
    function deleteAssociado($cpf) {
        global $pdo;
        try {
            // Primeiro, obtém o id do associado baseado no CPF
            $query = "SELECT id FROM associado WHERE cpf = ?;";
            $statement = $pdo->prepare($query);
            $statement->execute([$cpf]);
    
            // Verifica se o associado foi encontrado
            $associado = $statement->fetch(PDO::FETCH_ASSOC);
            if ($associado) {
                $associadoId = $associado['id'];
    
                // Deleta os pagamentos do associado
                deletePagamento($associadoId);
    
                // Exclui o associado
                $query = "DELETE FROM associado WHERE id = ?;";
                $statement = $pdo->prepare($query);
                $statement->execute([$associadoId]);
            } else {
                throw new Exception("Associado não encontrado.");
            }
    
        } catch (PDOException $e) {
            die("Falha ao apagar associado: " . $e->getMessage());
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    function getAssociados(){
        global $pdo;

        $query = "SELECT * FROM associado";

        //preparar e inserir na string
        $statement = $pdo->prepare($query);
        $statement->execute();
        $associados = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $associados;
    }
