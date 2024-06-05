<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "1234";
$database = "ficahje";

if (isset($_POST["dni"])) {
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $dni = $_POST["dni"];
    $pass = $_POST["password"];
    $sql = "SELECT * FROM user WHERE dni = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $dni, $pass);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if a row was returned
    if ($result->num_rows > 0) {
        // Output data of each row
        $usuario = $result->fetch_assoc();
        $idUser = $usuario['id']; // Assuming 'id' is the primary key in the 'user' table
        
        // Store the user ID in session for later use
        $_SESSION['idUser'] = $idUser;
    } else {
        $error = "Usuario no encontrado";
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

if (isset($_POST["checkin"])) {
    $idUser = $_SESSION['idUser'];
    $checkin_time = date('Y-m-d H:i:s');
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql_insert = "INSERT INTO jornada (idUser, entrada) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("is", $idUser, $checkin_time);
    $stmt_insert->execute();
    
    // Close the insert statement and connection
    $stmt_insert->close();
    $conn->close();

    echo "Hora de entrada registrada: " . $checkin_time;
}

if (isset($_POST["checkout"])) {
    $idUser = $_SESSION['idUser'];
    $checkout_time = date('Y-m-d H:i:s');
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql_update = "UPDATE jornada SET salida = ? WHERE idUser = ? AND salida IS NULL";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $checkout_time, $idUser);
    $stmt_update->execute();
    
    // Close the update statement and connection
    $stmt_update->close();
    $conn->close();

    echo "Hora de salida registrada: " . $checkout_time;
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql_users = "SELECT u.dni, j.entrada, j.salida FROM user u JOIN jornada j ON u.id = j.idUser";
$result_users = $conn->query($sql_users);

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Fichar/Salir</h1>
    <form action="" method="post">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Validar">
    </form>
    <hr>
<?php
if (isset($usuario)) {
    echo '
    <form action="" method="post">
        <input type="hidden" name="checkin" value="1">
        <input type="submit" value="Registrar Hora de Entrada">
    </form>
    <form action="" method="post">
        <input type="hidden" name="checkout" value="1">
        <input type="submit" value="Registrar Hora de Salida">
    </form>
    ';
} else {
    echo isset($error) ? $error : "";
}

if ($result_users->num_rows > 0) {
    echo "<h2>Usuarios que han fichado</h2>";
    echo "<table border='1' align='center'>
        <tr>
            <th style='background-color: #f5f5dc;'>DNI</th>
            <th style='background-color: #faebd7;'>Hora de Entrada</th>
            <th style='background-color: #f5f5dc;'>Hora de Salida</th>
        </tr>";
    while($row = $result_users->fetch_assoc()) {
        echo "<tr>";
echo "<td style='background-color: #f5f5dc;'>" . $row["dni"] . "</td>";
echo "<td style='background-color: #faebd7;'>" . $row["entrada"] . "</td>";
echo "<td style='background-color: #f5f5dc;'>" . $row["salida"] . "</td>";
echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay usuarios que hayan fichado.";
}
?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>