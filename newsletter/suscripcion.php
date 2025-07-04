<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/includes/utils.php';

requireLogin(); // Cualquier usuario logueado puede suscribirse

$usuario_id = getUserId();
$usuario = $_SESSION['usuario_nombre'] ?? 'Desconocido';
$email = $_SESSION['email'] ?? '';

if (!$email) {
    exit("Error: no se encontró el email del usuario.");
}

// Verificar si ya está suscripto
$stmt = $conn->prepare("SELECT * FROM newsletter WHERE email = ?");
$stmt->execute([$email]);
$suscriptor = $stmt->fetch(PDO::FETCH_ASSOC);

$yaSuscripto = $suscriptor && $suscriptor['activo'] == 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$yaSuscripto) {
    $token = generarToken();

    if ($suscriptor) {
        // Si ya existía pero estaba inactivo, reactivamos
        $stmt = $conn->prepare("UPDATE newsletter SET activo = 1, fecha_suscripcion = NOW(), token = ? WHERE email = ?");
        $stmt->execute([$token, $email]);
    } else {
        // Alta nueva
        $stmt = $conn->prepare("INSERT INTO newsletter (usuario, email, token, activo, fecha_suscripcion) VALUES (?, ?, ?, 1, NOW())");
        $stmt->execute([$usuario, $email, $token]);
    }

    $mensaje = "Te suscribiste al newsletter correctamente.";
    $yaSuscripto = true;
}
?>

<h2>Suscripción al Newsletter de SCA</h2>
<br>
<?php if (isset($mensaje)) : ?>
    <p style="color:green;"><strong><?= htmlspecialchars($mensaje) ?></strong></p>
<?php endif; ?>

<?php if ($yaSuscripto): ?>
    <br>
    <p>Ya estás suscripto al newsletter con el correo <strong><?= htmlspecialchars($email) ?></strong>.</p>
<?php else: ?>
    <form method="POST">
        <p>¿Querés recibir noticias y novedades por correo electrónico?</p>
        <br>
        <button type="submit">Suscribirme</button>
    </form>
<?php endif; ?>


