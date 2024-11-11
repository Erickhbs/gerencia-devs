<?php
require './includes/bdh.inc.php';

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
function updatePagamento($id){
    global $pdo;
    try {
       
    } catch (PDOException $e) {
        die("falha na atualização: " . $e->getMessage());
    }
}

function seeIfPaymentExists($associadoId) {
    global $pdo;
    $query = "SELECT COUNT(*) FROM pagamento WHERE associado_id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$associadoId]);
    $pagamentosExistentes = $statement->fetchColumn();
    return $pagamentosExistentes;
}