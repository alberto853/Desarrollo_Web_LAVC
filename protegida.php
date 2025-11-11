<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión para mostrar más datos
include 'conexion.php';
$stmt = $conexion->prepare("SELECT nombre, correo, telefono, fecha_nacimiento, ciudad FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$stmt->bind_result($nombre, $correo, $telefono, $fecha_nac, $ciudad);
$stmt->fetch();
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Privada</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <div class="protegida-header">
            <h1>Área Restringida</h1>
            <p>Solo usuarios autenticados</p>
        </div>
        <div class="protegida-body">
            <div class="saludo">
                <strong>Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</strong><br>
                Has iniciado sesión correctamente.
            </div>

            <h3>Tus Datos Registrados</h3>
            <ul style="background: #f8f9fc; padding: 20px; border-radius: 12px; border-left: 5px solid #11998e; margin: 20px 0;">
                <li><strong>Correo:</strong> <?php echo htmlspecialchars($correo); ?></li>
                <li><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></li>
                <li><strong>Fecha de nacimiento:</strong> <?php echo date('d/m/Y', strtotime($fecha_nac)); ?></li>
                <li><strong>Ciudad:</strong> <?php echo htmlspecialchars($ciudad); ?></li>
            </ul>

            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            <br><br>
            <div class="enlace">
                <a href="index.php">Volver al inicio</a>
            </div>
        </div>
    </div>
</body>
</html>