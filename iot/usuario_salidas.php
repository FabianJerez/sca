<?php
// Asegurarse de que $base y $_SESSION['usu'] ya estén definidos en panel.php

$chipid = isset($_GET['chipid']) && $_GET['chipid'] !== '' 
    ? filter_var($_GET['chipid'], FILTER_SANITIZE_STRING) 
    : null;
?>

<section class="s3">
    <h2>Manejo de Salidas</h2>

    <?php if ($chipid): ?>
        <p>Modificar salidas para el CHIP ID: <strong><?= htmlspecialchars($chipid) ?></strong></p>

        <div class="actions">
            <a href="../iot/chipid_modificar_salidas.php?chipid=<?= urlencode($chipid) ?>" class="action-btn">
                Ir al Control de Salidas
            </a>
        </div>
    <?php else: ?>
        <p>Por favor, selecciona un ChipID antes de acceder al manejo de salidas.</p>
    <?php endif; ?>
</section>
