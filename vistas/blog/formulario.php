<fieldset>
  <legend>Información del Artículo</legend>

  <label for="titulo">Titulo:</label>
  <input type="text" id="titulo" name="articulo[titulo]" placeholder="Titulo del artículo" value="<?php echo limpiarHTML($articulo->titulo); ?>">

  <label for="imagen">Imagen:</label>
  <input type="file" id="imagen" accept="image/jpeg, image/png" name="articulo[imagen]">

  <?php if ($articulo->imagen) : ?>
    <img class="image-small" src="/imagenes/<?php echo $articulo->imagen ?>">
  <?php endif; ?>

  <label for="descripcion">Descripción:</label>
  <textarea id="descripcion" name="articulo[descripcion]"><?php echo limpiarHTML($articulo->descripcion); ?></textarea>

  <label for="contenido">Contenido:</label>
  <textarea id="contenido" name="articulo[contenido]"><?php echo limpiarHTML($articulo->contenido); ?></textarea>
</fieldset>

<fieldset>
  <legend>Información adicional del Artículo</legend>

  <label for="autor">Autor:</label>
  <input type="text" id="autor" name="articulo[autor]" placeholder="Ingrese nombre del autor" value="<?php echo limpiarHTML($articulo->autor); ?>">
</fieldset>