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
    $acesso = trim($_POST['acesso']);
    $senha = $_POST['senha'];

    // Consulta no SQL para buscar o usuário no banco de dados
    $sql = "SELECT USU_ID, USU_SENHA FROM tbl_usuario WHERE USU_LOGIN = :acesso";
    
    try {
        $statement = $conexao->prepare($sql);
        $statement->bindParam(':acesso', $acesso);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $senhaHashArmazenada = $row['USU_SENHA'];

            // Verificando a senha fornecida com o hash armazenado
            if (password_verify($senha, $senhaHashArmazenada)) {
                $_SESSION['usu_id'] = $row['USU_ID'];
                $_SESSION['acesso'] = $acesso;

                echo json_encode([
                    "acesso" => $acesso,
                    "status" => "logado"
                ]);
            } else {
                echo json_encode(["status" => "nao_logado"]);
                header('HTTP/1.0 401 Unauthorized');
                session_destroy();
            }
        } else {
            echo json_encode(["status" => "nao_logado"]);
            header('HTTP/1.0 401 Unauthorized');
            session_destroy();
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "erro", "message" => $e->getMessage()]);
    }
    exit();
}
?>