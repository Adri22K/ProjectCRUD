<?php
session_start();
include_once 'config.php';

if ($conn->connect_error) {
    die("Conexão com o banco de dados falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $id = $conn->real_escape_string($id);

    $sql = "DELETE FROM Formulario WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro deletado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>