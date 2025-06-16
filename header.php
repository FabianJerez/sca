<header>
    <script src="js/scripts.js"></script>
    <div class="logo">
        <a href="index.php">SCA <span>SOFTWARE</span></a>
    </div>
    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../nosotros.php">Nosotros</a></li>
            <li><a href="../productos.php">Productos</a></li>
            <li><a href="../servicios.php">Servicios</a></li>
            <li><a href="../ifts/login.php">IFTS</a></li>
        </ul>
    </nav>
    <?php if (isset($_SESSION["usuario_id"])): ?>
        <a href="login/logout.php" class="login-btn">SALIR</a>
    <?php else: ?>
        <a href="login/login.php" class="login-btn">INGRESAR</a>
    <?php endif; ?>
</header>