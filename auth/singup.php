<?php
session_start();
require_once '../db/db_config.php';  // Asegúrate de que esta sea la ruta correcta

// Incluye la clase UsuarioManager
require_once '../models/UsuarioManager.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validación de datos
    if (empty($name) || empty($email) || empty($password)) {
        echo "Por favor, complete todos los campos.";
        exit;
    }

    // Inicializa el manager de usuarios
    $usuarioManager = new UsuarioManager($conn);

    // Verificar si el correo ya está registrado
    if ($usuarioManager->isEmailExist($email)) {
        echo "Este usuario ya existe";
        header("Location: login.php");
        exit;
    }

    // Generar un nuevo id_usuario único
    $id_usuario = uniqid();

    // Encriptación de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Crear el nuevo usuario
    try {
        if ($usuarioManager->createUser($id_usuario, $name, $password_hash, $email)) {
            $_SESSION['id_usuario'] = $id_usuario;  // Guardar el ID del usuario en la sesión
            header("Location: ../app/index.php");
            exit;
        } else {
            echo "Error al crear el usuario.";
        }
    } catch (PDOException $e) {
        echo "Error al crear el usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <h1>¡Únete a esta gran librería!</h1>
    <form method="post">
        <label for="name">
            Nombre de usuario
            <input type="text" name="name" id="auth-name" required>
        </label>
        <label for="email">
            Email
            <input type="email" name="email" id="auth-email" required>
        </label>
        <label for="password">
            Contraseña
            <input type="password" name="password" id="auth-password" required>
        </label>
        <input type="submit" value="Crear cuenta">
    </form>
</body>

</html>