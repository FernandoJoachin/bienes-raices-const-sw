<main class="contenedor seccion">
  <h1>Actualizar Artículo</h1>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach; ?>

  <form class="formulario" method="POST" enctype="multipart/form-data">
    <?php include __DIR__ . "/formulario.php" ?>
    <input type="submit" value="Actualizar Artículo" class="boton boton-verde">
  </form>
  <a href="/admin/articulos" class="boton boton-amarillo">Volver</a>
</main>