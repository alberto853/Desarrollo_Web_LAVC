<?php
session_start();
include 'conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    if (empty($correo) || empty($contrasena)) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conexion->prepare("SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $nombre, $hash);
            $stmt->fetch();
            if (password_verify($contrasena, $hash)) {
                $_SESSION['usuario_id'] = $id;
                $_SESSION['usuario_nombre'] = $nombre;
                header("Location: protegida.php");
                exit();
            } else {
                $mensaje = "Contrasena incorrecta.";
            }
        } else {
            $mensaje = "Correo no registrado.";
        }
        $stmt->close();
    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Iniciar Sesion</h1>
            <p>Accede a tu cuenta</p>
        </div>
        <div class="form-container">
            <?php if ($mensaje): ?>
                <div class="mensaje error"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" id="correo" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contrasena</label>
                    <input type="password" name="contrasena" id="contrasena" required>
                </div>
                <button type="submit" class="btn">Iniciar Sesion</button>
            </form>
            <div class="enlace">
                <a href="registro.php">No tienes cuenta? Registrate</a> | 
                <a href="index.php">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>