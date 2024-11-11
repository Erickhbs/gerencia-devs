<?php

require './includes/associado.inc.php';
require './includes/anuidade.inc.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? 'tela_inicio';
    
    switch ($action) {
        case 'create_anuidade':

            //pegando os valores
            $ano = $_POST["ano"];
            $valor = $_POST["valor"];

            createAnuidade($ano, $valor);

            break;

        case 'create_associado':

            //pegando os valores
            $name = $_POST["name"];
            $email = $_POST["email"];
            $cpf = $_POST["cpf"];
            
            createAssociado($name, $email, $cpf);

            break;
            
        default:
            # code...
            break;
    }
}