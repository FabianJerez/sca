<?php
// Asegurarse de que $base y $_SESSION['usu'] ya estén definidos en panel.php

$usuario = $_SESSION['usu'] ?? null;
$chipid_seleccionado = isset($_GET['chipid']) && $_GET['chipid'] !== '' 
    ? filter_var($_GET['chipid'], FILTER_SANITIZE_STRING) 
    : null;

$chips = [];
$error = null;

if ($usuario) {
    try {
        $sql = "SELECT id, usuario, descripcion, chipid 
                FROM chipids 
                WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $chips = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error al consultar chipids: " . htmlspecialchars($e->getMessage());
    }
}
?>

<section class="s4">
    <h2>Chips Registrados</h2>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!empty($chips)): ?>
        <form method="get" class="filter-form">
            <input type="hidden" name="seccion" value="iot">
            <input type="hidden" name="sub" value="<?= htmlspecialchars($_GET['sub'] ?? '') ?>">
            
            <label for="chipid">Seleccionar ChipID:</label>
            <select name="chipid" id="chipid">
                <option value="">Todos</option>
                <?php foreach ($chips as $chip): ?>
                    <option value="<?= htmlspecialchars($chip['chipid']) ?>" 
                        <?= $chipid_seleccionado === $chip['chipid'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($chip['descripcion'] . ' (' . $chip['chipid'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>USUARIO</th>
                <th>DESCRIPCIÓN</th>
                <th>CHIPID</th>
            </tr>
            <?php foreach ($chips as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['id']) ?></td>
                    <td><?= htmlspecialchars($fila['usuario']) ?></td>
                    <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                    <td><?= htmlspecialchars($fila['chipid']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay chips registrados para este usuario.</p>
    <?php endif; ?>
</section>
