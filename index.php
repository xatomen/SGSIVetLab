<?php 

// Conexión a la BD
require_once './config/database.php';

// Ejemplo de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['password'];

    // Consultar la base de datos
    $stmt = $conn->prepare("SELECT * FROM Credenciales WHERE Usuario = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header('Location: pagina_principal.php');
    } else {
        // Inicio de sesión fallido
        echo "Usuario o contraseña incorrectos";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SGSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container w-25 text-center align-middle">
    <div class="card">
        <form method="POST" action="database.php">
            <div class="md m-3">
                <label for="exampleInputEmail1" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="user" name="user">
            </div>
            <div class="md m-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="md m-3">
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            </div>
        </form>
    </div> 
    
</div>




</body>
</html>