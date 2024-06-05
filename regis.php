<?php

$servername = "localhost";
$username = "root";
$password = "1234";
$database = "ficahje";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$dni = $_POST['dni'];
$contrasinal = $_POST['password'];


$sql = "INSERT INTO user (dni, password) VALUES ('$dni', '$contrasinal')";

if ($conn->query($sql) === TRUE) {
    header('Location: index.html');
    exit;
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}


$conn->close();
?>