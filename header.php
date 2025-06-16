<header>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config.php';
    ?>

    <div class="logo">
        <a href="<?= BASE_URL ?>index.php">SCA <span>SOFTWARE</span></a>
    </div>

    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
            <li><a href="<?= BASE_URL ?>nosotros.php">Nosotros</a></li>
            <li><a href="<?= BASE_URL ?>productos.php">Productos</a></li>
            <li><a href="<?= BASE_URL ?>servicios.php">Servicios</a></li>
            <li><a href="<?= BASE_URL ?>ifts/login.php">IFTS</a></li>
        </ul>
    </nav>

    <?php if (isset($_SESSION["usuario_id"])): ?>
        <span>Bienvenido, <?= htmlspecialchars($_SESSION["usuario_nombre"] ?? '') ?></span>
        <a href="<?= BASE_URL ?>login/logout.php" class="login-btn">SALIR</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>login/login.php" class="login-btn">INGRESAR</a>
    <?php endif; ?>
</header>
