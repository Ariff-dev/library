<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../db/db_config.php'; // Ajustar la ruta si es necesario
require_once '../app/models/userManager.php'; // Ajustar la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        echo "Por favor, complete todos los campos.";
        exit;
    }

    $usuarioManager = new UsuarioManager($conn);

    if ($usuarioManager->isEmailExist($email)) {
        echo "Este usuario ya existe.";
        header("Location: login.php");
        exit;
    }

    $id_usuario = uniqid('user_');
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        if ($usuarioManager->createUser($id_usuario, $name, $password_hash, $email)) {
            $_SESSION['id_usuario'] = $id_usuario;
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