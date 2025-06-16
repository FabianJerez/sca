<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if ($_SESSION["rol"] !== "admin") {
    exit("Acceso no autorizado.");
}

$id = $_POST["id"] ?? null;
$rol_actual = $_POST["rol_actual"] ?? '';

if ($id && in_array($rol_actual, ['usuario', 'admin'])) {
    $nuevo_rol = $rol_actual === 'admin' ? 'usuario' : 'admin';

    $sql = "UPDATE usuarios SET rol = :rol WHERE id = :id";
    $stmt = $base->prepare($sql);
    $stmt->execute([':rol' => $nuevo_rol, ':id' => $id]);
}

header("Location: panel_admin.php");
exit();
