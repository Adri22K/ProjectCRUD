<?php
    include('config.php');

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM formulario WHERE id = $id";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Failed to fetch data']);
    }
    $conn->close();