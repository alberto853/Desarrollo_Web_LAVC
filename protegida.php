<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
$stmt = $conexion->prepare("SELECT nombre, correo, telefono, fecha_nacimiento, ciudad FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$stmt->bind_result($nombre, $correo, $telefono, $fecha_nac, $ciudad);
$stmt->fetch();
$stmt->close();
$conexion->close();

/** Formateo seguro de fecha (opcional) */
$fecha_formateada = $fecha_nac ? date('d/m/Y', strtotime($fecha_nac)) : 'N/D';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Privada - Deportes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <div class="container">

    <!-- Encabezado -->
    <div class="protegida-header">
      <h1>Contenido de la Página</h1>
      <p>Bienvenido, <strong><?php echo htmlspecialchars($nombre); ?></strong></p>
    </div>

    <!-- Panel / Marco para contenido -->
    <div class="panel">

      <!-- (Opcional) Datos del usuario -->
      <section class="datos-usuario">
        <h2>Tus datos</h2>
        <ul class="lista-datos">
          <li><strong>Correo:</strong> <?php echo htmlspecialchars($correo); ?></li>
          <li><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></li>
          <li><strong>Fecha de nacimiento:</strong> <?php echo htmlspecialchars($fecha_formateada); ?></li>
          <li><strong>Ciudad:</strong> <?php echo htmlspecialchars($ciudad); ?></li>
        </ul>
      </section>

      <!-- Galería de Deportes -->
      <section class="galeria-deportes">
        <h2>Nuestros Deportes</h2>

        <div class="deportes-grid">

          <!-- Tenis -->
          <article class="deporte-card">
            <img src="imagenes/tenis.png" alt="Tenis" class="deporte-img">
            <div class="deporte-info">
              <h3>Tenis</h3>
              <p>
                Deporte de raqueta que se juega en una cancha rectangular dividida por una red.
                Puede practicarse individualmente (singles) o en parejas (dobles).
                Requiere agilidad, precisión y estrategia.
              </p>
            </div>
          </article>

          <!-- Culturismo -->
          <article class="deporte-card">
            <img src="imagenes/culturismo.png" alt="Culturismo" class="deporte-img">
            <div class="deporte-info">
              <h3>Culturismo</h3>
              <p>
                Disciplina enfocada en el desarrollo muscular mediante entrenamiento con pesas y dieta.
                Se compite con poses que resaltan definición, simetría y masa muscular.
              </p>
            </div>
          </article>

          <!-- Básquetbol -->
          <article class="deporte-card">
            <img src="imagenes/basket.png" alt="Básquetbol" class="deporte-img">
            <div class="deporte-info">
              <h3>Básquetbol</h3>
              <p>
                Deporte de equipo disputado por dos conjuntos de cinco jugadores.
                El objetivo es encestar en el aro contrario. Combina velocidad, salto,
                coordinación y trabajo en equipo.
              </p>
            </div>
          </article>

        </div>
      </section>

      <!-- Acciones -->
      <div class="acciones">
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        <a href="index.php" class="btn">Volver al Inicio</a>
      </div>


  </div><!-- /container -->
</body>
</html>
