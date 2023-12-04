<main class="contenedor seccion">
  <h1>Crear Usuario</h1>
  <?php foreach($errores as $error){ ?>
        <div class="alerta error">
            <?php echo $error;?>
        </div>
    <?php }?>
  <form class="formulario" method="POST">
    <?php include __DIR__ . "/formulario.php" ?>
    <input type="submit" value="Crear Usuario(a)" class="boton boton-verde">
  </form>
  <a href="/admin/usuarios" class="boton boton-amarillo">Volver</a>
</main>