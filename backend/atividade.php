<?php

session_start();
$id = $_SESSION['usu_id'];

//pegando os dados que foram inseridos
$titulo = trim($_POST['titulo']);
$descricao = trim($_POST['descricao']);
$criacao = trim($_POST['criacao']);
$conclusao = trim($_POST['conclusao']);

//verificando dados preenchidos
if(empty($titulo) || empty($descricao) || empty($criacao) || empty($conclusao)) {
    echo "Há registros em branco!";
    return;
}

$data_conclusao = new DateTime($conclusao);
$conclusao_varchar = date_format($data_conclusao, 'Y-m-d');

$data_criacao = new DateTime($criacao);
$criacao_varchar = date_format($data_criacao, 'Y-m-d');

// criando uma verificação nas datas inseridas
if ($criacao_varchar > $conclusao_varchar) {
    echo "A data de criação não pode ser posterior à data de conclusão!";
    return;
}

//incluindo o arquivo do banco de dados
require_once("database.php");

//inserindo dados no banco
$sql = "INSERT INTO tbl_atividade (ATV_TITULO, ATV_DESCRICAO, ATV_DT_CRIACAO, ATV_DT_CONC, ATV_STATUS, USU_ID) VALUES (:titulo, :descricao, :criacao, :conclusao, '0', :id)";

try {
    $statement = $conexao->prepare($sql);

    $statement->bindParam(':titulo', $titulo);
    $statement->bindParam(':descricao', $descricao);
    $statement->bindParam(':conclusao', $conclusao_varchar);
    $statement->bindParam(':criacao', $criacao_varchar);
    $statement->bindParam(':id', $id);

    if($statement->execute()) {
        echo "sucesso";
    } else {
        echo "Falha ao inserir o registro";
    }
} catch (PDOException $e) {
    echo "Erro ao inserir o registro: " . $e->getMessage();
}

unset($conexao);