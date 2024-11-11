<?php 
    /* conexao com o MySQL para usar como bd */

    //data source name ou dsn
    $dsn = "mysql:host=localhost;dbname=gerencia_devs";

    //usarei nome do usuario e senha padroes que vem junto ao software XAMPP
    //mas pode ser mudado caso seu usuario e senha sejam outros :)
    $dbusername = "root";
    $dbpassword = "";


    $pdo = conectToMysql($dsn, $dbusername, $dbpassword);
    
    //criei esta variavel para fazer a função de controller
    $navegacao = $_GET['navegacao'] ?? '';

    /* todas as funcoes da aplicacao */

    //ver se o formulario de cadastro de associado foi enviado e qual o tipo de cadastro sera feio
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'] ?? '';
        
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

    //funcao responsavel por conectar no banco MySQL
    function conectToMysql($dsn, $dbusername, $dbpassword) {
        try {
            $pdo = new PDO($dsn, $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Falha na conexão: ' . $e->getMessage());
        }
    }

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
                echo "<p>Já existe um associado cadastrado com o email ou CPF fornecido.</p>";
                echo "<button onclick='window.location.href=\"\";'>Voltar</button>";
                return;
            }

            //criando a query responsável por inserir o associado no bd
            $query = "INSERT INTO associado (name, email, cpf) VALUES (?,?,?);";

            //preparar e inserir na string
            $statement = $pdo->prepare($query);
            $statement->execute([$name, $email, $cpf]);

            //apenas para limpar o espaço da memoria
            $statement = null;

            // Mensagem de confirmação e botão para voltar
            echo "<p>Associado cadastrado com sucesso!</p>";
            echo "<button onclick='window.location.href=\"\";'>Voltar</button>";

            die();

        } catch (PDOException $e) {
            die("falha na inserção: " . $e->getMessage());
        }
    }

    //funcao responsavel por deletar um associado \'DELETE'/
    function deleteAssociado(){}

    //funcao responsavel por ATUALIZAR um associado \'PUT'/
    function updateAssociado(){}

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
                echo "<p>Já existe uma anuidade cadastrada para o ano $ano.</p>";
                echo "<button onclick='window.location.href=\"\";'>Voltar</button>";
                return;
            }

            //criando a query responsável por inserir o associado no bd
            $query = "INSERT INTO anuidade (a_year, a_value) VALUES (?,?);";

            //preparar e inserir na string
            $statement = $pdo->prepare($query);
            $statement->execute([$ano, $valor]);

            createPagamento($ano);

            //apenas para limpar o espaço da memoria
            $statement = null;

            // Mensagem de confirmação e botão para voltar
            echo "<p>anuidade cadastrada com sucesso!</p>";
            echo "<button onclick='window.location.href=\"\";'>Voltar</button>";

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

    //criar a tabela pagamento para os associados
    function createPagamento($ano){
        global $pdo;
        try {
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
        } catch (PDOException $e) {
            die("falha na inserção: " . $e->getMessage());
        }
    }

    function updatePagamento($id){
        global $pdo;
        try {
           
        } catch (PDOException $e) {
            die("falha na atualização: " . $e->getMessage());
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>site</title>
        <style>

        </style>
    </head>
    <body>
        <?php 
            if($navegacao == "cadastro_associado"){
                echo
                '<h3>Cadastrar Associado</h3>
                <form action="" method="post">
                    <input type="hidden" name="action" value="create_associado">
                    <input type="text" name="name" placeholder="nome e sobrenome" required><br>
                    <input type="email" name="email" placeholder="email do associado" required><br>
                    <input type="text" name="cpf" placeholder="cpf do associado" required><br>
                    <button type="submit">Cadastrar</button><br>
                </form>';
            }else if($navegacao == "cadastro_anuidade"){
                echo 
                '
                <h3>Cadastrar anuidade</h3>
                <form action="" method="post">
                <input type="hidden" name="action" value="create_anuidade">
                    <input type="number" name="ano" placeholder="anuidade" min="' . date("Y") . '" required><br>
                    <input type="number" name="valor" placeholder="valor da anuidade" required><br>
                    <button type="submit">Cadastrar</button><br>
                </form>
                ';
            }else{
                echo 
                '
                <h1>Navegação</h1>
                <ul>
                    <li><a href="?navegacao=cadastro_anuidade">Anuidade</a></li>
                    <li><a href="?navegacao=cadastro_associado">Associados</a></li>
                    <li>Sobre</li>
                </ul>
                ';
            }
        ?>
        <!-- 
            <h3>Cadastrar Associado</h3>
            <form action="" method="post">
                <input type="text" name="name" placeholder="nome e sobrenome" require><br>
                <input type="email" name="email" placeholder="email do associado" require><br>
                <input type="text" name="cpf" placeholder="cpf do associado" require><br>
                <button type="submit">Cadastrar</button><br>
            </form>
        -->
    </body>
</html>



