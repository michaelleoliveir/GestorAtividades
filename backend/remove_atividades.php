<?php
// Incluir o arquivo de configuração com a conexão PDO
require_once("database.php");

// Verificar se o ID da atividade foi enviado
if(isset($_POST['id'])) {
    $idAtividade = $_POST['id'];

    $sql = "DELETE FROM tbl_atividade WHERE ATV_ID = :id";

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
?>
