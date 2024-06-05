<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registro</title>
    
</head>
<body>
    <h1>Registrar usuario</h1>

    
    <form action="regis.php" method="post">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="text" id="password" name="password" required><br><br>
        <input type="submit" value="Registrar">
    </form>
    <?php
            
            $servername = "localhost";
            $username = "root";
            $password = "1234";
            $database = "ficahje";

            $conn = new mysqli($servername, $username, $password, $database);

            
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            
            $sql = "SELECT id, dni, password FROM user";
            $result = $conn->query($sql);

            
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['dni'] . " " . $row['password'] . "</option>";
            }

            
            $conn->close();
            ?>
        </select><br><br>
    </form>
    </body>
</html>
