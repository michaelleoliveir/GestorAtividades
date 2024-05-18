<?php

require_once("../database.php");

echo "Dados recebidos: ";
var_dump($_POST);

if(isset($_POST['tituloNovo']) && isset($_POST['descricaoNovo']) && isset($_POST['id'])) {
    $novoTitulo = $_POST['tituloNovo'];
    $novoDescricao = $_POST['descricaoNovo'];
    $novoConclusao = $_POST['conclusaoNovo'];
    $idAtividade = $_POST['id'];

    $sql = "UPDATE tbl_atividade SET ATV_TITULO = :titulo, ATV_DESCRICAO = :descricao, ATV_DT_CONC = :conclusao WHERE ATV_ID = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':titulo', $novoTitulo, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $novoDescricao, PDO::PARAM_STR);
    $stmt->bindParam(':id', $idAtividade, PDO::PARAM_STR);
    $stmt->bindParam(':conclusao', $novoConclusao, PDO::PARAM_STR);

    if($stmt->execute()) {
        echo "sucesso";
    } else {
        echo "erro";
    }
} else {
    echo "dados incompletos";
}