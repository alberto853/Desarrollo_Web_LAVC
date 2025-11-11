<?php
include 'conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $fecha_nac = $_POST['fecha_nac'];
    $ciudad = trim($_POST['ciudad']);
    $contrasena = $_POST['contrasena'];

    if (empty($nombre) || empty($correo) || empty($telefono) || empty($fecha_nac) || empty($ciudad) || empty($contrasena)) {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo inválido.";
    } elseif (!preg_match("/^[0-9]{10}$/", $telefono)) {
        $mensaje = "Teléfono debe tener 10 dígitos.";
    } elseif (strlen($contrasena) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Validar fecha
        $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_nac);
        if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha_nac) {
            $mensaje = "Fecha de nacimiento inválida.";
        } else {
            $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $mensaje = "Este correo ya está registrado.";
            } else {
                $hash = password_hash($contrasena, PASSWORD_DEFAULT);
                $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, telefono, fecha_nacimiento, ciudad, contrasena) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $nombre, $correo, $telefono, $fecha_nac, $ciudad, $hash);

                if ($stmt->execute()) {
                    $mensaje = "¡Registro exitoso! <a href='login.php'>Inicia sesión</a>";
                } else {
                    $mensaje = "Error al registrar.";
                }
            }
            $stmt->close();
        }
    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Completo</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Crear Cuenta</h1>
            <p>Completa todos los datos</p>
        </div>
        <div class="form-container">
            <?php if ($mensaje): ?>
                <div class="mensaje <?php echo strpos($mensaje, 'exitoso') !== false ? 'exito' : 'error'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($correo ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($telefono ?? ''); ?>" placeholder="0999999999" pattern="[0-9]{10}" required>
                </div>

                <div class="form-group">
                    <label for="fecha_nac">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nac" id="fecha_nac" value="<?php echo htmlspecialchars($fecha_nac ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" name="ciudad" id="ciudad" value="<?php echo htmlspecialchars($ciudad ?? ''); ?>" placeholder="Guayaquil" required>
                </div>

                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" minlength="6" required>
                </div>

                <button type="submit" class="btn">Registrarse</button>
            </form>

            <div class="enlace">
                <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a> | 
                <a href="index.php">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>