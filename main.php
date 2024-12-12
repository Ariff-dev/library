<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
</head>

<body>
    <?php

    function goLogin()
    {
        header("Location: ./auth/login.php");
        exit;
    }

    function goSingup()
    {
        header("Location: ./auth/singup.php");
        exit;
    }

    if (isset($_POST['login'])) {
        goLogin();
    }

    if (isset($_POST['singup'])) {
        goSingup();
    }

    ?>
    <h1>Bienvenidos a mi librería</h1>
    <p>Aqui encontraras todo tipo de libros</p>
    <form method="POST">
        <input type="submit" name="login" value="Iniciar Sesión">
        <input type="submit" name="singup" value="Crear Cuenta">
    </form>

</body>


</html>