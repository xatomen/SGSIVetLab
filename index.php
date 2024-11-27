<?php 

// Conexión a la base de datos
include_once("config/database.php");

// Código PHP para manejar el inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM Credenciales WHERE Usuario = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && $password == $user['Contrasenha']) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['ID'] = $user['ID'];
        $_SESSION['Usuario'] = $user['Usuario'];

        // Verificar el tipo de usuario y redirigir
        if ($user['Tipo_Usuario'] == 'Administrador') {
            header('Location: ./public/admin.php');
        } elseif ($user['Tipo_Usuario'] == 'Usuario') {
            header('Location: ./public/user.php');
        } else {
            echo "Tipo de usuario desconocido";
        }
        exit;
    } else {
        // Inicio de sesión fallido
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SGSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
        }
        .login-image {
            width: 50%;
            background: url('./src/VetLab.png') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        .login-form {
            width: 50%;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-image"></div>
    <div class="login-form">
        <h2 class="text-center mb-4">Iniciar sesión</h2>
        <hr>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+"></script>

</body>
</html>