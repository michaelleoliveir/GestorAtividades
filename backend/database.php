<?php

//ESTABELECER CONEXÃO COM O BANCO DE DADOS
$servidor = "localhost";
$usuario = "root";
$password = "";
$banco = "Gerenciador";

//conectando no servidor do banco de dados
try {
    $conexao = new PDO("mysql:host=$servidor; dbname=$banco", $usuario, $password);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
    exit();
}

