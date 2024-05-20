<?php
session_start();
include_once 'config.php';

if ($conn->connect_error) {
    die("Conexão com o banco de dados falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $nome = $conn->real_escape_string($nome);
    $data_nascimento = $conn->real_escape_string($data_nascimento);
    $endereco = $conn->real_escape_string($endereco);
    $cidade = $conn->real_escape_string($cidade);
    $estado = $conn->real_escape_string($estado);

    $sql = "INSERT INTO Formulario (nome, dt_nascimento, endereco, cidade, estado) VALUES ('$nome', '$data_nascimento', '$endereco', '$cidade', '$estado')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo registro adicionado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>