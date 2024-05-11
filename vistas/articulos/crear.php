<main class="contenedor seccion">
  <h1>Crear Artículo</h1>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach; ?>

  <form class="formulario" method="POST" enctype="multipart/form-data">
    <?php include_once __DIR__ . "/formulario.php" ?>
    <input type="submit" value="Crear Artículo" class="boton boton-verde">
  </form>
  <a href="/admin/articulos" class="boton boton-amarillo">Volver</a>
</main>