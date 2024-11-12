<?php

function message($message, $success = true){
    return [
        'message' => $message,
        'success' => $success
    ];
}

function executeInitialSQL() {
    global $pdo;
    try {
        // Conectando ao banco de dados
        // Lendo o arquivo SQL
        $sql = file_get_contents('./initial-bd.sql');

        // Executando as queries
        $pdo->execute($sql);
        
    } catch (PDOException $e) {
        echo "Erro ao executar o seed: " . $e->getMessage();
    }
}