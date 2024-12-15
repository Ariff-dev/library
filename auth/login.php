<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../db/db_config.php';
require_once '../app/models/userManager.php';


$usuarioManager = new UsuarioManager($conn);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validación de datos
    if (empty($email) || empty($password)) {
        echo "Por favor, complete todos los campos.";
        exit;
    }

    // Verificación de credenciales
    $storedPassword = $usuarioManager->getPassword($email);

    if ($storedPassword && password_verify($password, $storedPassword)) {
        // Obtener información completa del usuario después de la validación
        $usuario = $usuarioManager->getUserByEmail($email);

        // Almacenar datos en sesión
        $_SESSION['id_usuario'] = $usuario->getId();
        $_SESSION['nombre_usuario'] = $usuario->getNombre();
        $_SESSION['email_usuario'] = $usuario->getEmail();

        // Redirigir al dashboard o área principal
        header("Location:  ../app/index.php");
        exit;
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>¡Qué bueno verte!</h1>
    <form method="post">
        <label for="email">
            Tu email
            <input type="email" name="email" id="auth-email" required>
        </label>
        <br>
        <label for="password">
            Contraseña
            <input type="password" name="password" id="auth-password" required>
        </label>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>

</html>