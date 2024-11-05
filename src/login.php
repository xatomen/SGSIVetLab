<?php 

// Conexión a la BD
require_once './config/database.php';

// Ejemplo de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar la base de datos
    $stmt = $conn->prepare("SELECT * FROM Credenciales WHERE Usuario = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    echo $user['Usuario'];
    echo $user['Contrasenha'];

    if ($user && $password==$user['Contrasenha']) {
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
        echo "Usuario o contraseña incorrectos";
    }
}
?>