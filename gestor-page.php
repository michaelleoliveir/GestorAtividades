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

     // Consulta no banco de dados para validar as credenciais do usuário
     $sql = "SELECT * FROM tbl_usuario WHERE USU_LOGIN = :username AND USU_SENHA = :password";
     $statement = $conexao->prepare($sql);
     $statement->bindParam(':username', $username);
     $statement->bindParam(':password', $password);
     $statement->execute();

    // Verifica se as credenciais são válidas
    if ($statement->rowCount() == 0) {
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


    <script>
        $.ajax({
            method: "POST",
            url: "./backend/session_verify.php",
            data: {
                url: "gestor"
            }
        }).done(function (response) {
            if (response == 'not session') {
                window.location.href = "login-page.html"
            } else if (response == 'session') {
                window.location.href = "gestor-page.html"
            }
        });
    </script>

    <style>
        .conclusao-passada {
            color: rgba(255, 0, 0, 0.593);
        }

        .conclusao-outra {
            color: rgba(0, 0, 0, 0.466);
        }
    </style>
</head>

<body style="font-family: Inter; background-color: #87858ccf;">
    <section class="gradient-form">
        <div class="container h-100">
            <div class="col py-5">
                <div class="row-xl-10">
                    <div class="justify-content-center">
                        <div class="d-flex justify-content-between">

                            <button class="btn-link" id="creditos"
                                style="margin-bottom: 10px; font-size: 30px; color: #0A2647; text-decoration: none;">
                                <i class="ri-information-fill"></i>
                            </button>

                            <form action="./backend/logout.php" method="post">
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
                                        <h1 class="titulo">Gestor de Atividades</h1>
                                        <h4 class="titulo">Clique no botão para adicionar uma atividade</h2>
                                    </div>

                                    <div class="container-fluid">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-md-2 mb-4">
                                                <div class="card text-center justify-content-center"
                                                    style="border-radius: 100px; font-size: 35px; color: #0A2647;">
                                                    <i class="ri-add-large-fill" id="adicionar"></i>
                                                </div>
                                            </div>
                                        </div>
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

        <!-- modal de créditos -->
        <div class="modal fade" id="creditosModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header h5 justify-content-center"
                        style="background-color: #0A2647;color: aliceblue; font-weight: 600;">
                        Créditos
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage">Sistema de gestor de atividades WEB desenvolvido por: <br> <br>Júlia Toledo
                            da Silva <br>Meire Viviane dos Santos <br>Michaelle Maria Silva de Oliveira</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal para adicionar novas atividades -->
        <div class="modal fade" id="atividadesModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header h4 justify-content-center"
                        style="background-color: #0A2647;color: aliceblue; font-weight: 600;">
                        Nova Atividade
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Título</span>
                                </div>
                                <input type="text" id="titulo" name="titulo" class="form-control" aria-label="Titulo"
                                    aria-describedby="inputGroup-sizing-default" required autocomplete="off" style="background-color: white;">
                            </div>
                            <br>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Descrição</span>
                                </div>
                                <input type="text" id="descricao" name="descricao" class="form-control"
                                    aria-label="Descrição" aria-describedby="inputGroup-sizing-default" required
                                    autocomplete="off" style="background-color: white;">
                            </div>
                            <br>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Data de criação</span>
                                </div>
                                <input type="date" id="criacao" name="criacao" class="form-control" aria-label="Criação"
                                    aria-describedby="inputGroup-sizing-default" required autocomplete="off">
                            </div>
                            <br>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Data de conclusão</span>
                                </div>
                                <input type="date" id="conclusao" name="conclusao" class="form-control"
                                    aria-label="Conclusão" aria-describedby="inputGroup-sizing-default" required
                                    autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-cancelar" id="btn-cancelar" data-dismiss="modal"
                            style="background-color: #0A2647; color: aliceblue; width: 80px;">Cancelar</button>

                        <button type="button" class="btn btn-criar" id="btn-criar" data-dismiss="modal"
                            style="background-color: #0A2647; color: aliceblue; width: 80px;">Criar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal para modificar atividades -->
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header h4 justify-content-center"
                        style="background-color: #0A2647;color: aliceblue; font-weight: 500;">
                        Editar atividade
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Título</span>
                                </div>
                                <input type="text" id="titulo-novo" name="titulo-novo" class="form-control"
                                    aria-label="Titulo" aria-describedby="inputGroup-sizing-default" required
                                    autocomplete="off" style="background-color: white;">
                            </div>
                            <br>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Descrição</span>
                                </div>
                                <input type="text" id="descricao-novo" name="descricao-novo" class="form-control"
                                    aria-label="Descrição" aria-describedby="inputGroup-sizing-default" required
                                    autocomplete="off" style="background-color: white;">
                            </div>
                            <br>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default"
                                        style="font-size: 14px; font-weight: 500;">Data de conclusão</span>
                                </div>
                                <input type="date" id="conclusao-novo" name="conclusao-novo" class="form-control"
                                    aria-label="Conclusão" aria-describedby="inputGroup-sizing-default" required
                                    autocomplete="off">
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-cancelar" id="btn-cancelar" data-dismiss="modal"
                            style="background-color: #0A2647; color: aliceblue; width: 80px;">Cancelar</button>

                        <button type="button" class="btn btn-atualizar" id="btn-atualizar" data-dismiss="modal"
                            style="background-color: #0A2647; color: aliceblue; width: 80px;">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal que aparece no momento da exclusão da tarefa -->
        <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header h5 justify-content-center"
                        style="background-color: #0A2647;color: #B9B5C4; font-weight: 600;">
                        Exclusão bem sucedida
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage">Atividade excluida com sucesso!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal que aparece caso a atividade seja cadastrada -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header h5 justify-content-center"
                        style="background-color: #0A2647;color: #B9B5C4; font-weight: 600;">
                        Sucesso
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage">Atividade cadastrada com sucesso!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal que aparece caso a aconteça falha no cadastro da atividade -->
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header h5 justify-content-center"
                        style="background-color: #0A2647;color: #B9B5C4; font-weight: 600;">
                        Erro
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage">Falha ao realizar o registro da atividade</p>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/gestor-page.js"></script>
            
</body>

</html>