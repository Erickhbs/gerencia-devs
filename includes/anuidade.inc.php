<?php

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
            echo "nada feito";
        }

        $query = "INSERT INTO anuidade (a_year, a_value) VALUES (?,?);";

        $statement = $pdo->prepare($query);
        $statement->execute([$ano, $valor]);

        createPagamento(null, $ano);

        $statement = null;

        

        die();

    } catch (PDOException $e) {
        die("falha na inserção: " . $e->getMessage());
    }
}

function updateAnuidade($ano, $valor) {
    global $pdo;
    try {
        $query = "UPDATE anuidades SET valor = ? WHERE ano = ?";
        $statement = $pdo->prepare($sql);
        $stmt->execute([$valor, $ano]);

    } catch (PDOException $e) {
        echo "Erro ao atualizar anuidade: " . $e->getMessage();
    }
}


function getAnuidades(){
    global $pdo;

    $query = "SELECT * FROM anuidade";

    //preparar e inserir na string
    $statement = $pdo->prepare($query);
    $statement->execute();
    $anuidades = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $anuidades;
}