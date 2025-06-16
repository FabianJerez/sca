<?php
session_start();

// Si no está logueado, lo mandamos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login/login.php?redirect=../php/mis_mensajes.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];
$usuario_nombre = $_SESSION["usuario_nombre"];

//conexion a la BD
require("conexion.php");

// Traemos solo los mensajes del usuario actual
$stmt = $conexion->prepare("SELECT * FROM mensajes WHERE remitente = ? ORDER BY fecha DESC");
$stmt->bind_param("s", $usuario_nombre);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis mensajes</title>
    <link rel="stylesheet" href="../css/mis_mensajes.css">
    <link rel="stylesheet" href="../css/headerfooter.css">
</head>
<body>
    <?php include '../header.php'?>
    
    <h2>Mis mensajes enviados</h2>
    <p>Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?></p>
    <a href="../contacto.php">Enviar nuevo mensaje</a> | 
    <a href="../login/logout.php">Cerrar sesión</a>

    <table>
        <tr>
            <th>Asunto</th>
            <th>Mensaje</th>
            <th>Estado</th>
            <th>Respuesta</th>
            <th>Fecha</th>           
        </tr>

        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['asunto']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($fila['mensaje'])); ?></td>
                <td class="<?php echo $fila['estado'] === 'Resuelto' ? 'resuelto' : 'pendiente'; ?>">
                    <?php echo htmlspecialchars($fila['estado']); ?>
                </td>
                <td><?php echo !empty($fila['respuesta']) ? nl2br(htmlspecialchars($fila['respuesta'])) : 'Sin respuesta'; ?></td>
                <td><?php echo $fila['fecha']; ?></td>
            </tr>
        <?php endwhile; ?>

    </table><br><br>

    <!-- <?php include '../footer.php'?> -->
</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
