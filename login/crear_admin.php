<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "sca");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Datos del nuevo administrador
$usuario = "admin";
$email = "admin@sca.com";
$password_plano = "admin";
$hash_password = password_hash($password_plano, PASSWORD_DEFAULT);
$estado = 1;
$rol = "admin";

// Insertar en la tabla
$stmt = $conexion->prepare("INSERT INTO clientes (usuario, email, hash_password, estado, rol) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssis", $usuario, $email, $hash_password, $estado, $rol);

if ($stmt->execute()) {
    echo "✅ Administrador creado correctamente.";
} else {
    echo "❌ Error al crear administrador: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
