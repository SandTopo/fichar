<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
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

            
            

            
            $conn->close();
            ?>
        </select><br><br>
    </form>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
