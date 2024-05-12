<?php

require_once("../database.php");

$query = "SELECT * FROM tbl_atividade";
$stmt = $conexao->prepare($query);
$stmt->execute();

$atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// retorna atividades como json
echo json_encode($atividades);