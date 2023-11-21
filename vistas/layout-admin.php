<?php
if (!isset($_SESSION)) {
  session_start();
}
$auth = $_SESSION["login"] ?? false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preload" href="/build/css/admin-app.css" as="style">
  <link rel="stylesheet" href="/build/css/admin-app.css">
  <title>Bienes raices | Dashboard</title>
</head>

<body class="dashboard">

  <header class="dashboard__header">
    <div class="dashboard__barra">
      <a href="/">
        <img src="/build/img/logo.svg" alt="Logo">
      </a>

      <div id="mobile-menu" class="dashboard__mobile-menu">
        <img src="/build/img/barras.svg" alt="icono de menu responsive">
      </div>

      <div id="navegacion" class="dashboard__header-contenido">
        <p class="dashboard__bienvenida">Bienvenido, <span class="dashboard__bienvenida--nombre">Admin</span></p>
        <img id="dark-mode-boton" class="dashboard__dark-mode-btn" src="/build/img/dark-mode.svg" alt="dark mode">
        <?php if (true) { ?>
          <a class="dashboard__logout" href="/cerrar-sesion">Cerrar Sesión</a>
        <?php } ?>
      </div>
    </div>
  </header>

  <div class="dashboard__grid">
    <?php
    include_once __DIR__ . '/admin/sidebar.php';
    ?>

    <main class="dashboard__contenido">
      <?php
      echo $contenido;
      ?>
    </main>
  </div>

  <script src="/build/js/bundle.min.js"></script>
</body>

</html>