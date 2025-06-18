<?php
$modo_embebido = $modo_embebido ?? false;

if (!$modo_embebido) {
    require_once __DIR__ . '/../includes/db.php';
    require_once __DIR__ . '/../includes/auth.php';
}
require_once __DIR__ . '/includes/utils.php';

requireLogin();

if (getUserRole() !== 'admin') {
    exit("Acceso denegado.");
}

// --- Búsqueda ---
$campo = $_GET['campo'] ?? 'nombre_completo';
$buscar = $_GET['buscar'] ?? '';
$condiciones = [];
$parametros = [];

if (!empty($buscar)) {
    if ($campo === 'nombre_completo') {
        $condiciones[] = "CONCAT(nombre, ' ', apellido) LIKE ?";
        $parametros[] = "%$buscar%";
    } elseif ($campo === 'email') {
        $condiciones[] = "email LIKE ?";
        $parametros[] = "%$buscar%";
    }
}

// --- Consulta ---
$sql = "SELECT id, nombre, apellido, email, activo, fecha_suscripcion FROM newsletter";

if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}

$sql .= " ORDER BY fecha_suscripcion DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($parametros);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Listado de suscripciones al newsletter</h2>

<form method="GET" action="../panel.php" style="margin-bottom: 15px;">
    <input type="hidden" name="seccion" value="newsletter">
    <input type="hidden" name="sub" value="suscriptos">

    <label for="campo">Buscar por:</label>
    <select name="campo" id="campo">
        <option value="nombre_completo" <?= $campo === 'nombre_completo' ? 'selected' : '' ?>>Nombre completo</option>
        <option value="email" <?= $campo === 'email' ? 'selected' : '' ?>>Email</option>
    </select>

    <input type="text" name="buscar" value="<?= htmlspecialchars($buscar) ?>" placeholder="Buscar..." required>
    <button type="submit">Buscar</button>

    <a href="../panel.php?seccion=newsletter&sub=suscriptos">Limpiar</a>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Fecha de suscripción</th>
        <th>Estado</th>
        <th>Alta/Baja</th>
    </tr>

    <?php foreach ($usuarios as $u) : ?>
        <tr>
            <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['fecha_suscripcion'] ? date("d/m/Y", strtotime($u['fecha_suscripcion'])) : '-' ?></td>
            <td><?= $u['activo'] ? 'Activo' : 'Inactivo' ?></td>
            <td>
                <?php if ($u['activo']) : ?>
                    <a href="dar_baja_newsletter.php?id=<?= $u['id'] ?>" onclick="return confirm('¿Dar de baja a este usuario del newsletter?')">Desuscribir</a>
                <?php else : ?>
                    <a href="dar_alta_newsletter.php?id=<?= $u['id'] ?>" onclick="return confirm('¿Reactivar la suscripción al newsletter?')">Suscribir</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
