<main class="contenedor seccion contenido-centrado">
  <h1>Restablecer Contraseña</h1>

  <?php foreach ($errores as $error) { ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php } ?>

  <form class="formulario" method="POST">
    <fieldset>
      <legend>Contraseña</legend>

      <label for="password">Contraseña</label>
      <input id="password" type="password" name="password" placeholder="Tu Contraseña">
    </fieldset>
    <input class="boton boton-verde" type="submit" value="Restablecer contraseña">
  </form>
</main>