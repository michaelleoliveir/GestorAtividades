<?php

require_once("database.php");

$sql = $conexao->query("SELECT * FROM tbl_atividade");

if($sql && $sql->rowCount() > 0) {
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $atividades[] = $row;
    }
}