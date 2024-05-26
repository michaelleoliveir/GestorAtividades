<?php
session_start();

require_once("./backend/database.php");

// Função para enviar cabeçalho de autenticação
function sendAuthHeader() {
    header('WWW-Authenticate: Basic realm="Área do Gestor"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Autenticação necessária.';
    exit;
}

// Verificação das credenciais
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    sendAuthHeader();
} else {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    // Consulta no banco de dados para buscar o hash da senha do usuário
    $sql = "SELECT USU_SENHA FROM tbl_usuario WHERE USU_LOGIN = :username";
    $statement = $conexao->prepare($sql);
    $statement->bindParam(':username', $username);
    $statement->execute();

    // Verifica se o usuário existe
    if ($statement->rowCount() == 1) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $hash = $row['USU_SENHA'];

        // Verifica a senha fornecida com o hash armazenado
        if (password_verify($password, $hash)) {
            // Credenciais válidas, prosseguir com a autenticação
            echo 'Autenticação bem-sucedida.';
        } else {
            // Senha incorreta
            sendAuthHeader();
        }
    } else {
        // Usuário não encontrado
        sendAuthHeader();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/login-signin.css">
    <link rel="stylesheet" href="./style/gestor-page.css">

    <!-- links referentes ao bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!--link da fonte INTER-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>Gestor</title>

</head>

<body style="font-family: Inter; background-color: #87858ccf;">
    <section class="gradient-form">
        <div class="container h-100">
            <div class="col py-5">
                <div class="row-xl-10">
                    <div class="justify-content-center">
                        <div class="d-flex justify-content-between">

                            <form action="gestor-page.html" method="post">
                                <a href="login-page.html" style="text-decoration: none;">
                                    <button class="btn-link"
                                        style="margin-bottom: 10px; font-size: 30px; color: #0A2647; text-decoration: none;">
                                        <i class="ri-logout-box-r-fill"></i>
                                    </button>
                                </a>
                            </form>
                        </div>

                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-12"
                                    style="background-color: rgba(245, 245, 245, 0.648);border-radius: 15px; padding: 15px;">

                                    <div class="text-center" style="padding: 15px 0px 20px 0px;">
                                        <h1 class="titulo">Área Administrativa</h1>
                                        <br/>
                                        <h4 class="titulo">Em desenvolvimento</h2>
                                    </div>
                                   
                                    
                                    <div class="container-fluid">
                                        <div class="row content-center" id="atividades">
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        </div>

</body>

</html>