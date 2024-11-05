<?php 

// Conexión a la BD
require_once './config/database.php';
require_once './src/login.php';
// Ejemplo de inicio de sesión
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     // Consultar la base de datos
//     $stmt = $conn->prepare("SELECT * FROM Credenciales WHERE Usuario = :username");
//     $stmt->bindParam(':username', $username);
//     $stmt->execute();
//     $user = $stmt->fetch();

//     echo $user['Usuario'];
//     echo $user['Contrasenha'];

//     if ($user && $password==$user['Contrasenha']) {
//         // Inicio de sesión exitoso
//         session_start();
//         $_SESSION['ID'] = $user['ID'];
//         $_SESSION['Usuario'] = $user['Usuario'];
//         // header('Location: pagina_principal.php');

//         // Verificar el tipo de usuario y redirigir
//         if ($user['Tipo_Usuario'] == 'Administrador') {
//             header('Location: ./public/admin.php');
//         } elseif ($user['Tipo_Usuario'] == 'Usuario') {
//             header('Location: ./public/user.php');
//         } else {
//             echo "Tipo de usuario desconocido";
//         }
//         exit;

//     } else {
//         // Inicio de sesión fallido
//         echo "Usuario o contraseña incorrectos";
//     }
// }
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
        <form method="POST" action="">
            <div class="md m-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="md m-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="md m-3">
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            </div>
        </form>
    </div> 
    
</div>




</body>
</html>