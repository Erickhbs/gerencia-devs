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

    $page = isset($_GET['navegacao']) ? $_GET['navegacao'] : 'inicio';

    /* todas as funcoes da aplicacao */

    //ver se o formulario de cadastro de associado foi enviado e qual o tipo de cadastro sera feio
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

    function message($message, $success = true){
        return [
            'message' => $message,
            'success' => $success
        ];
    }

    //funcao responsavel por conectar no banco MySQL
    function conectToMysql($dsn, $dbusername, $dbpassword) {
        try {
            $pdo = new PDO($dsn, $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die(message("Falha na conexão". $e->getMessage(), false));
        }
    }   

    //funcao para ver se ja existe um associado com o mesmo cpf e/ou email
    function seeIfAssociadoExists($email, $cpf) {
        global $pdo;
        $query = "SELECT COUNT(*) FROM associado WHERE email = ? OR cpf = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$email, $cpf]);
        $associadoExistente = $statement->fetchColumn();
        return $associadoExistente > 0;
    }

    //funcao para ver se ja existem pagamentos para esse associado
    function seeIfPaymentExists($associadoId) {
        global $pdo;
        $query = "SELECT COUNT(*) FROM pagamento WHERE associado_id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$associadoId]);
        $pagamentosExistentes = $statement->fetchColumn();
        return $pagamentosExistentes;
    }

    //funcao responsavel por inserir um novo associado \'POST'/
    function createAssociado($name, $email, $cpf){
        global $pdo;
        try {

            // Verifica se já existe um associado com o mesmo email ou CPF
            if (seeIfAssociadoExists($email, $cpf)) {
                echo "<p>Já existe um associado cadastrado com o email ou CPF fornecido.</p>";
                echo "<button onclick='window.location.href=\"\";'>Voltar</button>";
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
            echo "<p>Associado cadastrado com sucesso!</p>";
            echo "<button onclick='window.location.href=\"\";'>Voltar</button>";

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

            //criando a query responsável por inserir o associado no bd
            $query = "INSERT INTO anuidade (a_year, a_value) VALUES (?,?);";

            //preparar e inserir na string
            $statement = $pdo->prepare($query);
            $statement->execute([$ano, $valor]);

            createPagamento(null, $ano);

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
    function updatePagamento($id){
        global $pdo;
        try {
           
        } catch (PDOException $e) {
            die("falha na atualização: " . $e->getMessage());
        }
    }
?>



<!-- pagina html -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>site</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');
            * {
                font-family: 'Poppins', sans-serif;
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
            :root {
                /* CORES A SEREM USADAS */
                --body-color: #D9D9D9;
                --sidebar-color: #355E3B;
                --primary-color: #8a9a5b;
                --toggle-color: #1F2D2C;
                --text-color: #fff;
                --selection-color: #013220;
                /* TRANSIÇÕES */
                --tran-01: all 0.1 ease;
                --tran-02: all 0.2 ease;
                --tran-03: all 0.3 ease;
                --tran-04: all 0.4 ease;
                --tran-05: all 0.5 ease;
            }
            body {
                height: 100vh;
                background: var(--body-color);
            }
            .sidebar {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 275px;
                padding: 10px 14px;
                background: var(--sidebar-color);
            }
            .sidebar header {
                position: relative;
            }
            .sidebar .image-text {
                display: flex;
                align-items: center;
            }
            .sidebar .image-text .image {
                width: 60px;
                height: 60px;
                border-radius: 6px;
            }
            .sidebar header .image-text .header-text {
                display: flex;
                padding: 10px;
                flex-direction: column;
                color: var(--text-color);
            }
            .header-text .name {
                font-weight: 600;
            }
            .header-text .professional {
                margin-top: -2px;
            }
            .sidebar header .toggle {
                position: absolute;
                top: 50%;
                right: -15%;
                transform: translateY(-55%);
                height: 35px;
                width: 35px;
                background: var(--primary-color);
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                color: var(--text-color);
                font-size: 22px;
            }
            .sidebar li {
                height: 50px;
                margin-top: 10px;
                list-style: none;
                display: flex;
                align-items: center;
                padding: 0 10px;
                border-radius: 8px;
                transition: var(--tran-05);
            }
            .sidebar li a {
                display: flex;
                align-items: center;
                text-decoration: none;
                color: var(--text-color);
                width: 100%;
                padding: 10px;
            }
            .sidebar li .icon {
                font-size: 20px;
                margin-right: 8px;
                transition: var(--tran-05);
            }
            .sidebar li .text {
                font-weight: 500;
                transition: var(--tran-05);
            }
            .sidebar li:hover {
                background: var(--selection-color);
                color: var(--text-color);
            }
            .sidebar li.active {
                background: var(--selection-color);
                color: var(--text-color);
            }
            .sidebar li.active .icon,
            .sidebar li.active .text {
                color: var(--text-color);
            }

            .panel{
                height: 100vh;
                width: calc(100%-88px);
                position: relative;
                left: 275px;
                background: var(--body-color);
            }
        </style>
    </head>
    <body>
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img class="image" src="https://img.freepik.com/vetores-gratis/fundo-abstrato-gradiente-monocromatico_52683-74300.jpg" alt="fundo-abstrato-gradiente-monocromatico">
                    </span>
                    <div class="text header-text">
                        <span class="name">Gerencia dev</span>
                        <span class="professional">Administrador</span>
                    </div>
                </div>
            </header>
            <div class="menu-bar">
                <div class="menu">
                    <ul class="menu-links">
                        <li class="nav-link <?php echo ($page == 'inicio') ? 'active' : ''; ?>">
                            <a href="/gerencia_devs/">
                                <i class='bx bx-home icon'></i>
                                <span class="text nav-text">Inicio</span>
                            </a>
                        </li>
                        <li class="nav-link <?php echo ($page == 'cadastro_associado') ? 'active' : ''; ?>">
                            <a href="/gerencia_devs/?navegacao=cadastro_associado">
                                <i class='bx bx-user icon'></i>
                                <span class="text nav-text">Associados</span>
                            </a>
                        </li>
                        <li class="nav-link <?php echo ($page == 'cadastro_anuidade') ? 'active' : ''; ?>">
                            <a href="/gerencia_devs/?navegacao=cadastro_anuidade">
                                <i class='bx bx-calendar icon'></i>
                                <span class="text nav-text">Anuidade</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="panel">
            <div class="algo">
                <p>aaaaaaaaaaaaaaaaaaaaa</p>
            </div>
        </section>
    </body>
</html>



<!-- 
            <h3>Cadastrar Associado</h3>
            <form action="" method="post">
                <input type="text" name="name" placeholder="nome e sobrenome" require><br>
                <input type="email" name="email" placeholder="email do associado" require><br>
                <input type="text" name="cpf" placeholder="cpf do associado" require><br>
                <button type="submit">Cadastrar</button><br>
            </form>

            <h1>Navegação</h1>
            <"ul>
                <li><a href="?navegacao=cadastro_anuidade">Anuidade</a></li>
                <li><a href="?navegacao=cadastro_associado">Associados</a></li>
                <li>Sobre</li>
            </ul>"


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
            }
        -->