<header>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config.php';
    ?>
    <div class="logo">
        <a href="<?= BASE_URL ?>index.php"><img src="<?= BASE_URL ?>img/logo33.png" alt="Logo ScaSoftware"></a>
    </div>
    <?php if (isset($_SESSION["usuario_id"])): ?>
        <span class="usuario-bienvenida">Bienvenido, <?= htmlspecialchars($_SESSION["usuario_nombre"] ?? '') ?></span>
    <?php endif; ?>
    <button class="hamburger" aria-label="Alternar menú">☰</button>
    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
            <li><a href="<?= BASE_URL ?>nosotros.php">Nosotros</a></li>
            <li><a href="<?= BASE_URL ?>productos.php">Productos</a></li>
            <li><a href="<?= BASE_URL ?>servicios.php">Servicios</a></li>
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <li><a href="<?= BASE_URL ?>panel.php">Panel</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <li><a href="login/logout.php" class="login-link">Salir</a></li>
            <?php else: ?>
                <li><a href="login/login.php" class="login-link">Ingresar</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php if (isset($_SESSION["usuario_id"])): ?>
        <a href="<?= BASE_URL ?>login/logout.php" class="login-btn">SALIR</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>login/login.php" class="login-btn">INGRESAR</a>
    <?php endif; ?>
</header>
<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('nav');

    hamburger.addEventListener('click', () => {
        nav.classList.toggle('active');
        hamburger.textContent = nav.classList.contains('active') ? '✕' : '☰';
    });
</script>
