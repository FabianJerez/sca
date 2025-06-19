<?php
require_once __DIR__ . '/../../includes/auth.php';

/**
 * Da de baja a suscriptores antiguos del newsletter.
 * Actualmente se da de baja a quienes llevan más de 4 años suscriptos.
 */
function verificarYDarBajaAutomatica(PDO $conn): array {
    $sqlSelect = "
        SELECT id, usuario, email, fecha_suscripcion
        FROM newsletter
        WHERE activo = 1
          AND fecha_suscripcion IS NOT NULL
          AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR)
    ";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->execute();
    $bajas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($bajas)) {
        $sqlUpdate = "
            UPDATE newsletter
            SET activo = 0
            WHERE activo = 1
              AND fecha_suscripcion IS NOT NULL
              AND fecha_suscripcion < (NOW() - INTERVAL 4 YEAR)
        ";
        $conn->exec($sqlUpdate);
    }

    return $bajas;
}

/**
 * Genera un token único para baja de newsletter.
 */
function generarToken($longitud = 32): string {
    return bin2hex(random_bytes($longitud / 2));
}

