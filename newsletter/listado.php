<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/utils.php';

if (getUserRole() !== 'admin') {
    exit('Acceso no autorizado.');
}

// Ejecutar baja automática si aplica
verificarYDarBajaAutomatica($conn);

// Obtener suscriptores activos
$stmt = $conn->prepare("SELECT nombre, apellido, email, fecha_suscripcion FROM newsletter WHERE activo = 1 ORDER BY fecha_suscripcion DESC");
$stmt->execute();
$suscriptores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 style="margin-bottom: 10px;">Suscriptores Activos al Newsletter</h2>

<?php if ($suscriptores): ?>
    <ul style="line-height: 1.6;">
        <?php foreach ($suscriptores as $s): ?>
            <li>
                <strong><?= htmlspecialchars($s['nombre']) ?> <?= htmlspecialchars($s['apellido']) ?></strong> -
                <?= htmlspecialchars($s['email']) ?> 
                (desde <?= date("d/m/Y", strtotime($s['fecha_suscripcion'])) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total de suscriptores: <?= count($suscriptores) ?></strong></p>
<?php else: ?>
    <p>No hay suscriptores activos actualmente.</p>
<?php endif; ?>

