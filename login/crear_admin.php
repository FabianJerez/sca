<?php
require_once __DIR__ . '/../includes/db.php'; // trae $base ya conectado

try {
    // Verificar si ya existe el admin
    $usuario = "admin";
    $email = "admin@sca.com";

    $stmt = $base->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email");
    $stmt->execute([
        ':usuario' => $usuario,
        ':email' => $email
    ]);

    if ($stmt->fetch()) {
        exit("⚠️ El administrador ya existe.");
    }

    // Crear nuevo administrador
    $password_plano = "admin";
    $hash_password = password_hash($password_plano, PASSWORD_DEFAULT);
    $estado = 1;
    $rol = "admin";

    $sql = "INSERT INTO usuarios (usuario, email, hash_password, estado, fecha_inicio, rol)
            VALUES (:usuario, :email, :hash_password, :estado, CURRENT_TIMESTAMP, :rol)";

    $stmt = $base->prepare($sql);
    $stmt->execute([
        ':usuario' => $usuario,
        ':email' => $email,
        ':hash_password' => $hash_password,
        ':estado' => $estado,
        ':rol' => $rol
    ]);

    echo "✅ Administrador creado correctamente.";

} catch (PDOException $e) {
    echo "❌ Error al crear administrador: " . $e->getMessage();
}
?>
