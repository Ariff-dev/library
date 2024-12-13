<!-- app/includes/sidebar.php -->
<aside>
    <ul>
        <li><a href="/library/app/views/home.php" class="<?php echo ($activePage == 'home') ? 'active' : ''; ?>">Inicio</a></li>
        <li><a href="/library/app/views/createpost.php" class="<?php echo ($activePage == 'createpost') ? 'active' : ''; ?>">Crear Reseña</a></li>
        <li><a href="/library/app/views/adminposts.php" class="<?php echo ($activePage == 'adminposts') ? 'active' : ''; ?>">Panel Administrativo</a></li>
        <li>
            <form action="/library/app/logout.php" method="POST"> <!-- Cambia la acción a la URL de cierre de sesión -->
                <input type="submit" value="Cerrar Sesión">
            </form>
        </li>
    </ul>
</aside>