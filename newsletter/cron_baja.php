<?php
$modo_embebido = $modo_embebido ?? false;

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/includes/utils.php';

if (!$modo_embebido) {
    require_once __DIR__ . '/../includes/auth.php';

    if (!esAdministrativo()) {
        exit("Acceso denegado");
    }
}

// Ejecutar y mostrar bajas automáticas
$bajas = verificarYDarBajaAutomatica($conn);
?>

<h2>Bajas Automáticas del Newsletter</h2>

<?php if (!empty($bajas)) : ?>
    <h3>Suscriptores dados de baja:</h3>
    <ul>
        <?php foreach ($bajas as $u) : ?>
            <li><?= htmlspecialchars("{$u['nombre']} {$u['apellido']} - {$u['email']} (desde {$u['fecha_suscripcion']})") ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total de bajas: <?= count($bajas) ?></strong></p>
<?php else : ?>
    <p>No hay suscriptores dados de baja en este momento.</p>
<?php endif; ?>
