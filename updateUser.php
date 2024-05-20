<?php
include('config.php');

$id = $_POST['id'];

// Busca o registro atual no banco de dados
$result = $conn->query("SELECT * FROM formulario WHERE id = $id");
$current = $result->fetch_assoc();

$nome = !empty($_POST['nome']) ? $_POST['nome'] : $current['nome'];
$data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : $current['dt_nascimento'];
$endereco = !empty($_POST['endereco']) ? $_POST['endereco'] : $current['endereco'];
$cidade = !empty($_POST['cidade']) ? $_POST['cidade'] : $current['cidade'];
$estado = !empty($_POST['estado']) ? $_POST['estado'] : $current['estado'];

// Prepara a consulta SQL para atualizar o registro
$stmt = $conn->prepare('UPDATE formulario SET nome = ?, dt_nascimento = ?, endereco = ?, cidade = ?, estado = ? WHERE id = ?');
$stmt->bind_param('sssssi', $nome, $data_nascimento, $endereco, $cidade, $estado, $id);

// Executa a consulta
$stmt->execute();

// Fecha a conexão
$stmt->close();
$conn->close();
?>