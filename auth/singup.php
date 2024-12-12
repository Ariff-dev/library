<?php

require_once '../db/db_config.php';

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Singup</title>
</head>

<body>
    <h1>¡Unete a esta gran librería!</h1>

    <?php

    function iduser()
    {
        $idgenerada = uniqid();

        return $idgenerada;
    }
    // Ahora puedes utilizar la variable $conn

    $stmt = $conn->prepare("SELECT * FROM usuarios");
    $stmt->execute();

    // Obtiene los datos de la consulta
    $resultados = $stmt->fetchAll();

    // Imprime los resultados
    foreach ($resultados as $resultado) {
        echo "ID: " . $resultado['id_usuario'] . "<br>";
        echo "Nombre: " . $resultado['nombreusr'] . "<br>";
        echo "Email: " . $resultado['password'] . "<br>";
        echo "Contraseña: " . $resultado['email'] . "<br>";
        echo "<hr>";
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $id_usuario = iduser();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Validación de datos
        if (empty($name) || empty($email) || empty($password)) {
            echo "Por favor, complete todos los campos.";
            exit;
        }
        // Encriptación de la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        // Creación del usuario
        try {
            $stmt = $conn->prepare("INSERT INTO usuarios (id_usuario,nombreusr, password, email) VALUES (:idusr,:nombre, :password, :email)");
            $stmt->bindParam(':idusr', $id_usuario);
            $stmt->bindParam(':nombre', $name);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo "Usuario creado correctamente!";
                header("Location: confirmacion.php");
                exit;
            } else {
                echo "Error al crear el usuario.";
            }
        } catch (PDOException $e) {
            echo "Error al crear el usuario: " . $e->getMessage();
        }
    }
    // ...
    ?>

    <form method="post">
        <label for="username">
            Nombre de usuario
            <input type="text" name="name" id="auth-name" required>
        </label>
        <label for="usernmae">
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