<?php

// pegando os dados que foram inseridos no frontend
$nome = trim($_POST['nome']);
$sobrenome = trim($_POST['sobrenome']);
$nascimento = trim($_POST['nascimento']);
$senha = $_POST['senha'];
$acesso = trim($_POST['acesso']);

//verificando dados
if (empty($nome) || empty($sobrenome) || empty($nascimento) || empty($senha) || empty($acesso)) {
    echo "Há registros em branco";
    return;
}

// Hash da senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

//incluindo arquivo de configuração do banco de dados
require_once("database.php");

//inserindo dados no banco
$sql = "INSERT INTO tbl_usuario (USU_NOME, USU_SOBRENOME, USU_DTNASC, USU_SENHA, USU_LOGIN) VALUES (:nome, :sobrenome, :nascimento, :senha, :acesso)";

try {
    $statement = $conexao->prepare($sql);
    $statement->bindParam(':nome', $nome);
    $statement->bindParam(':sobrenome', $sobrenome);
    $statement->bindParam(':nascimento', $nascimento);
    $statement->bindParam(':acesso', $acesso);
    $statement->bindParam(':senha', $senhaHash); // Usando a senha hasheada
    
    if ($statement->execute()) {
        echo "sucesso";
    } else {
        echo "Falha ao inserir o registro";
    }
} catch (PDOException $e) {
    echo "Erro ao inserir o registro: " . $e->getMessage();
}

// fechando a conexão com o banco de dados
unset($conexao);

