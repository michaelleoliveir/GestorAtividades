<?php

require_once("../database.php");
session_start();
$id = $_SESSION['usu_id'];

$query = "SELECT * FROM tbl_atividade where USU_ID = $id";
$stmt = $conexao->prepare($query);
$stmt->execute();

$atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// retorna atividades como json
echo json_encode($atividades);