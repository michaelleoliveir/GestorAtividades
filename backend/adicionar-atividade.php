<?php

include_once("database.php");

$sql = "SELECT * FROM tbl_atividade";
$result = $conexao->query($sql);

$atividades = array();

if($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        $atividades[] = array(
            'atividade' => $row['atividade'],
            'date' => $row['data'],
            'status' => $row['status']
        );
    }
}

echo json_encode($atividades);