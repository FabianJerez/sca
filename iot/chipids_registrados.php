<?php
require_once __DIR__ . '/../includes/db.php';

// Solo accesible si hay sesión iniciada y rol definido
$usuario = $_SESSION['usu'] ?? null;

if (!$usuario) {
    echo "<p>Error: No se pudo determinar el usuario actual.</p>";
    return;
}

// Consulta de chipids registrados por usuario
$sql = "SELECT id, usuario, descripcion, chipid FROM chipids WHERE usuario = :usuario ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([':usuario' => $usuario]);
$chipids = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>ChipIDs registrados por el usuario</h2>

<table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; width: 100%; max-width: 800px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Descripción</th>
            <th>ChipID</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($chipids) === 0): ?>
            <tr><td colspan="4">No se encontraron chipids registrados.</td></tr>
        <?php else: ?>
            <?php foreach ($chipids as $chip): ?>
                <tr>
                    <td><?= htmlspecialchars($chip['id']) ?></td>
                    <td><?= htmlspecialchars($chip['usuario']) ?></td>
                    <td><?= htmlspecialchars($chip['descripcion']) ?></td>
                    <td><?= htmlspecialchars($chip['chipid']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
