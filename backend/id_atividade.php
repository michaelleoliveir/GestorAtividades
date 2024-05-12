<?php

require_once("./database.php");

if(isset($_GET['id'])) {
    $idAtividade = $_GET['id'];

    $sql = "SELECT * FROM tbl_atividade WHERE ATV_ID = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $idAtividade, PDO::PARAM_INT);
    $stmt->execute();

    $atividade = $stmt->fetch(PDO::FETCH_ASSOC);

    if($atividade) {
        echo json_encode($atividade);
    } else {
        echo json_encode(array("error" => "Atividade não encontrada"));
    }
} else {
    echo json_encode(array("error" => "ID da atividade não fornecido"));
}

