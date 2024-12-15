<?php
require_once '../db/db_config.php';
require_once '../app/models/userManager.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Verificar si el usuario ha iniciado sesión
$id_usr = $_SESSION['id_usuario'] ?? null;

// if (!$id_usr) {
//     header("Location: /library/auth/login.php");
//     exit;
// }

// Crear una instancia de UsuarioManager
$usuarioManager = new UsuarioManager($conn);

try {
    // Obtener información del usuario
    $usuario = $usuarioManager->getUserForId($id_usr);

    if ($usuario) {
        // Mostrar información del usuario
        echo "ID: " . htmlspecialchars($usuario->getId()) . " - Nombre: " . htmlspecialchars($usuario->getNombre()) . "<br>";
    } else {
        echo "No se encontró el usuario.";
    }
} catch (Throwable $th) {
    echo "Error: " . htmlspecialchars($th->getMessage());
}

$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Si tienes estilos -->
</head>

<body>
    <main class="container">
        <?php include '../app/includes/sidebar.php'; ?>
    </main>
</body>

</html>