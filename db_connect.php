<?php
// admin/db_connect.php

$servername = "localhost";
$username = "root"; // seu usuário
$password = ""; // sua senha
$dbname = "olpermotors_shop"; // nome do banco de dados


// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>