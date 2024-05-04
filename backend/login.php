<?php
session_start();

require_once("database.php");

if ($_POST["operation"] == 'load') {

	if (isset($_SESSION["login"])) {
		echo '{ "acesso" : "' . $_SESSION["acesso"] .
			'", "senha" : "' . $_SESSION["senha"] . '" }';
	} else {
		echo '{ "nome" : "undefined" }';
	}
    
} else if ($_POST["operation"] == 'login') {

    $acesso = $_SERVER['PHP_AUTH_USER'];
    $senha = $_SERVER['PHP_AUTH_PW'];

    $_SESSION['acesso'] = $acesso;
    $_SESSION['senha'] = $senha; 

    //consulta no sql para buscar o usuário no banco de dados
    $sql = "SELECT * FROM tbl_usuario WHERE USU_LOGIN = '$acesso' AND USU_SENHA = '$senha'";

    $result = $conexao->query($sql);

    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Salva o ID do usuário na sessão para uso posterior
        //$_SESSION['usu_id'] = $usu_id;

        echo '{ "acesso" : "' . $acesso .
            '", "senha" : "' . $senha .
            '", "status" : "logado" }';
    } else {
        // Usuário não encontrado
        echo '{ "status" : "nao_logado" }';
        header('HTTP/1.0 401 Unauthorized');
        session_destroy();
        exit();
    }
}

exit();
