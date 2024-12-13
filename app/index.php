<?php
session_start();
require_once '../db/db_config.php';

$id_usr =  $_SESSION['id_usuario'];

echo $id_usr;

$name;


if (isset($id_usr)) {
    try {

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = :idusr");

        $stmt->bindParam(":idusr", $id_usr);

        $stmt->execute();

        $result = $stmt->fetch();

        echo $result;
        if ($result) {
            // Mostrar el resultado
            echo "ID: " . $result['id_usuario'] . " - Nombre: " . $result['nombreusr'] . "<br>";
        } else {
            echo "No se encontró el usuario.";
        }
    } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage(); // Mostrar el mensaje de error
    }
} else {
    header("Location: /library/login.php");
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
        <?php include  '../app/includes/sidebar.php'; ?>
        <?php include  '../includes/sidebar.php'; ?>


    </main>
</body>

</html>