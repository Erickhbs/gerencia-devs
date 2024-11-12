<?php

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? 'tela_inicio';
    
    switch ($action) {
        case 'create_anuidade':
            $ano = sanitizeInput($_POST["ano"]);
            $valor = sanitizeInput($_POST["valor"]);
            
            if (empty($ano) || empty($valor) || !is_numeric($valor)) {
                echo "Por favor, preencha todos os campos corretamente.";
                break;
            }
            
            createAnuidade($ano, $valor);
            echo "Anuidade criada com sucesso!";
            break;

        case 'create_associado':
            $name = sanitizeInput($_POST["name"]);
            $email = sanitizeInput($_POST["email"]);
            $cpf = sanitizeInput($_POST["cpf"]);
            
            if (empty($name) || empty($email) || empty($cpf)) {
                echo "Por favor, preencha todos os campos corretamente.";
                break;
            }

            if (!preg_match("/\d{11}/", $cpf)) {
                echo "CPF inválido. Deve conter 11 dígitos.";
                break;
            }

            createAssociado($name, $email, $cpf);
            echo "Associado criado com sucesso!";
            break;

        case 'delete_associado':
            $cpf = sanitizeInput($_POST["cpf"]);
            
            if (empty($cpf)) {
                echo "Por favor, informe um CPF.";
                break;
            }

            if (!preg_match("/\d{11}/", $cpf)) {
                echo "CPF inválido.";
                break;
            }

            deleteAssociado($cpf);
            echo "Associado excluído com sucesso!";
            break;


        case 'update_anuidade':
            $ano = sanitizeInput($_POST["ano"]);
            $valor = sanitizeInput($_POST["valor"]);
            
            break;

        case 'update_pagamento':
            $ano = sanitizeInput($_POST["ano"]);
            $associadoId = sanitizeInput($_POST["valor"]);

            updatePagamento($ano, $associadoId);

            break;
            
        default:
            echo "Ação desconhecida.";
            break;
    }
}

?>
