<?php

include_once("database.php");

// Verificar se o ID da atividade foi enviado
if(isset($_POST['id'])) {
    $idAtividade = $_POST['id'];

    $sql = "UPDATE tbl_atividade SET ATV_STATUS = '1' WHERE ATV_ID = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $idAtividade, PDO::PARAM_INT);

    // Executar a consulta preparada
    if($stmt->execute()) {
        echo "sucesso";
    } else {
        echo "erro";
    }
} else {
    echo "ID da atividade não recebido";
}
