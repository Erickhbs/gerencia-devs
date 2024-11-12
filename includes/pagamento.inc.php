<?php

    //funcao para ver se ja existem pagamentos para esse associado
    function seeIfPaymentExists($associadoId) {
        global $pdo;
        $query = "SELECT COUNT(*) FROM pagamento WHERE associado_id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$associadoId]);
        $pagamentosExistentes = $statement->fetchColumn();
        return $pagamentosExistentes;
    }


    //funcao para criar a tabela pagamento para o associados apos a criacao de uma nova anuidade
    function createPagamento($associadoId, $ano){
        global $pdo;
        try {
            if($associadoId == null){
                $query = "SELECT id FROM associado;";
                $statement = $pdo->prepare($query);
                $statement->execute();
                $associados = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                 // Inserir um registro de pagamento para cada associado para a nova anuidade
                $query = "INSERT INTO pagamento (associado_id, ano) VALUES (?, ?);";
                $statement = $pdo->prepare($query);
                
                foreach ($associados as $associado) {
                    $statement->execute([$associado['id'],$ano]);
                }
                return;
            }

            // Insere o pagamento para o associado e a anuidade
            $query = "INSERT INTO pagamento (associado_id, ano) VALUES (?, ?);";
            $statement = $pdo->prepare($query);
            $statement->execute([$associadoId, $ano]);

            // Limpar a memória
            $statement = null;
           
        } catch (PDOException $e) {
            die("falha na inserção: " . $e->getMessage());
        }
    }

    //funcao para criar pagamentos para a anuidade do ano e para os anos seguintes (se existir)
    function createPagamentoPerAnuidade($associadoId){
        global $pdo;
        try {
            //anuidades no o ano atual e seguintes
            $query = "SELECT a_year FROM anuidade WHERE a_year >= ? ORDER BY a_year ASC";
            $statement = $pdo->prepare($query);
            $statement->execute([date("Y")]);
            $anuidades = $statement->fetchAll(PDO::FETCH_ASSOC);

            //Chama a função createPagamento para cada anuidade encontrada
            foreach ($anuidades as $anuidade) {
                createPagamento($associadoId, $anuidade['a_year']);
            }
        } catch (PDOException $e) {
            die("falha ao criar pagamentos: " . $e->getMessage());
        }
    }




    //funcacao para atualizar o pagamento
    function updatePagamento($ano, $associadoId) {
        global $pdo;
        try {
            // Corrigindo a consulta SQL
            $query = "UPDATE pagamento SET pago = true WHERE ano = ? AND associado_id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$ano, $associadoId]);
        } catch (PDOException $e) {
            die("Falha ao atualizar pagamento do associado: " . $e->getMessage());
        }
    }
    

    function debtPagamento($associadoId) {
        global $pdo;
        try {
            $query = "SELECT * FROM pagamento WHERE associado_id = ?;";
            $statement = $pdo->prepare($query);
            $statement->execute([$associadoId]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Falha ao carregar pagamentos: " . $e->getMessage());
        }
    }
    

    function deletePagamento($associadoId) {
        global $pdo;
        try {
            $query = "DELETE FROM pagamento WHERE associado_id = ?;";
            $statement = $pdo->prepare($query);
            $statement->execute([$associadoId]);
            
        } catch (PDOException $e) {
            die("Falha ao apagar pagamento: " . $e->getMessage());
        }
    }