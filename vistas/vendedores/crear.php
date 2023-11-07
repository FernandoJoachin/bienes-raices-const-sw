<main class="contenedor seccion">
  <h1>Crear Vendedor</h1>

  <?php foreach ($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach ?>
  <form class="formulario" method="POST">
    <?php include __DIR__ . "/formulario.php" ?>
    <input type="submit" value="Crear Vendedor" class="boton boton-verde">
  </form>
  <a href="/admin" class="boton boton-amarillo">Volver</a>

</main>