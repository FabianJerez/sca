<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

require_once __DIR__ . '/../includes/db.php';

$estado_filtro = $_GET['estado'] ?? '';
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$por_pagina = 5;
$offset = ($pagina - 1) * $por_pagina;

$condiciones = [];
$params = [];

if ($estado_filtro === 'Pendiente' || $estado_filtro === 'Resuelto') {
    $condiciones[] = "estado = ?";
    $params[] = $estado_filtro;
}

$where = count($condiciones) ? 'WHERE ' . implode(' AND ', $condiciones) : '';

// Total de mensajes
$sql_count = "SELECT COUNT(*) FROM mensajes $where";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->execute($params);
$total_mensajes = $stmt_count->fetchColumn();
$total_paginas = ceil($total_mensajes / $por_pagina);

// Obtener mensajes paginados
$sql = "SELECT * FROM mensajes $where ORDER BY fecha DESC LIMIT $por_pagina OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$resultado = $stmt;
?>

<h2>Mensajes Recibidos</h2>
<p>Usuario logueado: <strong><?= htmlspecialchars($_SESSION["usuario_nombre"]); ?></strong></p>

<form method="get" action="<?= BASE_URL ?>panel.php">
    <input type="hidden" name="seccion" value="mensajes">
    <input type="hidden" name="sub" value="ver">
    <label for="estado">Filtrar por estado:</label>
    <select name="estado" id="estado">
        <option value="">-- Todos --</option>
        <option value="Pendiente" <?= $estado_filtro === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
        <option value="Resuelto" <?= $estado_filtro === 'Resuelto' ? 'selected' : '' ?>>Resuelto</option>
    </select>
    <button type="submit">Aplicar</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Remitente</th>
        <th>Asunto</th>
        <th>Email</th>
        <th>Mensaje</th>
        <th>Archivo</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Responder</th>
        <th>Respuesta</th>
    </tr>

    <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) : ?>
        <tr>
            <td><?= $fila['id']; ?></td>
            <td><?= htmlspecialchars($fila['remitente']); ?></td>
            <td><?= htmlspecialchars($fila['asunto']); ?></td>
            <td><?= htmlspecialchars($fila['email']); ?></td>
            <td><?= nl2br(htmlspecialchars($fila['mensaje'])); ?></td>
            <td>
                <?php if (!empty($fila['archivo_nombre'])): ?>
                    <a href="<?= BASE_URL ?>uploads/<?= rawurlencode($fila['archivo_nombre']) ?>" target="_blank">Ver archivo</a>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
            <td class="<?= $fila['estado'] === 'Resuelto' ? 'estado-resuelto' : 'estado-pendiente'; ?>">
                <?php if ($fila['estado'] === 'Resuelto'): ?>
                    Resuelto
                <?php else: ?>
                    <a href="cambiar_estado.php?id=<?= $fila['id'] ?>">Marcar como Resuelto</a>
                <?php endif; ?>
            </td>
            <td><?= $fila['fecha']; ?></td>
            <td><a href="panel.php?seccion=mensajes&sub=responder&id=<?= $fila['id'] ?>">Responder</a></td>
            <td><?= !empty($fila['respuesta']) ? nl2br(htmlspecialchars($fila['respuesta'])) : '—'; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<?php if ($total_paginas > 1): ?>
    <div class="paginacion" style="margin-top: 20px;">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="panel.php?seccion=mensajes&sub=ver&pagina=<?= $i ?><?= $estado_filtro ? '&estado=' . urlencode($estado_filtro) : '' ?>"
               style="<?= $i == $pagina ? 'font-weight: bold; text-decoration: underline;' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

